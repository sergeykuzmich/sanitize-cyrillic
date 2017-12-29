<?php
/*
Plugin Name: Sanitize Cyrillic
Plugin URI: http://wordpress.org/plugins/sanitize-cyrillic/
Description: Plugin replaces Cyrillic characters in the names of uploaded files and url addresses pages and posts.
Version: 1.0.1
Author: Sergey Kuzmich
Author URI: http://kuzmi.ch
License: GPLv2
*/

/**
 * @package Sanitaze Cyrillic
 */

if (!defined('WPINC')) {
    die;
}

add_filter('sanitize_file_name', 'sanitize_cyrillic_file_name', 10, 2);
function sanitize_cyrillic_file_name($file)
{
    preg_match('%\.[^.\\\\/:*?"<>|\r\n]+$%i', $file['name'], $matches);
    $ext = $matches[0];
    $name = sanitaze(basename($file['name'], $ext));
    $file['name'] = $name . $ext;

    return $file;
}

add_filter('sanitize_title', 'sanitize_cyrillic_title', 10, 3);
function sanitize_cyrillic_title($title, $raw_title, $context)
{
    $title = urldecode($title);
    if ('save' == $context) {
        $title = remove_accents($title);
    }
    $title = sanitaze($title);

    return $title;
}

/**
 * @param $name
 * @return string
 */
function sanitaze($name)
{

    $cyr = array(
        'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я');

    $lat = array(
        'a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sch', '', 'y', '', 'e', 'ju', 'ya',
        'a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sch', '', 'y', '', 'e', 'ju', 'ya');

    $output = str_replace($cyr, $lat, $name);
    $output = preg_replace('%[^\-_a-zA-Z0-9]%i', '-', $output);

    return $output;
}
