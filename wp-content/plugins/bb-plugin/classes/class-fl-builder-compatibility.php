<?php

/**
 * Various fixes for various plugins.
 *
 * @since 2.3
 */
final class FLBuilderCompatibility {

	public static function init() {

		// Actions
		add_action( 'after_setup_theme', array( __CLASS__, 'pro_icons_enable' ) );
		add_action( 'fl_builder_photo_cropped', array( __CLASS__, 'tinypng_support' ), 10, 2 );
		add_action( 'plugins_loaded', array( __CLASS__, 'wc_memberships_support' ), 11 );
		add_action( 'plugins_loaded', array( __CLASS__, 'admin_ssl_upload_fix' ), 11 );
		add_action( 'added_post_meta', array( __CLASS__, 'template_meta_add' ), 10, 4 );
		add_action( 'fl_builder_insert_layout_render', array( __CLASS__, 'insert_layout_render_search' ), 10, 3 );
		add_action( 'fl_builder_fa_pro_save', array( __CLASS__, 'clear_theme_cache' ) );
		add_action( 'wp', array( __CLASS__, 'ee_suppress_notices' ) );
		add_action( 'fl_ajax_before_call_action', array( __CLASS__, 'ee_before_ajax' ) );
		add_action( 'plugins_loaded', array( __CLASS__, 'fix_nextgen_gallery' ) );
		add_action( 'template_redirect', array( __CLASS__, 'fix_tasty_recipes' ) );
		add_action( 'template_redirect', array( __CLASS__, 'fix_generatepress_fa5' ) );
		add_action( 'template_redirect', array( __CLASS__, 'fix_hummingbird' ) );
		add_action( 'template_redirect', array( __CLASS__, 'fix_enjoy_instagram' ) );
		add_action( 'template_redirect', array( __CLASS__, 'fix_templator' ) );
		add_action( 'template_redirect', array( __CLASS__, 'fix_protector_gold' ) );
		add_action( 'template_redirect', array( __CLASS__, 'fix_smush_it' ) );
		add_action( 'template_redirect', array( __CLASS__, 'fix_frontend_dashboard_plugin' ), 1000 );
		add_action( 'template_redirect', array( __CLASS__, 'fix_um_switcher' ) );
		add_action( 'template_redirect', array( __CLASS__, 'fix_pipedrive' ) );
		add_action( 'template_redirect', array( __CLASS__, 'aggiungi_script_instafeed_owl' ), 1000 );
		add_action( 'tribe_events_pro_widget_render', array( __CLASS__, 'tribe_events_pro_widget_render_fix' ), 10, 3 );
		add_action( 'wp_footer', array( __CLASS__, 'fix_woo_short_description_footer' ) );
		add_action( 'save_post', array( __CLASS__, 'fix_seopress' ), 9 );
		add_action( 'admin_init', array( __CLASS__, 'fix_posttypeswitcher' ) );
		add_action( 'widgets_init', array( __CLASS__, 'fix_google_reviews_business_widget' ), 11 );
		add_action( 'init', array( __CLASS__, 'fix_google_reviews_business_shortcode' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'gute_links_fix' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'fa_kit_support' ), 99999 );
		add_action( 'fl_theme_builder_before_render_header', array( __CLASS__, 'fix_lazyload_header_start' ) );
		add_action( 'fl_theme_builder_after_render_header', array( __CLASS__, 'fix_lazyload_header_end' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'ee_remove_stylesheet' ), 99999 );

		// Filters
		add_filter( 'fl_builder_is_post_editable', array( __CLASS__, 'bp_pages_support' ), 11, 2 );
		add_filter( 'jetpack_photon_skip_image', array( __CLASS__, 'photo_photon_exception' ), 10, 3 );
		add_filter( 'fl_builder_render_module_content', array( __CLASS__, 'render_module_content_filter' ), 10, 2 );
		add_filter( 'bwp_minify_is_loadable', array( __CLASS__, 'bwp_minify_is_loadable_filter' ) );
		add_filter( 'fl_builder_editor_content', array( __CLASS__, 'activemember_shortcode_fix' ) );
		add_filter( 'fl_builder_editor_content', array( __CLASS__, 'imember_shortcode_fix' ) );
		add_filter( 'fl_builder_ajax_layout_response', array( __CLASS__, 'render_ninja_forms_js' ) );
		add_filter( 'avf_enqueue_wp_mediaelement', array( __CLASS__, 'not_load_mediaelement' ), 10, 2 );
		add_filter( 'phpcompat_whitelist', array( __CLASS__, 'bb_compat_fix' ) );
		add_filter( 'fl_builder_editor_content', array( __CLASS__, 'theme_post_content_fix' ) );
		add_filter( 'fl_builder_admin_settings_post_types', array( __CLASS__, 'admin_settings_post_types_popup' ) );
		add_filter( 'woocommerce_product_get_short_description', array( __CLASS__, 'fix_woo_short_description' ) );
		add_filter( 'enlighter_startup', array( __CLASS__, 'enlighter_frontend_editing' ) );
		add_filter( 'option_sumome_site_id', array( __CLASS__, 'fix_sumo' ) );
		add_filter( 'fl_builder_admin_edit_sort_blocklist', array( __CLASS__, 'admin_edit_sort_blocklist_edd' ) );
		add_filter( 'option_cookiebot-nooutput', array( __CLASS__, 'fix_cookiebot' ) );

	}

