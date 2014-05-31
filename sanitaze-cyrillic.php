<?php
/*
Plugin Name: Sanitize Cyrillic
Plugin URI: http://umnyj.com
Description: Plugin replaces Cyrillic characters in the names of uploaded files and url addresses pages and posts.
Version: 1.0.0
Author: Sergey Kuzmich
Author URI: http://kuzmi.ch
License: GPLv2
*/

/**
 * @package Sanitaze Cyrillic
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once 'functions.php';

add_filter( 'wp_handle_upload_prefilter', 'sanitize_cyrillic_file_name' );  
function sanitize_cyrillic_file_name( $file ) {
	preg_match('%\.[^.\\\\/:*?"<>|\r\n]+$%i', $file['name'], $matches);
	$ext = $matches[0];
	$name = sanitaze_filename(basename($file['name'], $ext));
	$file['name'] = $name . $ext;

    return $file;
}

add_filter('sanitize_title', 'sanitize_cyrillic_title', 10, 3);
function sanitize_cyrillic_title($title, $raw_title, $context) {
    $title = urldecode($title);
	if ( 'save' == $context ) {
		$title = remove_accents($title);
	}
	$title = sanitaze_filename($title);

	return $title;
}


