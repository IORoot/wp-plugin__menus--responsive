<?php

/*
 * @package   ANDYP - Responsive Sidebar Menus
 * @author    Andy Pearson <andy@londonparkour.com>
 * @copyright 2020 LondonParkour
 * 
 * @wordpress-plugin
 * Plugin Name:       _ANDYP - Responsive Sidebar Menus
 * Plugin URI:        http://londonparkour.com
 * Description:       Either a dynamic sidebar or a select dropdown, depending on width media query
 * Version:           1.0.0
 * Author:            Andy Pearson
 * Author URI:        https://londonparkour.com
 * Domain Path:       /languages
 */


class andyp_walker extends Walker_Nav_Menu {

	// Displays start of an element. E.g '<li> Item Name'
    // @see Walker::start_el()
    function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
        
        $output .= '<option value="'. $item->url .'">';
 
            $output .= $item->title;

        $output .= '</option>';
    }
}


class andyp_responsive_menus {

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(){

        $this->create_shortcode();
        return;
    }

    /**
     * create_shortcode
     *
     * @return void
     */
    public function create_shortcode(){
         add_shortcode( 'andyp_responsive_menus', array( $this, 'render_shortcode' ) );
    }

    /**
     * render_shortcode
     *
     * @param mixed $atts
     * @param mixed $content
     * @return void
     */
    public function render_shortcode($atts, $content = null){

        //  ┌──────────────────────────────────────┐
		//  │         Shortcode parameters         │
		//  └──────────────────────────────────────┘
		extract(
			shortcode_atts(
				array(
					// Menu Name
					'menu' => '',
                    'sidebar' => '',
                    'category_mobile' => '',
				),
				$atts
			)
        );

        if ($menu != ''){
            echo '<div class="sidemenu__mobile">';
                wp_nav_menu( array(
                    'menu' => $menu,
                    'items_wrap' => '<select onChange="window.location.href=this.value">%3$s</select>',
                    'walker' => new andyp_walker(),
                    'container' => '',
                ) );    
            echo '</div>';
        }

        if ($sidebar != ''){
            echo '<div class="sidemenu__desktop">';
                dynamic_sidebar( $sidebar );
            echo '</div>';
        }

    
        if ($category_mobile != ''){

            echo '<div class="sidemenu__mobile">';
                $categories = explode(',', $category_mobile);

                echo '<select onChange="window.location.href=this.value">';
                echo '<option>Wiki support</option>';
                
                foreach ($categories as $category){

                    $postslist = get_posts( array( 'category' => $category, 'numberposts' => -1 ) );    
                    foreach ($postslist as $post){
                        echo '<option value="'.$post->guid.'">' . $post->post_title . '</option>';
                    }

                }
                echo '</select>';
                
            echo '</div>';
        }
             
        return ;

    }
}

new andyp_responsive_menus;