	public static function clear_theme_cache( $enabled ) {
		if ( class_exists( 'FLCustomizer' ) ) {
			if ( $enabled ) {
				add_filter( 'fl_enable_fa5_pro', '__return_true' );
			}
			FLCustomizer::refresh_css();
			if ( $enabled ) {
				remove_filter( 'fl_enable_fa5_pro', '__return_true' );
			}
		}
	}

	/**
	 * Theme and themer rely on this filter.
	 */
	public static function pro_icons_enable() {
		if ( get_option( '_fl_builder_enable_fa_pro', false ) && ! is_admin() ) {
			add_filter( 'fl_enable_fa5_pro', '__return_true' );
		}
	}

	/**
	 * Fix cookiebot plugin
	 * @since 2.2.6
	 */
	public static function fix_cookiebot( $arg ) {
		if ( isset( $_GET['fl_builder'] ) ) {
			return true;
		}
		return $arg;
	}

	/**
	 * Add data-no-lazy to photo modules in themer header area.
	 * Fixes wp-rocket lazy load issue with shrink header.
	 * @since 2.2.3
	 */
	public static function fix_lazyload_header_start() {
		add_filter( 'fl_builder_photo_attributes', array( __CLASS__, 'fix_lazyload_header_attributes' ) );
	}
	public static function fix_lazyload_header_end() {
		remove_filter( 'fl_builder_photo_attributes', array( __CLASS__, 'fix_lazyload_header_attributes' ) );
	}
	public static function fix_lazyload_header_attributes( $attrs ) {
		return $attrs . ' data-no-lazy="1"';
	}

	/**
	 * Font Awesome KIT support
	 * @since 2.3
	 */
	public static function fa_kit_support() {
		if ( FLBuilder::fa5_pro_enabled() && '' !== get_option( '_fl_builder_kit_fa_pro' ) ) {
			wp_dequeue_style( 'font-awesome' );
			wp_dequeue_style( 'font-awesome-5' );
			wp_deregister_style( 'font-awesome' );
			wp_deregister_style( 'font-awesome-5' );
			wp_enqueue_script( 'fa5-kit', get_option( '_fl_builder_kit_fa_pro' ) );
		}
	}

	/**
		* Remove BB Template types from Gute Editor suggested urls
		* @since 2.2.5
		*/
	public static function gute_links_fix( $query ) {
		if ( defined( 'REST_REQUEST' ) && $query->is_search() ) {
			$types = (array) $query->get( 'post_type' );
			$key   = array_search( 'fl-builder-template', $types, true );
			if ( $key ) {
				unset( $types[ $key ] );
				$query->set( 'post_type', $types );
			}
		}
	}

