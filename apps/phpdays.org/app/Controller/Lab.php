<?php
/**
 * Lab controller - bug tracker, wiki, code browser.
 *
 * Use "php:Days - php5 framework" (http://phpdays.googlecode.com).
 *
 * @copyright   Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        http://phpdays.googlecode.com/
 * @package     phpDays
 * @subpackage  phpDays library
 * @author      Anton Danilchenko <happy@phpdays.org>
 */
class Phpdays_Controller_Lab extends Days_Controller {
    /** Project name */
    protected $_projectName;
    /** Bug id */
    protected $_bugId;
    /** Task id */
    protected $_taskId;
    /** Path to folder or file */
    protected $_codePath;
    /** Wiki page name */
    protected $_wikiPage;

    /** Call before all controller actions */
    public function init() {
        $this->_view->set('title', 'phpDays projects');
        // set variables for current environment
        $this->_projectName = Days_Url::get('project', null);
        $this->_bugId       = Days_Url::get(1, null);
        $this->_taskId      = Days_Url::get(1, null);
        $this->_codePath    = Days_Url::get(1, null);
        $this->_wikiPage    = Days_Url::get(1, null);
    }

    /** Show all projects */
    public function indexAction() {
    }

    /** Show all bugs */
    public function bugAction() {
    }

    /** Show all tasks */
    public function taskAction() {
    }

    /** Show code browser */
    public function codeAction() {
    }

    /** Show all wiki pages */
    public function wikiAction() {
    }

    /** Show all project files */
    public function downloadAction() {
    }

    /** Add/edit specified bug */
    public function editBugAction() {
    }

    /** Add/edit specified task */
    public function editTaskAction() {
    }

    /** Add/edit specified wiki page */
    public function editWikiAction() {
    }
}