<?php

class CartFactory {

	public static function factory ($cart) {
		
		switch (strtolower($cart)) {
			case 'sale':
				return new SaleCart();
			case 'garage':
			default:
				return new GarageCart();
		}
	}
}