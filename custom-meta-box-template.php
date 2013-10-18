<?php

/*
Plugin Name: Custom Meta Box Template
Plugin URI: http://themefoundation.com/
Description: Provides a starting point for creating custom meta boxes.
Author: Theme Foundation
Version: 1.0
Author URI: http://themefoundation.com/
*/


/**
 * Adds a meta box to the post editing screen
 */
function prfx_custom_meta() {
	add_meta_box( 'prfx_meta', __( 'Meta Box Title', 'prfx-textdomain' ), 'prfx_meta_callback', 'post' );
}
add_action( 'add_meta_boxes', 'prfx_custom_meta' );

/**
 * Outputs the content of the meta box
 */
function prfx_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$prfx_stored_meta = get_post_meta( $post->ID );
	?>

	<p>
		<label for="meta-text" class="prfx-row-title"><?php _e( 'Example Text Input', 'prfx-meta' )?></label>
		<input type="text" name="meta-text" id="meta-text" value="<?php if ( isset ( $prfx_stored_meta['meta-text'] ) ) echo $prfx_stored_meta['meta-text'][0]; ?>" />
	</p>

	<p>
		<span class="prfx-row-title"><?php _e( 'Example Checkbox Input', 'prfx-meta' )?></span>
		<div class="prfx-row-content">
			<label for="meta-checkbox">
				<input type="checkbox" name="meta-checkbox" id="meta-checkbox" value="yes" <?php if ( isset ( $prfx_stored_meta['meta-checkbox'] ) ) checked( $prfx_stored_meta['meta-checkbox'][0], 'yes' ); ?> />
				<?php _e( 'Checkbox label', 'prfx-meta' )?>
			</label>
			<label for="meta-checkbox-two">
				<input type="checkbox" name="meta-checkbox-two" id="meta-checkbox-two" value="yes" <?php if ( isset ( $prfx_stored_meta['meta-checkbox-two'] ) ) checked( $prfx_stored_meta['meta-checkbox-two'][0], 'yes' ); ?> />
				<?php _e( 'Another checkbox', 'prfx-meta' )?>
			</label>
		</div>
	</p>

	<p>
		<span class="prfx-row-title"><?php _e( 'Example Radio Buttons', 'prfx-meta' )?></span>
		<div class="prfx-row-content">
			<label for="meta-radio-one">
				<input type="radio" name="meta-radio" id="meta-radio-one" value="radio-one" <?php if ( isset ( $prfx_stored_meta['meta-radio'] ) ) checked( $prfx_stored_meta['meta-radio'][0], 'radio-one' ); ?>>
				<?php _e( 'Radio Option #1', 'prfx-meta' )?>
			</label>
			<label for="meta-radio-two">
				<input type="radio" name="meta-radio" id="meta-radio-two" value="radio-two" <?php if ( isset ( $prfx_stored_meta['meta-radio'] ) ) checked( $prfx_stored_meta['meta-radio'][0], 'radio-two' ); ?>>
				<?php _e( 'Radio Option #2', 'prfx-meta' )?>
			</label>
		</div>
	</p>

	<p>
		<label for="meta-select" class="prfx-row-title"><?php _e( 'Example Select Input', 'prfx-meta' )?></label>
		<select name="meta-select" id="meta-select">
			<option value="select-one" <?php if ( isset ( $prfx_stored_meta['meta-select'] ) ) selected( $prfx_stored_meta['meta-select'][0], 'select-one' ); ?>><?php _e( 'One', 'prfx-meta' )?></option>';
			<option value="select-two" <?php if ( isset ( $prfx_stored_meta['meta-select'] ) ) selected( $prfx_stored_meta['meta-select'][0], 'select-two' ); ?>><?php _e( 'Two', 'prfx-meta' )?></option>';
		</select>
	</p>

	<p>
		<label for="meta-textarea" class="prfx-row-title"><?php _e( 'Example Textarea Input', 'prfx-meta' )?></label>
		<textarea name="meta-textarea" id="meta-textarea"><?php if ( isset ( $prfx_stored_meta['meta-textarea'] ) ) echo $prfx_stored_meta['meta-textarea'][0]; ?></textarea>
	</p>

	<p>
		<label for="meta-color" class="prfx-row-title"><?php _e( 'Color Picker', 'prfx-meta' )?></label>
		<input name="meta-color" type="text" value="<?php if ( isset ( $prfx_stored_meta['meta-color'] ) ) echo $prfx_stored_meta['meta-color'][0]; ?>" class="meta-color" />
	</p>

	<p>
		<label for="meta-image" class="prfx-row-title"><?php _e( 'Example File Upload', 'prfx-meta' )?></label>
		<input type="text" name="meta-image" id="meta-image" value="<?php if ( isset ( $prfx_stored_meta['meta-image'] ) ) echo $prfx_stored_meta['meta-image'][0]; ?>" />
		<input type="button" id="meta-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'prfx-meta' )?>" />
	</p>
 

	<?php
}



