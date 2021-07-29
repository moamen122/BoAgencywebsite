<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Plugin compatibility for Divi Testimonial Slider.
 *
 * @since ??
 */
class ET_Builder_Plugin_Compat_DiviTestimonialSlider extends ET_Builder_Plugin_Compat_Base {

	/**
	 * Constructor.
	 *
	 * @since ??
	 */
	public function __construct() {
		$this->plugin_id = 'divi-testimonial-slider/divi-testimonial-slider.php';
		$this->init_hooks();
	}

	/**
	 * Hook methods to WordPress.
	 *
	 * @since ??
	 *
	 * @return void
	 */
	public function init_hooks() {
		// Bail if there's no version found
		if ( ! $this->get_plugin_version() ) {
			return;
		}

		$hook  = array( $this, 'remove_random_default' );
		$slugs = array(
			'et_pb_b3_testimonial_archive',
			'et_pb_b3_testimonial_grid_slider',
			'et_pb_testimonial_slider',
		);

		foreach ( $slugs as $slug ) {
			add_filter( "et_pb_all_fields_unprocessed_{$slug}", $hook );
		}
	}

	/**
	 * Replace the random default with a fixed value.
	 *
	 * @since ??
	 *
	 * @param array $advanced_fields
	 *
	 * @return array
	 */
	public function remove_random_default( $fields_unprocessed ) {
		et_()->array_set( $fields_unprocessed, 'hidden_field.default', 50 );
		return $fields_unprocessed;
	}

}

new ET_Builder_Plugin_Compat_DiviTestimonialSlider();
