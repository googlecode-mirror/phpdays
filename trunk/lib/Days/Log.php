<?php
/**
 * Log - user for save application runtime errors to storage (file or database).
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysLog
 * @package      phpDays
 * @subpackage   phpDays library
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Log {
    const TRACE   = 1;
    const WARNING = 2;
    const ERROR   = 4;
    const INFO    = 8;
    const PROFILE = 16;
    private static $_errors = array();

    public static function add($message, $category='app', $level=self::INFO) {
        // add unique message
        if ('' != $message AND ! in_array($message, self::$_errors))
            self::$_errors[] = array($message, $category, $level, microtime(true));
    }

    public static function profile($message, $category='app') {
        // not send message
        if (! Days_Config::load()->get('engine/debug', false))
            return;
        // send message now
        switch (strtolower(Days_Config::load()->get('log/type', 'file'))) {
            // send to FirePHP
            case 'fb':
            case 'firebug':
            case 'firephp':
                self::logtoFirephp(array($message), self::PROFILE);
                break;
        }
    }

    public static function save() {
        if (! empty(self::$_errors)) {
            // prepare data
            $sErrorFile   = str_replace(':', '.', $_SERVER['HTTP_HOST']);
            $sLogDir      = Days_Engine::appPath() . 'system/log/';
            // get current application error levels
            $level = Days_Config::load()->get('log/level');
            // save log
            if (Days_Config::load()->get('engine/debug', false)) {
                $messages = self::getMessages($level);
                if(count($messages)==0)
                    return;
                switch (strtolower(Days_Config::load()->get('log/type', 'file'))) {
                    // save to SQLite
                    case 'sqlite':
                        self::logtoSqlite($messages, $sErrorFile, $sLogDir);
                        break;
                    // send to FirePHP
                    case 'fb':
                    case 'firebug':
                    case 'firephp':
                        self::logtoFirephp($messages);
                        break;
                    // save to FILE
                    case 'file':
                    default:
                        self::logtoFile($messages, $sErrorFile, $sLogDir);
                }
            }
            // clear saved errors
            self::$_errors = array();
        }
    }

    /**
    * Save error log to sqlite-database
    *
    * CREATE TABLE "error_log" (
    *    "error_date" DATETIME,
    *    "error_ip" VARCHAR,
    *    "error_url" VARCHAR,
    *    "error_referer" VARCHAR,
    *    "error_text" VARCHAR,
    *    "error_trace" TEXT,
    *    "error_count" INTEGER DEFAULT 0
    * )
    *
    * @param $messages: error messages
    * @param $sErrorFile: database file
    * @param $sLogDir: directory for database file
    */
    protected static function logtoSqlite($messages, $sErrorFile, $sLogDir) {
        // create connection to sqlite db
        $db_sqlt = Zend_Db::factory('Pdo_Sqlite', array('dbname'=>$sLogDir."".$sErrorFile.".err.sqlite"));
        // increase count of exists error
        $select = $db_sqlt->select();
        $select->from('error_log', 'count(*)')
            ->where('error_date=?', date('Y-m-d'))
            ->where('error_text=?', $messages[0]);
        if ((int) $db_sqlt->fetchOne($select) > 0) {
            $sql = "update error_log set error_count=error_count+1 where error_date=? and error_text=?";
            $db_sqlt->query($sql, array(date('Y-m-d'), $messages[0]));
        }
        // create new error
        else {
            $error_data = array(
                'error_date'    => date('Y-m-d'),
                'error_ip'      => $_SERVER['REMOTE_ADDR'],
                'error_url'     => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                'error_referer' => (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''),
                'error_text'    => $messages[0],
                'error_trace'   => implode("\n", $messages) . "\n\n",
                'error_count'   => 1);
            $db_sqlt->insert('error_log', $error_data);
        }
        unset ($db_sqlt);
    }

    /**
    * Save error log to file
    *
    * @param $messages: error messages
    * @param $sErrorFile: filename for error log
    * @param $sLogDir: directory for $sErrorFile
    */
    protected static function logtoFile($messages, $sErrorFile, $sLogDir) {
        $sSystemInfo  = date('[j/n/Y H:i:s]') . "\n";
        $sSystemInfo .= '  IP:                  ' . $_SERVER['REMOTE_ADDR'] . "\n";
        $sSystemInfo .= '  Query string:        http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "\n";
        // set previous page adress
        if(isset($_SERVER['HTTP_REFERER']))
            $sSystemInfo .= '  Previous page:       ' . $_SERVER['HTTP_REFERER'] . "\n";
        $sMessages = implode("\n", $messages) . "\n\n";
        error_log($sSystemInfo . $sMessages, 3, "{$sLogDir}/{$sErrorFile}.err");
    }

    /**
     * Display error log in Firephp
     *
     * @param string $messages Error messages
     * @param string $level Error type
     */
    protected static function logtoFirephp($messages, $level=self::INFO) {
        foreach ($messages as $message)
            Firephp::getInstance(true)->log($message, self::getLevel($level));
    }

    /**
     * Return messages with specified error level.
     *
     * @param int $level Error levels joined with `&` operation
     * @return array All messages with specified level
     */
    protected static function getMessages($level=null) {
        $errMessages = array ();
        foreach (self::$_errors as $errorInfo)
            // get messages with specified level
            if (is_null($level) OR ($level & $errorInfo[2]))
                $errMessages[] = $errorInfo[0];//"{$errorInfo[3]}: {$errorInfo[0]}";
        return $errMessages;
    }

    /**
     * Convert error level to string.
     *
     * @param int $level Level constant
     */
    protected static function getLevel($level) {
        $levelName = 'undefined';
        switch ($level) {
            case self::TRACE:
                $levelName = 'TRACE';
                break;
            case self::WARNING:
                $levelName = 'WARNING';
                break;
            case self::ERROR:
                $levelName = 'ERROR';
                break;
            case self::INFO:
                $levelName = 'INFO';
                break;
            case self::PROFILE:
                $levelName = 'PROFILE';
                break;
        }
        return $levelName;
    }
}