/**
 * Saves the custom meta input
 */
function prfx_meta_save( $post_id ) {
 
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}
 
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'meta-text' ] ) ) {
		update_post_meta( $post_id, 'meta-text', sanitize_text_field( $_POST[ 'meta-text' ] ) );
	}

	// Checks for input and saves
	if( isset( $_POST[ 'meta-checkbox' ] ) ) {
		update_post_meta( $post_id, 'meta-checkbox', 'yes' );
	} else {
		update_post_meta( $post_id, 'meta-checkbox', '' );
	}
	 
	// Checks for input and saves
	if( isset( $_POST[ 'meta-checkbox-two' ] ) ) {
		update_post_meta( $post_id, 'meta-checkbox-two', 'yes' );
	} else {
		update_post_meta( $post_id, 'meta-checkbox-two', '' );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-radio' ] ) ) {
		update_post_meta( $post_id, 'meta-radio', $_POST[ 'meta-radio' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-select' ] ) ) {
		update_post_meta( $post_id, 'meta-select', $_POST[ 'meta-select' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-textarea' ] ) ) {
		update_post_meta( $post_id, 'meta-textarea', $_POST[ 'meta-textarea' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-color' ] ) ) {
		update_post_meta( $post_id, 'meta-color', $_POST[ 'meta-color' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-image' ] ) ) {
		update_post_meta( $post_id, 'meta-image', $_POST[ 'meta-image' ] );
	}

}
add_action( 'save_post', 'prfx_meta_save' );


/**
 * Adds the meta box stylesheet when appropriate
 */
function prfx_admin_styles(){
	global $typenow;
	if( $typenow == 'post' ) {
		wp_enqueue_style( 'prfx_meta_box_styles', plugin_dir_url( __FILE__ ) . 'meta-box-styles.css' );
	}
}
add_action( 'admin_print_styles', 'prfx_admin_styles' );


/**
 * Loads the color picker javascript
 */
function prfx_color_enqueue() {
	global $typenow;
	if( $typenow == 'post' ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'meta-box-color-js', plugin_dir_url( __FILE__ ) . 'meta-box-color.js', array( 'wp-color-picker' ) );
	}
}
add_action( 'admin_enqueue_scripts', 'prfx_color_enqueue' );

/**
 * Loads the image management javascript
 */
function prfx_image_enqueue() {
	global $typenow;
	if( $typenow == 'post' ) {
		wp_enqueue_media();
 
		// Registers and enqueues the required javascript.
		wp_register_script( 'meta-box-image', plugin_dir_url( __FILE__ ) . 'meta-box-image.js', array( 'jquery' ) );
		wp_localize_script( 'meta-box-image', 'meta_image',
			array(
				'title' => 'Choose or Upload an Image',
				'button' => 'Use this image',
			)
		);
		wp_enqueue_script( 'meta-box-image' );
	}
}
add_action( 'admin_enqueue_scripts', 'prfx_image_enqueue' );
