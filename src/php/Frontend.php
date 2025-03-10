<?php
/**
 * Front.
 */

namespace Art\BotFilter;

class Frontend {

	protected Main $main;


	public function __construct( Main $main ) {

		$this->main = $main;
	}


	/**
	 * Инициализация хуков
	 *
	 * @since 2.3.6
	 */
	public function init_hooks(): void {

		add_filter( 'wp_footer', [ $this, 'filter_template' ], 1000 );
	}


	public function filter_template(): void {


		load_template(
			$this->main->get_template( 'modal.php' ),
			false,
			[]
		);
	}
}
