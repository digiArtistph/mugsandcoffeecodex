<?php

class DescriptionFactory {
	public static function factory($type, $fields) {
		switch ($type) {
			case 1:
				return new GarageDescription($fields);
			case 2:
				return new SellDescription($fields);
			case 3:
				return new IsoInoDescription($fields);
			case 4:
			default:
				return new GeneralDescription($fields);
		}
	}
}