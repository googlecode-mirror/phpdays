<?php
/**
 * User - info about current user.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysUser
 * @package      Days
 * @subpackage   Days
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_User {
    /*
     * This data is for test of Observer pattern
     */
    private static $_user = array("userName"=>"user", "passWord"=> "user");
    private static $_admin = array('userName'=>'admin', 'passWord'=> 'admin');

    /*
     * This method implementation is also for test of Observer pattern
     */
    public static function login(){
        if (isset($_GET["u"]) && (isset($_GET["p"]))){
            Days_Log::add("u and p are set");
            $inputUserName = $_GET["u"];
            $inputPassword = $_GET["p"];
            if ($inputUserName == self::$_user["userName"] &&
                $inputPassword == self::$_user["passWord"]){
                session_start();
                $_SESSION['isLoggedIn'] = true;
                Days_Log::add('Logging in as user');
                return;
            }
            if ($inputUserName == self::$_admin["userName"] &&
                $inputUserName == self::$_admin["passWord"]){
                //$isLoggedIn = true;
                session_start();
                $_SESSION['isLoggedIn'] = true;
                Days_Log::add('Logging in as admin');
                return;
            }
            Days_Log::add('Not logging in');
        } else {
            Days_Log::add("u or p is not set");
            Days_Log::add('Not logging in');
        }
    }


    /*
     * This method implementation is also for test of Observer pattern
     */
     public static function isLoggedIn(){
        session_start();
        if(isset($_SESSION['isLoggedIn'])){
            Days_Log::add("Logged in");
            return true;
        } else {
            Days_Log::add("Not logged in");
            return false;
        }
    }
}