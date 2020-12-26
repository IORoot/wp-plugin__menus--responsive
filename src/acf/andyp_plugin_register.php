<?php

add_action( 'plugins_loaded', function() {
    do_action('register_andyp_plugin', [
        'title'     => 'Responsive Menus',
        'icon'      => 'menu-open',
        'color'     => '#29B6F6',
        'path'      => __FILE__,
    ]);
} );