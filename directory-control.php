<?php
/*
Plugin Name:  Directory Control
Description:  Specify the location of the uploads and themes directories
Version:      1.1.1
Author:       John Blackbourn
Author URI:   https://johnblackbourn.com/
Network:      true

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

---

The Directory Control plugin was originally commissioned by Daft Media for TheJournal.ie

---

Usage:      Define the WP_UPLOAD_DIR, WP_UPLOAD_URL, and WP_THEME_DIR constants in
            your wp-config.php file to override the upload directory, upload URL and
            theme directory respectively.

Background: WordPress does not have a WP_UPLOAD_DIR constant. The UPLOADS constant
            does not perform as expected and is always prepended with ABSPATH, meaning
			it is impossible to use a root directory for uploads if WordPress is
			installed in its own directory. This plugin fixes that by introducing
			WP_UPLOAD_DIR and WP_UPLOAD_URL constants. Define these constants in your
			wp-config file and their value will override the default upload directory.

            WordPress does not have a WP_THEME_DIR constant. Themes can only be present
			in WP_CONTENT_DIR/themes. This plugin fixes that by introducing
			WP_THEME_DIR and WP_THEME_URL constants. Define these constants in your
			wp-config file and their value will override the default theme directory.

*/

function directory_control_uploads( $uploads ) {
	if ( defined( 'WP_UPLOAD_DIR' ) ) {
		$uploads['path']    = str_replace( WP_CONTENT_DIR . '/uploads', WP_UPLOAD_DIR, $uploads['path'] );
		$uploads['basedir'] = str_replace( WP_CONTENT_DIR . '/uploads', WP_UPLOAD_DIR, $uploads['basedir'] );
	}
	if ( defined( 'WP_UPLOAD_URL' ) ) {
		$uploads['url']     = str_replace( WP_CONTENT_URL . '/uploads', WP_UPLOAD_URL, $uploads['url'] );
		$uploads['baseurl'] = str_replace( WP_CONTENT_URL . '/uploads', WP_UPLOAD_URL, $uploads['baseurl'] );
	}
	return $uploads;
}

function directory_control_theme_dir( $dir ) {
	if ( defined( 'WP_THEME_DIR' ) ) {
		$dir = str_replace( WP_CONTENT_DIR . '/themes', WP_THEME_DIR, $dir );
	}
	return $dir;
}

function directory_control_theme_url( $url ) {
	if ( defined( 'WP_THEME_URL' ) ) {
		$search  = set_url_scheme( WP_CONTENT_URL . '/themes' );
		$replace = set_url_scheme( WP_THEME_URL );
		$url = str_replace( $search, $replace, $url );
	}
	return $url;
}

add_filter( 'upload_dir',     'directory_control_uploads', 1 );
add_filter( 'theme_root',     'directory_control_theme_dir', 1 );
add_filter( 'theme_root_uri', 'directory_control_theme_url', 1 );
