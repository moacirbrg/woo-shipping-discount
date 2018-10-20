<?php
/**
 * Plugin Name:          WooCommerce Shipping Discount
 * Plugin URI:           https://github.com/moacirbrg/woo-shipping-discount
 * Description:          Shipping discounts for WooCommerce
 * Author:               Moacir Braga
 * Version:              0.0.1
 * License:              GPLv2 or later
 * Text Domain:          woo-shipping-discount
 * Domain Path:          /languages
 * WC requires at least: 4.6.0
 * WC tested up to:      4.9.8
 *
 * Copyright (C) 2018  Moacir Braga
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/gpl-2.0.txt>.
 *
 * @package WooCommerce_Shipping_Discount
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'WOO_SHIPPING_DISCOUNT_PLUGIN_FILE', __FILE__ );
define( 'WOO_SHIPPING_DISCOUNT_DOMAIN', 'woo-shipping-discount' );

if ( ! class_exists( 'Woo_ShippingDiscount' ) ) {
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		include_once dirname( __FILE__ ) . '/includes/class-woo-shipping-discount.php';
		Woo_ShippingDiscount::init();
		add_action( 'plugins_loaded', function() {
			load_plugin_textdomain( WOO_SHIPPING_DISCOUNT_DOMAIN, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
		} );
	}
}
