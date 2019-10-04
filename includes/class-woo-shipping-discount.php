<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Woo_ShippingDiscount {

	public static function init() {
		if ( is_admin() ) {
			self::admin_includes();
			Woo_ShippingDiscount_ProductFields::init();
		}

		add_filter( 'woocommerce_package_rates', array( __CLASS__, 'apply_discounts' ) );
	}

	public static function admin_includes() {
		include_once dirname( __FILE__ ) . '/class-woo-shipping-discount-product-fields.php';
	}

	public static function apply_discounts( $rates ) {
		$cart_items = WC()->cart->get_cart();
		$total_shipping_discount = self::get_shipping_discount_by_cart( $cart_items );

		foreach ( $rates as $rate_key => $rate_values ) {
			$original_cost = floatval( $rates[$rate_key]->cost );
			$new_cost = 0;

			if ( $original_cost > 0 && $total_shipping_discount < $original_cost ) {
				$new_cost = $original_cost - $total_shipping_discount;
			}

			$rates[$rate_key]->cost = number_format( $new_cost, 2 );
		}

		return $rates;
	}

	/**
	 * @param array $cart_items
	 *
	 * @return number total shipping discount
	 */
	public static function get_shipping_discount_by_cart( $cart_items ) {
		$total_discount = 0;

		foreach ( $cart_items as $cart_item => $cart_item_values ) {
			$data = $cart_item_values['data']; /** @var WC_Product_Variation $data */
			$shipping_discount = self::get_shipping_discount_by_product( $data->get_id() ) * $cart_item_values['quantity'];
			$total_discount += $shipping_discount;
		}

		return $total_discount;
	}

	/**
	 * @param number $post_id product post ID
	 *
	 * @return number shipping discount
	 */
	public static function get_shipping_discount_by_product( $post_id ) {
		$meta = get_post_meta( $post_id, 'shipping_discount', true );

		if ( empty( $meta ) ) {
			return 0;
		}

		return floatval( $meta );
	}
}
