<?php
/*****************************************************************************
*
*	copyright(c) - aonetheme.com - Service Finder Team
*	More Info: http://aonetheme.com/
*	Coder: Service Finder Team
*	Email: contact@aonetheme.com
*
******************************************************************************/
defined( 'ABSPATH' ) || exit;
require_once SERVICE_FINDER_BOOKING_FRONTEND_MODULE_DIR . '/myaccount/library/imageupload.php';
if ( ! class_exists( 'SERVICE_FINDER_Upload_Image' ) )
{
	class SERVICE_FINDER_Upload_Image extends SERVICE_FINDER_ImageSpace
	{
		/* Add field actions */
		static function add_actions()
		{
			parent::add_actions();
			add_action( 'wp_ajax_image_upload', array( __CLASS__, 'manageUpload' ) );
			add_action( 'wp_ajax_coverimage_upload', array( __CLASS__, 'manageUpload' ) );
			add_action( 'wp_ajax_articlefeatured_upload', array( __CLASS__, 'manageUpload' ) );
			add_action( 'wp_ajax_articlefeatureedit_upload', array( __CLASS__, 'manageUpload' ) );
			add_action( 'wp_ajax_certificate_upload', array( __CLASS__, 'manageUpload' ) );
			add_action( 'wp_ajax_stripeidentity_upload', array( __CLASS__, 'manageUpload' ) );
			add_action( 'wp_ajax_certificateedit_upload', array( __CLASS__, 'manageUpload' ) );
			add_action( 'wp_ajax_avatar_upload', array( __CLASS__, 'manageUpload' ) );
			add_action( 'wp_ajax_memberavatar_upload', array( __CLASS__, 'manageUpload' ) );
			add_action( 'wp_ajax_memberavatar_uploadedit', array( __CLASS__, 'manageUpload' ) );
			add_action( 'wp_ajax_file_upload', array( __CLASS__, 'manageFileupload' ) );
		}

		/* Ajax callback function */
		static function manageUpload()
		{
			global $wpdb;
			$post_id  = isset( $_REQUEST['post_id'] ) ? intval( $_REQUEST['post_id'] ) : 0;
			$field_id = isset( $_REQUEST['field_id'] ) ? $_REQUEST['field_id'] : '';

			$file      = $_FILES['async-upload'];
			$file_attr = wp_handle_upload( $file, array( 'test_form' => false ) );

			$meta = get_post_meta( $post_id, $field_id, false );
			if ( empty( $meta ) )
			{
				$next = 0;
			}
			else
			{
				$meta = implode( ',', (array) $meta );
				$max  = $wpdb->get_var( "
					SELECT MAX(menu_order) FROM {$wpdb->posts}
					WHERE post_type = 'attachment'
					AND ID in ({$meta})
				" );
				$next = is_numeric( $max ) ? (int) $max + 1 : 0;
			}

			$attachment = array(
				'guid'           => $file_attr['url'],
				'post_mime_type' => $file_attr['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file['name'] ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
				'menu_order'     => $next,
			);

			$id = wp_insert_attachment( $attachment, $file_attr['file'], $post_id );
			if ( ! is_wp_error( $id ) )
			{
				wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file_attr['file'] ) );

				// Save file ID in meta field
				add_post_meta( $post_id, $field_id, $id, false );
				if($field_id == 'plupload'){
					wp_send_json_success( self::img_custom_html( $id ) );
				}elseif($field_id == 'sfidentityuploader'){
					wp_send_json_success( self::img_identity_html( $id ) );
				}elseif($field_id == 'quoteuploader'){
					wp_send_json_success( self::img_quote_html( $id ) );
				}elseif($field_id == 'sfmemberavatarupload'){
					wp_send_json_success( self::img_member_html( $id ) );
				}elseif($field_id == 'sfmemberavataruploadedit'){
					wp_send_json_success( self::img_memberedit_html( $id ) );
				}elseif($field_id == 'coverimageuploader'){
					wp_send_json_success( self::img_coverimage_html( $id ) );
				}elseif($field_id == 'certificate' || $field_id == 'certificateedit'){
					wp_send_json_success( self::img_certificate_html( $id ) );
				}elseif($field_id == 'stripeidentity'){
					wp_send_json_success( self::img_stripeidentity_html( $id ) );
				}elseif($field_id == 'articlefeatured' || $field_id == 'articlefeatureedit'){
					wp_send_json_success( self::img_articlefeatured_html( $id ) );	
				}elseif($field_id == 'sffileuploader'){
					wp_send_json_success( self::img_file_html( $id ) );
				}else{
					wp_send_json_success( self::img_html( $id ) );
				}
				
			}

			exit;
		}
		
		/**
		 * File Upload
		 * Ajax callback function
		 *
		 * @return string Error or (XML-)response
		 */
		static function manageFileupload()
		{
			global $wpdb;
			$post_id  = isset( $_REQUEST['post_id'] ) ? intval( $_REQUEST['post_id'] ) : 0;
			$field_id = isset( $_REQUEST['field_id'] ) ? $_REQUEST['field_id'] : '';

			// You can use WP's wp_handle_upload() function:
			$file      = $_FILES['async-upload'];
			$file_attr = wp_handle_upload( $file, array( 'test_form' => false ) );
			//Get next menu_order
			$meta = get_post_meta( $post_id, $field_id, false );
			if ( empty( $meta ) )
			{
				$next = 0;
			}
			else
			{
				$meta = implode( ',', (array) $meta );
				$max  = $wpdb->get_var( "
					SELECT MAX(menu_order) FROM {$wpdb->posts}
					WHERE post_type = 'attachment'
					AND ID in ({$meta})
				" );
				$next = is_numeric( $max ) ? (int) $max + 1 : 0;
			}

			$attachment = array(
				'guid'           => $file_attr['url'],
				'post_mime_type' => $file_attr['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file['name'] ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
				'menu_order'     => $next,
			);

			// Adds file as attachment to WordPress
			$id = wp_insert_attachment( $attachment, $file_attr['file'], $post_id );
			if ( ! is_wp_error( $id ) )
			{
				wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file_attr['file'] ) );

				// Save file ID in meta field
				add_post_meta( $post_id, $field_id, $id, false );
				
				if($field_id == 'plupload'){
					wp_send_json_success( self::img_custom_html( $id ) );
				}elseif($field_id == 'sfidentityuploader'){
					wp_send_json_success( self::img_identity_html( $id ) );
				}elseif($field_id == 'quoteuploader'){
					wp_send_json_success( self::img_quote_html( $id ) );
				}elseif($field_id == 'sfmemberavatarupload'){
					wp_send_json_success( self::img_member_html( $id ) );
				}elseif($field_id == 'sfmemberavataruploadedit'){
					wp_send_json_success( self::img_memberedit_html( $id ) );
				}elseif($field_id == 'coverimageuploader'){
					wp_send_json_success( self::img_coverimage_html( $id ) );
				}elseif($field_id == 'certificate' || $field_id == 'certificateedit'){
					wp_send_json_success( self::img_certificate_html( $id ) );
				}elseif($field_id == 'stripeidentity'){
					wp_send_json_success( self::img_stripeidentity_html( $id ) );
				}elseif($field_id == 'articlefeatured' || $field_id == 'articlefeatureedit'){
					wp_send_json_success( self::img_articlefeatured_html( $id ) );	
				}elseif($field_id == 'sffileuploader'){
					wp_send_json_success( self::img_file_html( $id ) );
				}else{
					wp_send_json_success( self::img_html( $id ) );
				}
				
			}

			exit;
		}

		/**
		 * Get field HTML
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			if ( ! is_array( $meta ) )
				$meta = ( array ) $meta;

			// Filter to change the drag & drop box background string
			$i18n_drop   = apply_filters( 'rwmb_plupload_image_drop_string', _x( 'Drop images here', 'image upload', 'service-finder' ), $field );
			$i18n_or     = apply_filters( 'rwmb_plupload_image_or_string', _x( 'or', 'image upload', 'service-finder' ), $field );
			$i18n_select = apply_filters( 'rwmb_plupload_image_select_string', _x( 'Select Files', 'image upload', 'service-finder' ), $field );

			// Uploaded images

			// Check for max_file_uploads
			$classes = array( 'rwmb-drag-drop', 'drag-drop', 'hide-if-no-js', 'new-files' );
			if ( ! empty( $field['max_file_uploads'] ) && count( $meta ) >= (int) $field['max_file_uploads'] )
				$classes[] = 'hidden';

			$html = self::get_uploaded_images( $meta, $field );

			// Show form upload
			$html .= sprintf(
				'<div id="%s-dragdrop" class="%s" data-upload_nonce="%s" data-js_options="%s">
					<div class = "drag-drop-inside">
						<p class="drag-drop-info">%s</p>
						<p>%s</p>
						<p class="drag-drop-buttons"><input id="%s-browse-button" type="button" value="%s" class="button" /></p>
					</div>
				</div>',
				$field['id'],
				implode( ' ', $classes ),
				wp_create_nonce( "rwmb-upload-images_{$field['id']}" ),
				esc_attr( wp_json_encode( $field['js_options'] ) ),
				$i18n_drop,
				$i18n_or,
				$field['id'],
				$i18n_select
			);

			return $html;
		}

		/**
		 * Get field value
		 * It's the combination of new (uploaded) images and saved images
		 *
		 * @param array $new
		 * @param array $old
		 * @param int   $post_id
		 * @param array $field
		 *
		 * @return array|mixed
		 */
		static function value( $new, $old, $post_id, $field )
		{
			$new = (array) $new;

			return array_unique( array_merge( $old, $new ) );
		}

		/**
		 * Normalize parameters for field
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function arrangefields( $field )
		{
			$field['js_options'] = array(
				'runtimes'            => 'html5,silverlight,flash,html4',
				'file_data_name'      => 'async-upload',
				'browse_button'       => $field['id'] . '-browse-button',
				'drop_element'        => $field['id'] . '-dragdrop',
				'multiple_queues'     => true,
				'max_file_size'       => wp_max_upload_size() . 'b',
				'url'                 => admin_url( 'admin-ajax.php' ),
				'flash_swf_url'       => includes_url( 'js/plupload/plupload.flash.swf' ),
				'silverlight_xap_url' => includes_url( 'js/plupload/plupload.silverlight.xap' ),
				'multipart'           => true,
				'urlstream_upload'    => true,
				'filters'             => array(
					array(
						'title'      => _x( 'Allowed Image Files', 'image upload', 'service-finder' ),
						'extensions' => 'jpg,jpeg,gif,png',
					),
				),
				'multipart_params'    => array(
					'field_id' => $field['id'],
					'action'   => 'image_upload',
				)
			);
			$field               = parent::arrangefields( $field );

			return $field;
		}
	}
}
