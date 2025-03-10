<?php

namespace Art\BotFilter;

class Main {

	protected Utils $utils;


	/**
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private static ?Main $instance = null;


	/**
	 * @var \Art\BotFilter\Templater
	 */
	protected Templater $templater;


	public static function instance(): ?Main {

		if ( is_null( self::$instance ) ) :
			self::$instance = new self();
		endif;

		return self::$instance;
	}


	/*public function __construct() {

		$this->init_all();
	}*/


	public function init(): void {

		add_action( 'plugins_loaded', [ $this, 'init_all' ], - PHP_INT_MAX );
	}


	public function init_all(): void {

		$this->init_classes();
		$this->init_condition_classes();
		$this->init_hooks();
	}


	public function init_classes(): void {

		$this->utils     = new Utils();
		$this->templater = new Templater();

		( new Enqueue( $this ) )->init_hooks();
		( new Frontend( $this ) )->init_hooks();
	}


	public function init_condition_classes(): void {}


	public function init_hooks(): void {}


	/**
	 * @return \Art\BotFilter\Templater
	 */
	public function get_templater(): Templater {

		return $this->templater;
	}


	public function get_template( string $template_name ): string {

		return $this->get_templater()->get_template( $template_name );
	}
}