	/**
	 * Remove sorting from download type if EDD is active.
	 * @since 2.2.5
	 */

	public static function admin_edit_sort_blocklist_edd( $blocklist ) {
		$types = FLBuilderModel::get_post_types();
		if ( in_array( 'download', $types ) && class_exists( 'Easy_Digital_Downloads' ) ) {
			$blocklist[] = 'download';
		}
		return $blocklist;
	}

	/**
	 * Fixes for Google Reviews Business Plugin shortcode
	 * @since 2.2.4
	 */
	public static function fix_google_reviews_business_shortcode() {
		if ( isset( $_GET['fl_builder'] ) ) {
			remove_shortcode( 'google-reviews-pro' );
		}
	}

	/**
	 * Fixes for Google Reviews Business Plugin widget
	 * @since 2.2.4
	 */
	public static function fix_google_reviews_business_widget() {
		if ( isset( $_GET['fl_builder'] ) ) {
			unregister_widget( 'Goog_Reviews_Pro' );
		}
	}

	/**
	 * Fix post type switcher
	 * @since 2.2.4
	 */
	public static function fix_posttypeswitcher() {
		global $pagenow;
		$disable = false;
		if ( 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'fl-theme-layout' === $_GET['post_type'] ) {
			$disable = true;
		}
		if ( 'post.php' === $pagenow && isset( $_GET['post'] ) && ( 'fl-theme-layout' === get_post_type( $_GET['post'] ) || 'fl-builder-template' === get_post_type( $_GET['post'] ) ) ) {
			$disable = true;
		}
		if ( $disable ) {
			add_filter( 'pts_allowed_pages', '__return_empty_array' );
		}
	}

	/**
	 * Fix pipedrive chat popup
	 * @since 2.2.4
	 */
	public static function fix_pipedrive() {
		if ( isset( $_GET['fl_builder'] ) ) {
			remove_action( 'wp_head', 'pipedrive_add_embed_code' );
		}
	}

	/**
	 * Fix JS error caused by UM-Switcher plugin
	 * @since 2.2.3
	 */
	public static function fix_um_switcher() {
		if ( isset( $_GET['fl_builder'] ) ) {
			remove_action( 'wp_footer', 'umswitcher_profile_subscription_expiration_footer' );
		}
	}

	/**
	 * Fix icon issues with Frontend Dashboard version 1.3.4+
	 * @since 2.2.3
	 */
	public static function fix_frontend_dashboard_plugin() {
		if ( FLBuilderModel::is_builder_active() ) {
			remove_action( 'wp_enqueue_scripts', 'fed_script_front_end', 99 );
		}
	}

	/**
	 * Remove Sumo JS when builder is open.
	 * @since 2.2.1
	 */
	public static function fix_sumo( $option ) {
		if ( isset( $_GET['fl_builder'] ) ) {
			return false;
		}
		return $option;
	}

	/**
	 * Enlighter stops builder from loading.
	 * @since 2.2
	 */
	public static function enlighter_frontend_editing( $enabled ) {
		if ( isset( $_GET['fl_builder'] ) ) {
			return false;
		}
		return $enabled;
	}

	/**
	 * Fix fatal error on adding Themer layouts and Templates with seopress.
	 * @since 2.1.8
	 */
	public static function fix_seopress() {
		if ( isset( $_POST['fl-template'] ) ) {
			remove_action( 'save_post', 'seopress_bulk_quick_edit_save_post' );
		}
	}

	/**
	 * Footer action for fl_fix_woo_short_description to print foundf css.
	 * @since 2.1.7
	 */
	public static function fix_woo_short_description_footer() {
		global $fl_woo_description_fix;
		if ( is_array( $fl_woo_description_fix ) && ! empty( $fl_woo_description_fix ) ) {
			echo implode( "\n", $fl_woo_description_fix );
		}
	}

