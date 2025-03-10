<?php

namespace Art\BotFilter;

/**
 * Class Utils
 */
class Utils {

	/**
	 * Get plugin path.
	 *
	 * @return string
	 */
	public static function get_plugin_path(): string {

		return constant( 'ABT_PLUGIN_DIR' );
	}


	/**
	 * Get plugin version.
	 *
	 * @return string
	 */
	public static function get_plugin_version(): string {

		return constant( 'ABT_PLUGIN_VER' );
	}


	/**
	 * Get plugin URL.
	 *
	 * @return string
	 */
	public static function get_plugin_url(): string {

		return constant( 'ABT_PLUGIN_URI' );
	}


	/**
	 * Get plugin slug.
	 *
	 * @return string
	 */
	public static function get_plugin_slug(): string {

		return constant( 'ABT_PLUGIN_SLUG' );
	}


	/**
	 * Get plugin file.
	 *
	 * @return string
	 */
	public static function get_plugin_file(): string {

		return constant( 'ABT_PLUGIN_AFILE' );
	}


	/**
	 * Get plugin base name.
	 *
	 * @return string
	 */
	public static function get_plugin_basename(): string {

		return plugin_basename( ABT_PLUGIN_FILE );
	}


	/**
	 * Get plugin title.
	 *
	 * @return string
	 */
	public static function get_plugin_title(): string {

		return constant( 'ABT_PLUGIN_NAME' );
	}


	/**
	 * Get plugin prefix.
	 *
	 * @return string
	 */
	public static function get_plugin_prefix(): string {

		return constant( 'ABT_PLUGIN_PREFIX' );
	}
}
