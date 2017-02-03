<?php

/* Creates The Glossary Post Type */


function my_custom_post_product() {
	$args = array();
	register_post_type( 'Slider', $args );	
}
add_action( 'init', 'gnarly_mag_glossary' );

function gnarly_mag_glossary() {
	$labels = array(
		'name' => _x('Slider', 'post type general name'),
		'singular_name' => _x('Slider', 'post type singular name'),
    	'add_new' => _x('Add New', 'slider'),
    	'add_new_item' => __('Add New Slider'),
    	'edit_item' => __('Edit Slider'),
    	'new_item' => __('New Slider'),
    	'all_items' => __('All Slider'),
    	'view_item' => __('View Sliders'),
    	'search_items' => __('Search Sliders'),
    	'not_found' =>  __('No Sliders found'),
    	'not_found_in_trash' => __('No sliders found in Trash'), 
    	'parent_item_colon' => '',
    	'menu_name' => 'Featured Slider'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our products and product specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true,
		
	);
	register_post_type( 'slider', $args );	
}
add_action( 'init', 'gnarly_mag_glossary' );

/*************************************************************************
 * Add the Custom Meta box
 **************************************************************************/

function add_url_link_meta_box() {
    add_meta_box(
        'lawstew_url_link_meta_box', // $id
        'URL Link Meta Box', // $title
        'show_url_link_meta_box', // $callback
        'slider', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_url_link_meta_box');
function show_url_link_meta_box() {
	global $post;  
        $meta = get_post_meta($post->ID, 'slider_url_link', true);  
	// Use nonce for verification  
	echo '<input type="hidden" name="custom_url_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
    echo '
<table class="form-table">';   
        // begin a table row with
        echo '
<tr>
<th><label for="slider_url_link">URL LINK</label></th>
<td><textarea name="slider_url_link" id="slider_url_link" cols="60" rows="4">'.$meta.'</textarea>
		<span class="description">Add the URL to link to</span></td>
</tr>
';  
    echo '</table>
';
}
/**************************************************************************
 * Save the meta fields on save of the post
 **************************************************************************/
function save_url_link_meta($post_id) {   
    // verify nonce
    if (!wp_verify_nonce($_POST['custom_url_meta_box_nonce'], basename(__FILE__)))
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
    $old = get_post_meta($post_id, "slider_url_link", true);
    $new = $_POST["slider_url_link"];
    if ($new && $new != $old) {
        update_post_meta($post_id, "slider_url_link", $new);
    } elseif ('' == $new && $old) {
        delete_post_meta($post_id, "slider_url_link", $old);
    }
}
add_action('save_post', 'save_url_link_meta');

?>