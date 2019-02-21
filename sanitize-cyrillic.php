<?php
/*
Plugin Name: Sanitize Cyrillic
Plugin URI: http://wordpress.org/plugins/sanitize-cyrillic/
Description: Plugin replaces Cyrillic characters in the names of uploaded files and url addresses pages and posts.
Version: 1.2.2
Author: Sergey Kuzmich
Author URI: http://kuzmi.ch
License: GPLv3
*/

/**
 * @package sanitize Cyrillic
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

add_filter( 'sanitize_file_name', 'sanitize_cyrillic_file_name', 10, 3 );
function sanitize_cyrillic_file_name( $name, $name_raw ) {
	preg_match( '/(\.[a-zA-Z0-9]+)+$/i', $name, $matches );
	$ext       = $matches[0];
	$base_name = sanitize( wp_basename( $name, $ext ) );

	return $base_name . $ext;
}

add_filter( 'sanitize_title', 'sanitize_cyrillic_title', 10, 3 );
function sanitize_cyrillic_title( $title, $raw_title, $context ) {
	$title = urldecode( $title );
	if ( 'save' === $context ) {
			$title = remove_accents( $title );
	}
	$title = sanitize( $title );

	return $title;
}

/**
 * @param $name
 * @return string
 */
function sanitize( $name ) {
	$cyr = array( 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я' );
	$lat = array( 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sch', '', 'y', '', 'e', 'ju', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'E', 'Zh', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Sch', '', 'Y', '', 'E', 'Ju', 'Ya' );

	$output = str_replace( $cyr, $lat, $name );
	$output = preg_replace( '/[^\-_a-zA-Z0-9]/i', '-', $output );

	return $output;
}
