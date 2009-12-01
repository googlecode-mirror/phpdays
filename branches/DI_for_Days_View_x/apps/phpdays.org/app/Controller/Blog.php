<?php
/**
 * Blog controller - show blog posts.
 *
 * Use "php:Days - php5 framework" (http://phpdays.googlecode.com).
 *
 * @copyright   Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        http://phpdays.googlecode.com/
 * @package     phpDays
 * @subpackage  application
 * @author      Anton Danilchenko <happy@phpdays.org>
 */
class Controller_Blog extends Days_Controller {
    /** Call before all controller actions */
    public function init() {
        $this->_view->set('title', 'phpDays - php community');
        $this->setLayout('index');
    }

    /** Index action */
    public function indexAction() {
    }
}