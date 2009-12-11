<?php
/**
 * Generate new application and modify existing application.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysAcl
 * @package      Days
 * @subpackage   Tool
 * @author       Anton Danilchenko <happy@phpdays.org>
 * @version      1.1
 */
class Days_Tool_AppGenerator {
    /**
     * Link to itself object.
     *
     * @var Phpdays_Tools_Generator
     */
    private static $_oInstatce = null;
    /**
     * Project directory.
     *
     * @var string
     */
    private $_sProjectDir = '';
    public $sMessage = '';

    /**
     * Create current class object (create once).
     *
     * @return Phpdays
     */
    public static function singleton() {
        // create itself only once
        if (is_null(self::$_oInstatce)) {
            $sClassName = __CLASS__;
            self::$_oInstatce = new $sClassName();
        }
        // return link to itself object
        return self::$_oInstatce;
    }

    /**
     * Create new controller with actions.
     *
     * Always create action "index".
     *
     * @param $sController string: Controller name
     * @param $aActions array: Action names
     * @param $bReplace bool: Replace action file if exists
     * @return
     */
    public function add($sController, array $aActions=array(), $bReplace=false) {
        list($sType,$sControllerName)=explode('/',$sController);
        switch ($sType) {
            case 'site':
                $sApplicationPath=$this->_sProjectDir."";
                if (! is_dir($sApplicationPath))
                    if (! mkdir($sApplicationPath,0755))
                        throw new Exception("Directory '{$sApplicationPath}' not created");
                $sPublicPath=$this->_sProjectDir."/public";
                if (! is_dir($sPublicPath))
                    if (! mkdir($sPublicPath))
                        throw new Exception("Directory '{$sPublicPath}' not created");
                $sSitePath=dirname(__FILE__).'/site';
                $this->_copyDir($sSitePath,$sApplicationPath);
                $sIndexFileData=file_get_contents($sPublicPath.'/index.php');
                $fp=fopen($sPublicPath.'/index.php','w');
                if($fp) {
                    $sIndexFileData=str_replace('%CoreDir%',realpath(dirname(__FILE__).'/../../../').'/',$sIndexFileData);
                    fwrite($fp,$sIndexFileData);
                    fclose($fp);
                }
                return true;
                break;

            case 'content':
            case 'block':
            case 'form':
                $sTControllerPath=dirname(__FILE__).'/site/application/'.$sType.'/'.$sType;
                $sTAction=$sType;
                if( ($sType=='content') ) {
                    $sTControllerPath=dirname(__FILE__).'/site/application/'.$sType.'/index';
                    $sTAction='index';
                    // set default path
                    if( (empty($aActions) || ! in_array('index', $aActions) ) ) {
                        $aActions[] = 'index';
                    }
                }
                // set correct path
                $sControllerPath = "{$this->_sProjectDir}/application/{$sController}";
                // create service directory
                if (! is_dir($sControllerPath))
                    if (! mkdir($sControllerPath))
                        throw new Exception("Directory '{$sControllerPath}' not created");
                $this->_copyDir($sTControllerPath,$sControllerPath);
                // create all action files
                foreach ($aActions as $sAction) {
                    $this->addAction($sTControllerPath,$sTAction,$sControllerPath, $sAction, $bReplace);
                }
                $this->add('frame/'.$sControllerName, array(), $bReplace);
                return true;
                break;

            case 'frame':
                $sTFramePath=dirname(__FILE__).'/site/application/'.$sType;
                $sTAction='index';

                $sFramePath = "{$this->_sProjectDir}/application/{$sType}";
                $this->addAction($sTFramePath,$sTAction,$sFramePath, $sControllerName, $bReplace);

                echo "Frame {$sControllerName} is added\n";
                return true;
                break;
        }
    }

    /**
     * Create new action.
     *
     * @param $sTControllerPath
     * @param $sTAction
     * @param $sControllerPath
     * @param $sAction
     * @param $bReplace
     * @return bool
     */
    public function addAction($sTControllerPath, $sTAction, $sControllerPath, $sAction='index', $bReplace=false) {
        // set default action
        if(empty($sAction))
            $sAction='index';
        // set path
        $sTActionPath = "{$sTControllerPath}/{$sTAction}.php";
        $sActionPath = "{$sControllerPath}/{$sAction}.php";
        if (file_exists($sActionPath)) {
            // back up file
        }
        else {
            // create action file
            if(@copy($sTActionPath,$sActionPath)) {
                echo "Action {$sActionPath} is added\n";
            } else {
                echo "Fail! Action {$sActionPath} is not added\n";
            }
        }
        $sTActionTemplPath = "{$sTControllerPath}/{$sTAction}.html";
        $sActionTemplPath = "{$sControllerPath}/{$sAction}.html";
        if (file_exists($sActionTemplPath)) {
            // back up file
        }
        else {
            // create template file
            if (@copy($sTActionTemplPath,$sActionTemplPath)) {
                echo "Action template {$sActionTemplPath} is added\n";
            } else {
                echo "Fail! Action template {$sActionTemplPath} is not added\n";
            }
        }
        $sTActionTemplConfigPath = "{$sTControllerPath}/{$sTAction}.html.conf";
        $sActionTemplConfigPath = "{$sControllerPath}/{$sAction}.html.conf";
        // check file on disk
        if (file_exists($sActionTemplConfigPath)) {
            // back up file
        }
        else {
            // craete config file for action
            if(@copy($sTActionTemplConfigPath, $sActionTemplConfigPath)) {
                echo "Actions config {$sActionTemplConfigPath} is added\n";
            } else {
                echo "Fail! Actions config {$sActionTemplConfigPath} is not added\n";
            }
        }
    }

    protected function _copyDir($sDirOut,$sDirIn) {
        if(! is_dir($sDirIn)){
            if (!@mkdir($sDirIn,0755)) {
                return false;
            }
        }
        if(! is_dir($sDirOut) || ! is_dir($sDirIn)) {
            return false;
        }
        if ($dir=opendir($sDirOut)){
            while ($filename=readdir($dir)){
                if (($filename==".")||($filename=="..")){
                        continue;
                }
                if (is_dir($sDirOut.'/'.$filename)){
                        $this->_copyDir($sDirOut.'/'.$filename,$sDirIn.'/'.$filename);
                } else {
                        copy($sDirOut.'/'.$filename,$sDirIn.'/'.$filename);
                }
            }
            closedir($dir);
        }
    }


    /**
     * Set path to current project directory.
     *
     * @return Phpdays_Tools_Generator
     */
    private function __construct() {
        // check project directory
        $this->_sProjectDir = rtrim(getcwd(), '/');
        if (! is_writable($this->_sProjectDir))
            throw new Exception("Current directory '{$this->_sProjectDir}' not writable");
    }
}