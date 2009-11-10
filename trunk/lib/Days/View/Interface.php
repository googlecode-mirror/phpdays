<?php
/**
 * Controller - adapter interface.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysViewInterface
 * @package      Days
 * @subpackage   View
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
interface Days_View_Interface {
    public function __construct();
    public function render($template);
    public function get($var, $default=null);
    public function set($var, $value, $merge=false, $delimiter='-');
}