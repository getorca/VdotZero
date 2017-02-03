<?php

function my_custom_portfolio() {
	$labels = array(
		'name'               => _x( 'Portfolio', 'post type general name' ),
		'singular_name'      => _x( 'Portfolio', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'book' ),
		'add_new_item'       => __( 'Add New Item' ),
		'edit_item'          => __( 'Edit Item' ),
		'new_item'           => __( 'New Item' ),
		'all_items'          => __( 'All Items' ),
		'view_item'          => __( 'View Item' ),
		'search_items'       => __( 'Search Items' ),
		'not_found'          => __( 'No items found' ),
		'not_found_in_trash' => __( 'No items found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Portfolio'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our Portfolio Items and specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true,
        'rewrite' => array(
                'slug' => 'old-portfolio'
        )
	);
	register_post_type( 'portfolio', $args );	
}
add_action( 'init', 'my_custom_portfolio' );

// Create Two Taxonomies for the Portfolio; Categories & Skills.
function my_portfolio_categories() {
	
	//Create portfolio categories taxanomy
	$labels = array(
		'name'              => _x( 'Portfolio Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Portfolio Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Portfolio Categories' ),
		'all_items'         => __( 'All Portfolio Categories' ),
		'parent_item'       => __( 'Parent Portfolio Category' ),
		'parent_item_colon' => __( 'Parent Portfolio Category:' ),
		'edit_item'         => __( 'Edit Portfolio Category' ), 
		'update_item'       => __( 'Update Portfolio Category' ),
		'add_new_item'      => __( 'Add New Portfolio Category' ),
		'new_item_name'     => __( 'New Portfolio Category' ),
		'menu_name'         => __( 'Portfolio Categories' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
	);
	register_taxonomy( 'portfolio_category', 'portfolio', $args );
	
	//Create portfolio skills taxanomy
	$labels = array(
		'name'              => _x( 'Skills', 'taxonomy general name' ),
		'singular_name'     => _x( 'Skill', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Skills' ),
		'all_items'         => __( 'All Skills' ),
		'parent_item'       => __( 'Parent Skill' ),
		'parent_item_colon' => __( 'Parent Skill:' ),
		'edit_item'         => __( 'Edit Skill' ), 
		'update_item'       => __( 'Update Skill' ),
		'add_new_item'      => __( 'Add New Skill' ),
		'new_item_name'     => __( 'New Skill' ),
		'menu_name'         => __( 'Skills' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
	);
	register_taxonomy( 'portfolio_skills', 'portfolio', $args );
}
add_action( 'init', 'my_portfolio_categories', 0 );

// Add the Portfolio Metaboxes

function example_custom_meta() {
    add_meta_box( 'example_meta', 'Portfolio Details', 'example_meta_callback', 'portfolio', 'side', 'high' );
} 
add_action( 'add_meta_boxes', 'example_custom_meta' );

	/**
	 * Outputs the content of the metabox
	 */
	function example_meta_callback( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'example_nonce' );
		$example_stored_meta = get_post_meta( $post->ID );
		$example_stored_meta2 = get_post_meta( $post->ID );
		$example_stored_meta3 = get_post_meta( $post->ID );
		?>
	 
		<p>
			<label for="meta-text" class="example-row-title">Date Completed:</label><br />
			<input type="text" name="meta-text" id="meta-text" value="<?php echo $example_stored_meta['meta-text'][0]; ?>" />
		</p>
        <p>
			<label for="meta-text2" class="example-row-title">Client:</label><br />
			<input type="text" name="meta-text2" id="meta-text2" value="<?php echo $example_stored_meta2['meta-text2'][0]; ?>" />
		</p>
        <p>
			<label for="meta-text3" class="example-row-title">External Link:</label><br />
			<input type="text" name="meta-text3" id="meta-text3" value="<?php echo $example_stored_meta3['meta-text3'][0]; ?>" />
		</p>
	 
		<?php
	} // end example_meta_callback()
	/**
	 * Saves the custom meta input
	 */
	function example_meta_save( $post_id ) {
	 
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'example_nonce' ] ) && wp_verify_nonce( $_POST[ 'example_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	 
		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}
	 
		// Checks for input and sanitizes/saves if needed
		if( isset( $_POST[ 'meta-text' ] ) ) {
			update_post_meta( $post_id, 'meta-text', sanitize_text_field( $_POST[ 'meta-text' ] ) );
		}
		if( isset( $_POST[ 'meta-text2' ] ) ) {
			update_post_meta( $post_id, 'meta-text2', sanitize_text_field( $_POST[ 'meta-text2' ] ) );
		}
		if( isset( $_POST[ 'meta-text3' ] ) ) {
			update_post_meta( $post_id, 'meta-text3', sanitize_text_field( $_POST[ 'meta-text3' ] ) );
		}
	 
	} // end example_meta_save()
	add_action( 'save_post', 'example_meta_save' );






?>