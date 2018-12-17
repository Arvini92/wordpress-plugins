<?php 
/**
 * Plugin Name: Niko Sum Go Futher with Ajax
 * Description: A simple plugin that adds custom post types and taxonomies
 * Version 0.1
 * Author: Niko Sum
 * License: GPL2
 **/
function gofuther_register_fields() {
    register_api_field('post', 
        'author_name',
        array(
            'get_callback'    => 'gofurther_get_author_name',
            'update_callback' => null,
            'schema'          => null
        )
    );

    register_api_field('post', 
    'featured_image_src',
    array(
        'get_callback'    => 'gofurther_get_image_src',
        'update_callback' => null,
        'schema'          => null
    )
);
}
function gofurther_get_author_name($object, $field_name, $request) {
    return get_the_author_meta('display_name');
}

function gofurther_get_image_src($object, $field_name, $request) {
   $feat_img_array = wp_get_attachment_image_src($object['featured_image'], 'thumbnail', true);
   return $feat_img_array[0];
}

add_action('rest_api_init', 'gofuther_register_fields');

function go_futher_scripts() {
    if (is_single() && is_main_query()) {
        wp_enqueue_style('gofuther-style', plugin_dir_url(__FILE__) . 'css/style.css', '0.1', 'all');
        wp_enqueue_script('gofuther-script', plugin_dir_url(__FILE__) . 'js/gofuther.ajax.js', array('jquery'), '0.1', true);
        
        global $post;
        $post_id = $post->ID;

        wp_localize_script('gofuther-script', 'postdata',
            array(
                'post_id' => $post_id,
                'json' => gofuther_get_json_query()
            )
        );
    }
}

 add_action('wp_enqueue_scripts', 'go_futher_scripts');

 function gofuther_get_json_query() {
     $cats = get_the_category();
     $cat_ids = array();
     foreach($cats as $cat) {
         $cat_ids[] = $cat->term_id;
     }

     $args = array(
         'filter[cat]' => implode(",",$cat_ids),
         'filter[post_per_page]' => 5,
     );

     $url = add_query_arg($args, rest_url('wp/v2/posts'));

     return $url;
 }

 function gofuther_baseline_html() {
    $baseline  = '<section id="related-posts" class="related-posts">';
	$baseline .= '<a href="#" class="get-related-posts">Get related posts</a>';
    $baseline .= '<div class="ajax-loader"><img src="' . plugin_dir_url( __FILE__ ) . 'css/spinner.svg" width="32" height="32" /></div>';
	$baseline .= '</section><!-- .related-posts -->';
    return $baseline;
 }

 function gofuther_display($content) {
    if (is_single() && is_main_query()) {
        $content .= gofuther_baseline_html();
    }
    return $content;
}
 add_filter('the_content', 'gofuther_display');