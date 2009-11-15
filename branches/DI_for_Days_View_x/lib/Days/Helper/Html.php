<?php
/**
 * Html Helper - work with html document.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysHelperHtml
 * @package      Days
 * @subpackage   Helper
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Helper_Html extends Days_Helper_Abstract {
	public static function br($number = 1) {
		if(!is_int($number) || $number < 0) {
			throw new Days_Exception("\$number have to be an int and can no be lesser than 0");
		}
		return str_repeat('<br />', $number);
	}

	public static function nbsp($number = 1) {
		if(!is_int($number) || $number < 0) {
			throw new Days_Exception("\$number have to be an int and can no be lesser than 0");
		}
		return str_repeat('&nbsp;', $number);
	}

	public static function heading($text, $h = 1) {
		if(!is_int($h) || $h < 1 || $h > 6) {
			throw new Days_Exception("\$h have to be an int and can no be lesser than 1 or bigger than 6");
		}
		if(!is_string($text)) {
			throw new Days_Exception("\$text have to be a string");
		}
		return "<h{$h}>{$text}</h{$h}>";
	}

	public static function image($opt) {
		$img = "<img src=\"";
		if(is_string($opt)) {
			$img .= $opt . " alt=\"\"";
		}
		elseif(is_array($opt)) {
			$img .= $opt['src'] . "alt=\"";
			if(isset($opt['alt']) {
				$img .= $opt['alt'];
			}
			$img .= "\"";
			if(isset($opt['title'])) {
				$img .= " title=\"{$opt['title']}\"";
			}
			if(isset($opt['width'])) {
				$opt['style']['width'] = $opt['width'];
			}
			if(isset($opt['height'])) {
				$opt['style']['height'] = $opt['height'];
			}
			if(isset($opt['style'])) {
				$img .= " style=\"{$opt['style']}\"";
			}
			if(isset($opt['id'])) {
				if(is_array($opt['id'])) {
					$opt['id'] = implode(' ', $opt['id']);
				}
				$img .= " id=\"{$opt['id']}\"";
			}
			if(isset($opt['class'])) {
				if(is_array($opt['class'])) {
					$opt['class'] = implode(' ', $opt['class']);
				}
				$img .= " class=\"{$opt['class']}\"";
			}
			if(isset($opt['rel'])) {
				$img .= " rel=\"{$opt['rel']}\"";
			}
		}
		else {
			throw new Days_Exception("\$opt have to be string|array");
		}
		return $img . " />";
	}

	function link($options) {
		if(!is_string($options) || !is_array($options)) {
			throw new Days_Exception("\$options have to be an array or a string");
		}
	}
}