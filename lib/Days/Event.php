<?php
/**
 * Days_Event - implementation of observer design pattern.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysEvent
 * @package      Days
 * @subpackage   Days
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Event {
    private static $_observers = array();

    /**
     * Add observer to specified event.
     *
     * @param string $event Name of event (user_login_before, user_login_after, user_login_success, user_login_fail)
     * @param string $observer Name of feedback function to call on this event
     */
    public static function add($event, $observer) {
        // check if observer callable
        if (! is_callable($observer)) {
            $observer = var_export($observer, true);
            throw new Days_Exception("Observer function not found `{$observer}`");
        }
        // first event with specified type
        if (! array_key_exists($event, self::$_observers)){
            self::$_observers[$event] = array();
        }
        // add unique observer only
        if (! in_array($observer, self::$_observers[$event])){
            self::$_observers[$event][] = $observer;
        }
    }

    /**
     * Execute all observers for specified event.
     *
     * @param string $event Name of event (user_login_before, user_login_after, user_login_success, user_login_fail)
     * @param array $params Parameters passed to each event
     */
    public static function run($event, array $params=array()) {
        //get all event observers
        $observers=self::get($event);
        foreach ($observers as $observer) {
            // call feedback function
            call_user_func_array($observer, $params);
        }
    }

    /**
     * Get all observers for specified event.
     *
     * @param string $event Name of event (user_login_before, user_login_after, user_login_success, user_login_fail)
     * @return array
     */
    public static function get($event) {
        if(isset(self::$_observers[$event]) && is_array(self::$_observers[$event])) {
            return self::$_observers[$event];
        }
        return array();
    }
}