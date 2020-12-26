<?php

add_action( 'plugins_loaded', function() {
    do_action('register_andyp_plugin', [
        'title'     => 'Menus - Responsive Menus',
        'icon'      => 'menu-open',
        'color'     => '#66BB6A',
        'path'      => __FILE__,
    ]);
} );