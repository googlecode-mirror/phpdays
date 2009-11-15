<?php
/**
 * Days_Validate - check data by criteria.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysValidate
 * @package      Days
 * @subpackage   Days
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Validate {
    public function check($value, $criteria) {
        if (! is_array($criteria))
            $criteria = array ($criteria);
        // result of check
        $correct = true;
        // check all criteria
        foreach ($criteria as $name=>$params) {
            // criteria name without parameters
            if (is_numeric($name)) {
                $name = $params;
                $params = array();
            }
            // set correct method name
            $method = "is{$name}";
            // incorrect criteria name
            if (! method_exists(self, $method))
                throw new Days_Exception("Incorrect criteria name `{$name}`");
            // check by criteria
            $correct &= self::$method($value, $params);
        }
        // return result
        return $correct;
    }

    /** Check value by boolean */
    public static function isBool($value) {
        return is_bool($value);
    }

    /** Copare value with displayed captcha code */
    public static function isCaptcha($value) {
    }

    /** Check values by equal */
    public static function isEqual($value, $value2) {
    }

    /** Check value by correct email adress */
    public static function isEmail($value) {
    }

    /** Check value by existing file */
    public static function isFile($value) {
    }

    /** Check value by number */
    public static function isNumber($value, $isReal=false) {
    }

    /** Check value by number range */
    public static function isNumberRange($value, $from, $to) {
    }

    /** Check value by regular expression */
    public static function isRegular($value, $expression) {
    }

    /** Check value by not empty and not null */
    public static function isRequired($value) {
    }

    /**
     * Check value by string.
     *
     * @param string $value Value to check
     * @param array $params Parameters
     *  - empty: allow empty value
     *  - len: lenmgt of sting
     *  - min: minimal lenght
     *  - max: maximum length
     */
    public static function isString($value, array $params) {
    }

    /**
     * Check value by correct url adress.
     *
     * @param string $value Value to check
     */
    public static function isUrl($value) {
    }
}