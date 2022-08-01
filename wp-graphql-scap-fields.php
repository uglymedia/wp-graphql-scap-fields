<?php
/**
 * Plugin Name: WP Graph QL SCAP Fields
 * Plugin URI: https://www.uglymedia.com/
 * Description: An extension to WP Graph QL to include the Simple Custom Author Profiles fields.
 * Version: 1.0.0
 * Author: Ugly Media
 * Author URI: https://www.uglymedia.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: wp-graphql-scap-fields
 * Domain Path: languages
 *
 * Custom Author Profiles allows you to add additional fields to an author/user profile
 * Copyright (C) 2022  Ugly Media Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

use scap_graphql\libraries\field_list;
use scap_graphql\libraries\loader;

define( 'UM_CAP_GRAPHQL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'UM_CAP_GRAPHQL_INCLUDE_DIR', plugin_dir_path( __FILE__ ) . "libraries" . DIRECTORY_SEPARATOR );

require_once UM_CAP_GRAPHQL_INCLUDE_DIR . "field_list.php";
require_once UM_CAP_GRAPHQL_INCLUDE_DIR . "loader.php";
require_once UM_CAP_GRAPHQL_INCLUDE_DIR . "resolver.php";

field_list::init();

add_action(
	'graphql_register_types',
	[loader::class, 'load'],
	9,
	0
);
