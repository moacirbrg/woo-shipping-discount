<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Woo_ShippingDiscount_ProductFields {

	public static function init() {
		add_action( 'woocommerce_product_options_shipping', array( __CLASS__, 'add_fields' ) );
		add_action( 'woocommerce_process_product_meta', array( __CLASS__, 'save_fields' ) );
	}

	public static function add_fields() {
		self::add_shipping_discount_field();
	}

	public static function add_shipping_discount_field() {
		woocommerce_wp_text_input(
			array(
				'id'                => 'shipping_discount',
				'label'             => __( 'Shipping discount', WOO_SHIPPING_DISCOUNT_DOMAIN ),
				'placeholder'       => '0.00',
				'description'       => __( 'Cumulative discount on total price of the shipping', WOO_SHIPPING_DISCOUNT_DOMAIN ),
				'desc_tip'          => 'true',
				'type'              => 'number',
				'custom_attributes' => array(
					'step' => 'any',
					'min'  => '0'
				)
			)
		);
	}

	public static function save_fields( $post_id ) {
		$shipping_discount = $_POST['shipping_discount'];
		if ( !empty( $shipping_discount ) ) {
			update_post_meta( $post_id, 'shipping_discount', esc_attr( $shipping_discount ) );
		}
	}
}