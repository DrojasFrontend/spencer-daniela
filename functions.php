<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

define('URL_BASE', get_stylesheet_directory_uri() . '/');
define('IMG_BASE', URL_BASE . 'img/');

// register webpack compiled js and css with theme
function enqueue_webpack_scripts() {
  
    $cssFilePath = glob( get_template_directory() . '/css/build/main.min.*.css' );
    $cssFileURI = get_template_directory_uri() . '/css/build/' . basename($cssFilePath[0]);
    wp_enqueue_style( 'main_css', $cssFileURI );

    $jsFilePath = glob( get_template_directory() . '/js/build/main.min.*.js' );
    $jsFileURI = get_template_directory_uri() . '/js/build/' . basename($jsFilePath[0]);
    wp_enqueue_script( 'main_js', $jsFileURI , null , null , true );
}

add_action( 'wp_enqueue_scripts', 'enqueue_webpack_scripts' );

function my_wpcf7_form_elements( $html ) {
    return preg_replace('/<br\s*\/?>/i', '', $html);
}
add_filter('wpcf7_form_elements', 'my_wpcf7_form_elements');

add_filter('wpcf7_autop_or_not', '__return_false');

function my_theme_setup() {
    // Agregar soporte para el logo personalizado
    add_theme_support('custom-logo', array(
        'height'      => 48,  // Ajusta la altura del logo según sea necesario
        'width'       => 426,  // Ajusta el ancho del logo según sea necesario
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'my_theme_setup');

