<?php
/**
 * Файл обработки скриптов и стилей
 */

namespace Art\BotFilter;

/**
 * Class Enqueue
 *
 * @author Artem Abramovich
 * @since  2.3.6
 * @since  3.0.0
 */
class Enqueue {

	protected string $suffix;


	protected Main $main;


	/**
	 * @var string[]
	 */
	protected array $handles;


	public function __construct( $main ) {

		$this->main   = $main;
		$this->suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$this->handles = [
			'style'  => Utils::get_plugin_prefix() . '-public-style',
			'script' => Utils::get_plugin_prefix() . '-public-script',
		];
	}


	public function init_hooks(): void {

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ], 20 );
		add_action( 'wp_enqueue_scripts', [ $this, 'localize' ], 110 );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue' ] );
	}


	public function enqueue(): void {

		wp_enqueue_script(
			$this->handles['script'],
			sprintf( '%s/assets/js/%s%s.js', Utils::get_plugin_url(), $this->handles['script'], $this->suffix ),
			[ 'jquery','wp-util' ],
			Utils::get_plugin_version(),
			[
				'in_footer' => false,
				'strategy'  => 'async',
			]
		);

		wp_enqueue_style(
			$this->handles['style'],
			sprintf( '%s/assets/css/%s%s.css', Utils::get_plugin_url(), $this->handles['style'], $this->suffix ),
			[],
			Utils::get_plugin_version()
		);
	}


	public function admin_enqueue(): void {}


	public function localize(): void {

		if ( is_admin() ) {
			return;
		}

		wp_localize_script(
			$this->handles['script'],
			'afbScriptObject',
			apply_filters(
				'abf_filter_scripts',
				[
					'cookieName' => 'abf_bot_verified',
					'modalText'   => 'Пожалуйста, подтвердите, что вы не робот',
					'hasLoggedAdmin'  => is_user_logged_in() && current_user_can('administrator'),
					'cookieTime'  => 365,
					'counters'    => [
						[
							'html' => '<script>console.log("Скрипт 1 загружен после проверки")</script>',
							'area' => 'head',
						],
						[
							'html' => '<script>console.log("Скрипт 2 загружен после проверки")</script>',
							'area' => '.before-footer-scripts-place',
						],
					],
				]
			)
		);
	}
}
