<?php
/**
 * Filter - validate input data.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.sf.net).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysFilter
 * @package      phpDays
 * @subpackage   phpDays library
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Filter {
    private static $_strLogin = '"^[a-z0-9 ]{2,25}$"i';
    private static $_strPassword = '"^[a-z0-9]{5,25}$"i';
    private static $_strDate = '"^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$"i';

    public static function hasPreg( $mixData, $strPattern ) {
        if ( !preg_match( $strPattern, $mixData ) )
            return false;
        return $mixData;
    }

    public static function hasLogin( $strData ) {
        return self::hasPreg( $strData, self::$_strLogin );
    }

    public static function hasPassword( $strData ) {
        return self::hasPreg( $strData, self::$_strPassword );
    }

    public static function hasEmail( $strData ) {
        return filter_var( $strData, FILTER_VALIDATE_EMAIL );
    }

    public static function hasUrl( $strData ) {
        return filter_var( $strData, FILTER_VALIDATE_URL );
    }

    public static function hasIp( $strData ) {
        return filter_var( $strData, FILTER_VALIDATE_IP );
    }

    public static function hasDate( $strData ) {
        return self::hasPreg( $strData, self::$_strDate );
    }

    public static function hasBool( $boolData ) {
        return filter_var( $boolData, FILTER_VALIDATE_BOOLEAN );
    }

    public static function hasInt( $intData, $intMin=null, $intMax=null ) {
        // set range
        $arrOptions = array("options" =>array());
        if ( $intMin!=null )
            $arrOptions['options']['min_range'] = $intMin;
        if ( $intMax!=null )
            $arrOptions['options']['max_range'] = $intMax;
        // verify data
        return filter_var( $intData, FILTER_VALIDATE_BOOLEAN, $arrOptions );
    }

    public static function hasFloat( $floatData ) {
        // verify data
        return filter_var( $floatData, FILTER_VALIDATE_FLOAT );
    }

    public static function hasValid( $arrData, $arrCertainly ) {
        // validate all data
        foreach ( $arrData as $strKey=>$mixValue )
            // certainly value incorrect
            if ( $mixValue===false && in_array( $strKey, $arrCertainly ) )
                return false;
        // all certainly values corrected
        return true;
    }
}