	/**
	 * If short description is blank and there is a layout in the product content
	 * css will not be enqueued because woocommerce adds the css to the json+ld
	 * @since 2.1.7
	 */
	public static function fix_woo_short_description( $content ) {

		global $post, $fl_woo_description_fix;

		// if there is a short description no need to carry on.
		if ( '' !== $content ) {
			return $content;
		}

		// if the product content contains a layout shortcode then extract any css to add to footer later.
		if ( isset( $post->post_content ) && false !== strpos( $post->post_content, '[fl_builder_insert_layout' ) ) {
			$dummy   = do_shortcode( $post->post_content );
			$scripts = preg_match_all( "#<link rel='stylesheet'.*#", $dummy, $out );
			if ( is_array( $out ) ) {
				if ( ! is_array( $fl_woo_description_fix ) ) {
					$fl_woo_description_fix = array();
				}
				foreach ( $out[0] as $script ) {
					$fl_woo_description_fix[] = $script;
				}
			}
			// now we will use the content as the short description.
			$content = strip_shortcodes( wp_strip_all_tags( $post->post_content ) );
		}
		return $content;
	}

	/**
	 * Remove Popup-Maker post-type from admin settings post-types.
	 * @since 2.1.7
	 */
	public static function admin_settings_post_types_popup( $types ) {
		if ( class_exists( 'Popup_Maker' ) && isset( $types['popup'] ) ) {
			unset( $types['popup'] );
		}
		return $types;
	}

	/**
	 * Remove wpbb post:content from post_content as it causes inception.
	 * @since 2.1.7
	 */
	public static function theme_post_content_fix( $content ) {
		return preg_replace( '#\[wpbb\s?post:content.*\]#', '', $content );
	}

	/**
	 * Whitelist files in bb-theme and bb-theme-builder in PHPCompatibility Checker plugin.
	 * @since 2.1.6
	 */
	public static function bb_compat_fix( $folders ) {
		// Theme
		$folders[] = '*/bb-theme/includes/vendor/Less/*';
		// Themer
		$folders[] = '*/bb-theme-builder/includes/post-grid-default-html.php';
		$folders[] = '*/bb-theme-builder/includes/post-grid-default-css.php';
		// bb-plugin
		$folders[] = '*/bb-plugin/includes/ui-field*.php';
		$folders[] = '*/bb-plugin/includes/ui-settings-form*.php';
		// lite
		$folders[] = '*/beaver-builder-lite-version/includes/ui-field*.php';
		$folders[] = '*/beaver-builder-lite-version/includes/ui-settings-form*.php';
		return $folders;
	}

	/**
	 * Fix issue with WPMUDEV Smush It.
	 * @since 2.1.6
	 */
	public static function fix_smush_it() {
		if ( FLBuilderModel::is_builder_active() ) {
			add_filter( 'wp_smush_enqueue', '__return_false' );
		}
	}

	/**
	 * Fix issue with Prevent Direct Access Gold.
	 * @since 2.1.6
	 */
	public static function fix_protector_gold() {
		if ( FLBuilderModel::is_builder_active() && class_exists( 'Prevent_Direct_Access_Gold' ) && ! function_exists( 'get_current_screen' ) ) {
			function get_current_screen() {
				$args         = new StdClass;
				$args->id     = 'Beaver';
				$args->action = 'Builder';
				return $args;
			}
		}
	}

	/**
	 * Fix issue with Templator plugin.
	 * @since 2.1.6
	 */
	public static function fix_templator() {
		if ( FLBuilderModel::is_builder_active() && class_exists( 'Templator_Import' ) ) {
			remove_action( 'media_buttons', array( Templator_Import::get_instance(), 'import_template_button' ) );
		}
	}

	/**
	 * Fix for Enfold theme always loading wp-mediaelement
	 * @since 2.1.5
	 */
	public static function not_load_mediaelement( $condition, $options ) {
		if ( FLBuilderModel::is_builder_active() ) {
			$condition = true;
		}
		return $condition;
	}

