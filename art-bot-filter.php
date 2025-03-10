<?php
/**
 * Plugin Name: Art Bot Filter
 * Plugin URI: wpruse.ru
 * Text Domain: art-bot-filter
 * Domain Path: /languages
 * Description: Фильтрация ботов по куке
 * Version: 1.0.0
 * Author: Artem Abramovich
 * Author URI: https://wpruse.ru/
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 *
 * RequiresWP: 6.0
 * RequiresPHP: 8.0
 *
 * Copyright Artem Abramovich
 *
 * @source https://github.com/ak-alz/pts-lazyload/tree/v2.1
 */

const ABT_PLUGIN_DIR    = __DIR__;
const ABT_PLUGIN_AFILE  = __FILE__;
const ABT_PLUGIN_VER    = '1.0.0';
const ABT_PLUGIN_NAME   = 'Art Bot Filter';
const ABT_PLUGIN_SLUG   = 'art-bot-filter';
const ABT_PLUGIN_PREFIX = 'abf';

define( 'ABT_PLUGIN_URI', untrailingslashit( plugin_dir_url( ABT_PLUGIN_AFILE ) ) );
define( 'ABT_PLUGIN_FILE', plugin_basename( __FILE__ ) );

require ABT_PLUGIN_DIR . '/vendor/autoload.php';

if ( ! function_exists( 'abf' ) ) {

	function abf(): object {

		return \Art\BotFilter\Main::instance();
	}
}

( new \Art\BotFilter\Main() )->init();
