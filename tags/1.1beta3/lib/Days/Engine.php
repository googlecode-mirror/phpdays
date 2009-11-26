<?php
/**
 * Engine - start point for web application, based on php:Days framework.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysEngine
 * @package      Days
 * @subpackage   Days
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
final class Days_Engine {
    /** @var Days_Engine */
    private static $_instance;
    /** @var string */
    private static $_libPath;
    private static $_appPath;
    private static $_publicPath;
    private static $_brand;
    /** Debug mode */
    private static $_isDebug = false;

    /** Singleton */
    public static function run($appPath, $mode=null) {
        if (! isset(self::$_instance)) {
            self::$_instance = new self($appPath, $mode);
        }
        return self::$_instance;
    }

    /**
     * Automatic load class files.
     *
     * @param string $className Full name of class
     * @return bool
     */
    public static function autoload($className) {
        // set correct class name
        $classPathRarts = explode('_', $className);
        for ($i=0; $i<count($classPathRarts); $i++)
            $classPathRarts[$i] = ucfirst($classPathRarts[$i]);
        // get library name (start from upper case letter)
        $libName = $classPathRarts[0];
        // path to library
        $libPath = '';
        // check action type
        switch ($libName) {
            case 'Zend':
            case 'Days':
                $libPath = self::$_libPath;
                break;
            // application classes
            case self::$_brand:
                unset ($classPathRarts[0]);
                $libPath = self::$_appPath;
                break;
            // library and main file - equal name
            default:
                $libPath = self::$_libPath . $libName . '/';
        }
        $classPath = $libPath . implode('/', $classPathRarts) . '.php';
        // replace underline ('_') to slash ('/')
        if (! file_exists($classPath))
            return false;
        // include file
        include_once $classPath;
        // check definition
        if (! (class_exists($className, false) OR interface_exists($className, false)))
            throw new Days_Exception("Class or interface `{$className}` not defined in file `{$classPath}`");
    }

    public static function isDebug() {
        return self::$_isDebug;
    }

    public static function libPath() {
        return self::$_libPath;
    }

    public static function appPath() {
        return self::$_appPath;
    }

    public static function publicPath() {
        return self::$_publicPath;
    }

    /**
     * Run application.
     *
     * @param string $appPath Path to application
     * @param string $mode Name of configuration file used in work
     */
    private function __construct($appPath, $mode) {
        // set pathes
        self::$_libPath = realpath(dirname(__FILE__) . '/..') . '/';
        self::$_appPath = realpath($appPath) . '/';
        self::$_publicPath = getcwd() . '/';
        set_include_path(get_include_path() . PATH_SEPARATOR . self::$_libPath);
        spl_autoload_register(array(__CLASS__, 'autoload'));
        date_default_timezone_set('Europe/Helsinki');
        // set config main file
        if (! empty($mode))
            Days_Config::setDefaultConfig($mode);
        // set path for config
        Days_Config::setConfigPath(self::$_appPath . 'config/');
        // set debug mode
        self::$_isDebug = (bool)Days_Config::load()->get('engine/debug', false);
        // set brand
        self::$_brand = ucfirst(Days_Config::load()->get('engine/brand', 'app'));
        // set error level and handler
        $iErrorLevel = (self::isDebug() ? E_ALL|E_STRICT : E_ALL^E_NOTICE);
        error_reporting($iErrorLevel);
        setlocale(LC_ALL, 'ru_RU.UTF-8', 'RUS', 'RU');
        // not send execution errors to user
        ob_start();
        try {
            if (Days_Config::load()->get('engine/autorun', 1)) {
                $autorunClass = self::$_brand."_Controller_System_Autorun";
                // run predefined class
                if (class_exists($autorunClass) AND is_callable(array($autorunClass, 'run')))
                    call_user_func(array($autorunClass, 'run'));
            }
            Days_Event::run('engine.start');
            // get url info
            $controller = Days_Url::getSpec('controller');
            $action = Days_Url::getSpec('action');
            $ext = Days_Url::getSpec('ext');
            $brand = Days_Config::load()->get('engine/brand', 'app');
            Days_Event::run('controller.start');
            // set module path
            Days_Model::setPath(self::appPath() . 'Model/');
            Days_Model::setPrefix($brand);
            // set controller params
            $controllerClass = "{$brand}_Controller_" . ucfirst($controller);
            // use index controller for non-exists controllers
            if (! class_exists($controllerClass) AND Days_Config::load()->get('url/virtual')) {
                $controllerClass = "{$brand}_Controller_Index";
                $controller = 'index';
            }
            // set action name
            $actionMethod = (Days_Request::isAjax() ? "{$action}AjaxAction" : "{$action}Action");
            // set template path
            $template = "content/{$controller}/{$action}.{$ext}";
            // create controller
            if (! class_exists($controllerClass))
                throw new Days_Exception("Controller '{$controllerClass}' not found");
            $controllerObj = new $controllerClass($template);
            if (! $controllerObj instanceof Days_Controller)
                throw new Days_Exception("Controller '{$controllerClass}' should be extended from 'Days_Controller'");
            // call init() method for prepare object
            $controllerObj->init();
            Days_Event::run('controller.post.init');
            // execute PostAction before call specified action
            if (Days_Request::isPost()) {
                $actionPost = "{$action}PostAction";
                if (! method_exists($controllerObj, $actionPost))
                    throw new Days_Exception("Action {$actionPost} in controller {$controllerClass} not defined");
                call_user_func(array($controllerObj, $actionPost));
            }
            // call specified action
            if (! method_exists($controllerObj, $actionMethod))
                throw new Days_Exception("Action {$actionMethod} in controller {$controllerClass} not defined");
            $actionResult = call_user_func(array($controllerObj, $actionMethod));
            // ajax query
            if (Days_Request::isAjax()) {
                if (is_null($actionResult))
                    $actionResult = array();
                $content = $actionResult;
            }
            // render content
            else {
                $controllerObj->setLayout($controller, false);
                $content = call_user_func(array($controllerObj, 'getContent'));
                Days_Response::addHeader($ext);
            }
            Days_Event::run('controller.end');
            // set data to response
            Days_Response::addContent($content);
        }
        catch (Exception $oEx) {
            // save error message about this query
            Days_Log::add($oEx->getMessage());
            // page not found
            Days_Response::addHeader(Days_Response::NOT_FOUND);
        }
        // save runtime errors
        for ($iObLevel=ob_get_level(); $iObLevel>0; $iObLevel--) {
            $sError = ob_get_contents();
            if (''!=$sError)
                Days_Log::add("This data printed in scripts: '{$sError}'");
            // close output handler
            ob_end_clean();
        }
        // save errors
        Days_Log::save();
        Days_Event::run('engine.end');
        // send headers to user
        Days_Event::run('response.send.headers');
        Days_Response::sendHeaders();
        // send content to user
        Days_Event::run('response.send.content');
        Days_Response::sendContent();
    }
}