	/**
	 * Fix Event Calendar widget not loading assets when added as a widget module.
	 * @since 2.1.5
	 */
	public static function tribe_events_pro_widget_render_fix( $class, $args, $instance ) {
		if ( isset( $args['widget_id'] ) && false !== strpos( $args['widget_id'], 'fl_builder_widget' ) ) {
			if ( class_exists( 'Tribe__Events__Pro__Mini_Calendar' ) ) {
				if ( method_exists( Tribe__Events__Pro__Mini_Calendar::instance(), 'register_assets' ) ) {
					Tribe__Events__Pro__Mini_Calendar::instance()->register_assets();
				} else {
					if ( class_exists( 'Tribe__Events__Pro__Widgets' ) && method_exists( 'Tribe__Events__Pro__Widgets', 'enqueue_calendar_widget_styles' ) ) {
						Tribe__Events__Pro__Widgets::enqueue_calendar_widget_styles();
					}
				}
			}
		}
	}

	/**
	 * Fix Enjoy Instagram feed on website with WordPress Widget and Shortcode issues with the builder.
	 * @since 2.0.6
	 */
	public static function fix_enjoy_instagram() {
		if ( FLBuilderModel::is_builder_active() ) {
			remove_action( 'wp_head', 'funzioni_in_head' );
		}
	}

	/**
	 * Turn off Hummingbird minification
	 * @since 2.1
	 */
	public static function fix_hummingbird() {
		if ( FLBuilderModel::is_builder_active() ) {
			add_filter( 'wp_hummingbird_is_active_module_minify', '__return_false', 500 );
		}
	}

	/**
	 * Support for tinyPNG.
	 *
	 * Runs cropped photos stored in cache through tinyPNG.
	 */
	public static function tinypng_support( $cropped_path, $editor ) {

		if ( class_exists( 'Tiny_Settings' ) ) {
			try {
				$settings = new Tiny_Settings();
				$settings->xmlrpc_init();
				$compressor = $settings->get_compressor();
				if ( $compressor ) {
					$compressor->compress_file( $cropped_path['path'], false, false );
				}
			} catch ( Exception $e ) {
				//
			}
		}
	}

	/**
	 * Support for WooCommerce Memberships.
	 *
	 * Makes sure builder content isn't rendered for protected posts.
	 */
	public static function wc_memberships_support() {

		if ( function_exists( 'wc_memberships_is_post_content_restricted' ) ) {
			add_filter( 'fl_builder_do_render_content', function( $do_render, $post_id ) {
				if ( wc_memberships_is_post_content_restricted() ) {
					// check if user has access to restricted content
					if ( ! current_user_can( 'wc_memberships_view_restricted_post_content', $post_id ) ) {
						$do_render = false;
					} elseif ( ! current_user_can( 'wc_memberships_view_delayed_post_content', $post_id ) ) {
						$do_render = false;
					}
				}
				return $do_render;
			}, 10, 2 );
		}
	}

	/**
	 * If FORCE_SSL_ADMIN is enabled but the frontend is not SSL fixes a CORS error when trying to upload a photo.
	 * `add_filter( 'fl_admin_ssl_upload_fix', '__return_false' );` will disable.
	 *
	 * @since 1.10.2
	 */
	public static function admin_ssl_upload_fix() {
		if ( defined( 'FORCE_SSL_ADMIN' ) && ! is_ssl() && is_admin() && FLBuilderAJAX::doing_ajax() ) {
			/**
			 * Disable CORS upload fix when FORCE_SSL_ADMIN is enabled.
			 * @see fl_admin_ssl_upload_fix
			 */
			if ( isset( $_POST['action'] ) && 'upload-attachment' === $_POST['action'] && true === apply_filters( 'fl_admin_ssl_upload_fix', true ) ) {
				force_ssl_admin( false );
			}
		}
	}

