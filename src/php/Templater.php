<?php
/**
 * Подключение файлов
 */

namespace Art\BotFilter;

class Templater {

	/**
	 * @param  string $template_name
	 *
	 * @return string
	 */
	public function get_template( string $template_name ): string {

		$template_path = locate_template( $this->template_path() . $template_name );

		if ( ! $template_path ) {
			$template_path = sprintf( '%s/templates/%s', $this->plugin_path(), $template_name );
		}

		return apply_filters( 'abt_locate_template', $template_path );
	}


	/**
	 * @return string
	 */
	public function template_path(): string {

		return apply_filters( 'abt_template_path', 'art-bot-filter/' );
	}


	/**
	 * @return string
	 */
	public function plugin_path(): string {

		return untrailingslashit( Utils::get_plugin_path() );
	}


	/**
	 * @return string
	 */
	public function plugin_url(): string {

		return untrailingslashit( plugins_url( '/', Utils::get_plugin_basename() ) );
	}
}
