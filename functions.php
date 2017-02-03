<?php

    require get_template_directory() . '/inc/customizer.php';

    /*
    *  Filter content for lightbox
    */
    function add_classes_to_linked_images($html) {
        $classes = 'lightbox-image'; // can do multiple classes, separate with space

        $patterns = array();
        $replacements = array();

        $patterns[0] = '/<a(?![^>]*class)([^>]*)>\s*<img([^>]*)>\s*<\/a>/'; // matches img tag wrapped in anchor tag where anchor tag where anchor has no existing classes
        $replacements[0] = '<a\1 class="' . $classes . '"><img\2></a>';

        $patterns[1] = '/<a([^>]*)class="([^"]*)"([^>]*)>\s*<img([^>]*)>\s*<\/a>/'; // matches img tag wrapped in anchor tag where anchor has existing classes contained in double quotes
        $replacements[1] = '<a\1class="' . $classes . ' \2"\3><img\4></a>';

        $patterns[2] = '/<a([^>]*)class=\'([^\']*)\'([^>]*)>\s*<img([^>]*)>\s*<\/a>/'; // matches img tag wrapped in anchor tag where anchor has existing classes contained in single quotes
        $replacements[2] = '<a\1class="' . $classes . ' \2"\3><img\4></a>';

        $html = preg_replace($patterns, $replacements, $html);

        return $html;
    }

    add_filter('the_content', 'add_classes_to_linked_images', 100, 1);

    /*
    *  Build the custom menus
    */
    function register_my_menus() {
      register_nav_menus(
        array(
          'main-menu' => __( 'Main Menu' ),
          'portfolio-menu' => __( 'Portfolio Menu' )
        )
      );
    }
    add_action( 'init', 'register_my_menus' );

    /*
    *  Enable content max width
    */
    if ( ! isset( $content_width ) ) {
        $content_width = 800;
    }

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

    /*
    * Load the necessary jquery scripts
    */
    function load_theme_scripts() {
        wp_register_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', NULL, NULL, true );

        // For either a plugin or a theme, you can then enqueue the script:
        wp_enqueue_script( 'fitvids' );
    }
    add_action( 'wp_enqueue_scripts', 'load_theme_scripts' );

/*************************************************************************
 * Add the Custom Video Meta box
 **************************************************************************/

function add_video_embed_meta_box() {
    add_meta_box(
        'lawstew_embed_tweet_meta_box', // $id
        'Video Embed Meta Box', // $title
        'show_video_embed_meta_box', // $callback
        'post', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_video_embed_meta_box');
function show_video_embed_meta_box() {
	global $post;  
        $meta = get_post_meta($post->ID, 'video_embed', true);  
	// Use nonce for verification  
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
    echo '
<table class="form-table">';   
        // begin a table row with
        echo '
<tr>
<th><label for="video_embed">Video Embed</label></th>
<td><textarea name="video_embed" id="video_embed" cols="60" rows="4">'.$meta.'</textarea>
		<span class="description">Use to embed video in your post.</span></td>
</tr>
';  
    echo '</table>
';
}
/**************************************************************************
 * Save the meta fields on save of the post
 **************************************************************************/
 // To Do move this to include

function save_video_embed_meta($post_id) {   
    // verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }  
    $old = get_post_meta($post_id, "video_embed", true);
    $new = $_POST["video_embed"];
    if ($new && $new != $old) {
        update_post_meta($post_id, "video_embed", $new);
    } elseif ('' == $new && $old) {
        delete_post_meta($post_id, "video_embed", $old);
    }
}
add_action('save_post', 'save_video_embed_meta');

/*************************************************************************
 * Add the Custom Link Meta box
 **************************************************************************/

function add_link_meta_box() {
    add_meta_box(
        'lawstew_external_link_meta_box', // $id
        'External Link Meta Box', // $title
        'show_link_meta_box', // $callback
        'post', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_link_meta_box');
function show_link_meta_box() {
	global $post;  
        $meta2 = get_post_meta($post->ID, 'external_link', true);  
	// Use nonce for verification  
	echo '<input type="hidden" name="custom_meta_box_nonce2" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
    echo '
<table class="form-table">';   
        // begin a table row with
        echo '
<tr>
<th><label for="external_link">HREF</label></th>
<td><input type="text" name="external_link" id="external_link" value="'.$meta2.'">
		<span class="description">Use when post format is link to link to an external URL.</span></td>
</tr>
';  
    echo '</table>
';
}
/**************************************************************************
 * Save the meta fields on save of the post
 **************************************************************************/
function save_link_meta($post_id) {   
    // verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce2'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }  
    $old = get_post_meta($post_id, "external_link", true);
    $new = $_POST["external_link"];
    if ($new && $new != $old) {
        update_post_meta($post_id, "external_link", $new);
    } elseif ('' == $new && $old) {
        delete_post_meta($post_id, "external_link", $old);
    }
}
add_action('save_post', 'save_link_meta');

// Includes
//To Do these should be depreciated before public release
include 'inc/featured-slider.php';
include 'inc/portfolio.php';
include 'inc/breadcrumbs.php';