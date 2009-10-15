<?php
/**
 * View (MVC pattern) - show template based on defined variables.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.sf.net).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://phpdays.sf.net/
 * @package      phpDays
 * @subpackage   phpDays library
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_View {
    public static function factory($engine) {
        $engine = ucfirst($engine);
        $className = "Days_View_{$engine}";
        return new $className();
    }

    private function __construct() {
    }
}