	/**
	 * Disable support Buddypress pages since it's causing conflicts with `the_content` filter
	 *
	 * @param bool $is_editable Wether the post is editable or not
	 * @param $post The post to check from
	 * @return bool
	 */
	public static function bp_pages_support( $is_editable, $post = false ) {
		// Frontend check
		if ( ! is_admin() && class_exists( 'BuddyPress' ) && ! bp_is_blog_page() ) {
			$is_editable = false;
		}
		// Admin rows action link check and applies to page list
		if ( is_admin() && class_exists( 'BuddyPress' ) && $post && 'page' == $post->post_type ) {
			$bp = buddypress();
			if ( $bp->pages ) {
				foreach ( $bp->pages as $page ) {
					if ( $post->ID == $page->id ) {
						$is_editable = false;
						break;
					}
				}
			}
		}
		return $is_editable;
	}

	/**
	 * There is an issue with Jetpack Photon and circle cropped photo module
	 * returning the wrong image sizes from the bb cache folder.
	 * This filter disables photon for circle cropped photo module images.
	 */
	public static function photo_photon_exception( $val, $src, $tag ) {

		// Make sure its a bb cached image.
		if ( false !== strpos( $src, 'bb-plugin/cache' ) ) {

			// now make sure its a circle cropped image.
			if ( false !== strpos( basename( $src ), '-circle' ) ) {
				/**
				 * Disable photon circle imgae fix default ( true )
				 * @see fl_photo_photon_exception
				 */
				return apply_filters( 'fl_photo_photon_exception', true );
			}
		}
		// return original val
		return $val;
	}

	/**
	 * Filter rendered module content and if safemode is active safely display a message.
	 * @since 1.10.7
	 */
	public static function render_module_content_filter( $contents, $module ) {
		if ( isset( $_GET['safemode'] ) && FLBuilderModel::is_builder_active() ) {
			return sprintf( '<h3>[%1$s] %2$s %3$s</h3>', __( 'SAFEMODE', 'fl-builder' ), $module->name, __( 'module', 'fl-builder' ) );
		} else {
			return $contents;
		}
	}

	/**
	 * Duplicate posts plugin fixes when cloning BB template.
	 *
	 * @since 1.10.8
	 * @param int $meta_id The newly added meta ID
	 * @param int $object_id ID of the object metadata is for.
	 * @param string $meta_key Metadata key
	 * @param string $meta_value Metadata value
	 * @return void
	 */
	public static function template_meta_add( $meta_id, $object_id, $meta_key, $meta_value ) {
		global $pagenow;

		if ( 'admin.php' != $pagenow ) {
			return;
		}

		if ( ! isset( $_REQUEST['action'] ) || 'duplicate_post_save_as_new_post' != $_REQUEST['action'] ) {
			return;
		}

		$post_type = get_post_type( $object_id );
		if ( 'fl-builder-template' != $post_type || '_fl_builder_template_id' != $meta_key ) {
			return;
		}

		// Generate new template ID;
		$template_id = FLBuilderModel::generate_node_id();
		update_post_meta( $object_id, '_fl_builder_template_id', $template_id );
	}

	/**
	 * Stop bw-minify from optimizing when builder is open.
	 * @since 1.10.9
	 */
	public static function bwp_minify_is_loadable_filter( $args ) {
		if ( FLBuilderModel::is_builder_active() ) {
			return false;
		}
		return $args;
	}

	/**
	* Fixes an issue on search archives if one of the results contains same shortcode
	* as is currently trying to render.
	*
	* @since 1.10.9
	* @param bool $render Render shortcode.
	* @param array $attrs Shortcode attributes.
	* @param array $args Passed to FLBuilder::render_query
	* @return bool
	*/
	public static function insert_layout_render_search( $render, $attrs, $args ) {
		global $post, $wp_query;
		if ( is_search() && is_object( $post ) && is_array( $wp_query->posts ) ) {
			foreach ( $wp_query->posts as $queried_post ) {
				if ( $post->ID === $queried_post->ID ) {
					preg_match( '#(?<=fl_builder_insert_layout).*[id|slug]=[\'"]?([0-9a-z-]+)#', $post->post_content, $matches );
					if ( isset( $matches[1] ) ) {
						return false;
					}
				}
			}
		}
		return $render;
	}

