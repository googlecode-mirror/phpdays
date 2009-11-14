<?php
/**
 * Array Helper - work with arrays.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysHelperArray
 * @package      Days
 * @subpackage   Helper
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Helper_Array extends Days_Helper_Abstract {
	//take value from an array with the gived key
	public static function element($ary, $key, $default = false) {
		if(!isset($ary[$key])) {
			//element is not defined, we return the $default value
			return $default;
		}
		else {
			//element is defined, return the value of the array
			return $ary[$key];
		}
	}

	//take key from an array with the gived value
	public static function key($element, $value, $default = false, $once = false) {
		$return_key = array();
		foreach($element as $element_key => $element_value) {
			if($element_value == $value) {
				$return_key = array_merge($return_key, array($element_key));
			}
		}
		switch(count($return_key)) {
			case 0:
				return $default;
				break;
			case 1:
				return $return_key[0];
			default:
				return $return_key;
		}
	}

	//take an element in the array gived
	public static function random_element($ary, $min = 0, $max = false) {
		//is the $max value undefined or bigger than the array ?
		if(!$max || $max > count($ary)) {
			$max = count($ary);
		}
		//is the $min value lesser or bigger than $max ?
		if($min < 0 || $min > $max) {
			$min = 0;
		}
		//Return an random value
		return $ary[rand($min, $max)];
	}
}