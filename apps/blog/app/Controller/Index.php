<?php
/**
 * Index controller - handle queries in site root (http://phpdays.dev/).
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
class Controller_Index extends Days_Controller {
    /**
     * Call before all controller actions.
     */
    public function init() {
        $this->_view->set('title', 'My site based on php:Days framework');
    }

    /**
     * Index action.
     *
     * Call if typed path:
     *   http://phpdays.dev/
     *   http://phpdays.dev/index
     *   http://phpdays.dev/index/index
     */
    public function indexAction() {
        $blog = Days_Model::factory('table_blog');
        //$categories = Days_Model::factory('table_blog_category');
        $this->_view->set('blog_items', $blog->find('last', array('count'=>12)));
        //$this->_view->set('categories', $categories->find('all'));
    }
}