	/**
	* Fixes ajax issues with Event Espresso plugin when builder is open.
	* @since 2.1
	*/
	public static function ee_suppress_notices() {
		if ( FLBuilderModel::is_builder_active() ) {
			add_filter( 'FHEE__EE_Front_Controller__display_errors', '__return_false' );
		}
	}

	/**
	 * Stops ee from outputting HTML into our ajax responses.
	 * @since 2.1
	 */
	public static function ee_before_ajax() {
		add_filter( 'FHEE__EE_Front_Controller__display_errors', '__return_false' );
	}

	/**
	 * Stops ee from loading espresso_default.css stylesheet in the builder to prevent hiding of buttons/tabs in TinyMCE
	 * @since 2.3
	 */
	public static function ee_remove_stylesheet() {
		if ( class_exists( 'FLBuilderModel' ) && ( FLBuilderModel::is_builder_active() ) ) {
				wp_deregister_style( 'espresso_default' );
		}
	}

	/**
	* Plugin Enjoy Instagram loads its js and css on all frontend pages breaking the builder.
	* @since 2.0.1
	*/
	public static function aggiungi_script_instafeed_owl() {
		if ( FLBuilderModel::is_builder_active() ) {
			remove_action( 'wp_enqueue_scripts', 'aggiungi_script_instafeed_owl' );
		}
	}

	/**
	 * Remove Activemember360 shortcodes from saved post content to stop them rendering twice.
	 * @since 2.0.6
	 */
	public static function activemember_shortcode_fix( $content ) {
		return preg_replace( '#\[mbr.*?\]#', '', $content );
	}

	/**
	 * Remove iMember360 shortcodes from saved post content to stop them rendering twice.
	 * @since 2.0.6
	 */
	public static function imember_shortcode_fix( $content ) {
		return preg_replace( '#\[i4w.*?\]#', '', $content );
	}

	/**
	 * Fix javascript issue caused by nextgen gallery when adding modules in the builder.
	 * @since 2.0.6
	 */
	public static function fix_nextgen_gallery() {
		if ( isset( $_GET['fl_builder'] ) || isset( $_POST['fl_builder_data'] ) || FLBuilderAJAX::doing_ajax() ) {
			if ( ! defined( 'NGG_DISABLE_RESOURCE_MANAGER' ) ) {
				define( 'NGG_DISABLE_RESOURCE_MANAGER', true );
			}
		}
	}

	/**
	 * Fix Tasty Recipes compatibility issues with the builder.
	 * @since 2.0.6
	 */
	public static function fix_tasty_recipes() {
		if ( FLBuilderModel::is_builder_active() ) {
			remove_action( 'wp_enqueue_editor', array( 'Tasty_Recipes\Assets', 'action_wp_enqueue_editor' ) );
			remove_action( 'media_buttons', array( 'Tasty_Recipes\Editor', 'action_media_buttons' ) );
		}
	}

	/**
	 * Dequeue GeneratePress fa5 js when builder is open.
	 * @since 2.1
	 */
	public static function fix_generatepress_fa5() {
		if ( FLBuilderModel::is_builder_active() ) {
			add_filter( 'generate_fontawesome_essentials', '__return_true' );
		}
	}

	/**
	 * Try to render Ninja Forms JS templates when rendering an AJAX layout
	 * in case the layout includes one of their shortcodes. This won't do
	 * anything if no templates need to be rendered.
	 * @since 2.1
	 */
	public static function render_ninja_forms_js( $response ) {
		if ( class_exists( 'NF_Display_Render' ) ) {
			ob_start();
			NF_Display_Render::output_templates();
			$response['html'] .= ob_get_clean();
		}
		return $response;
	}
}
FLBuilderCompatibility::init();
