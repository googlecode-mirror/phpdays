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
 * @subpackage  phpDays library
 * @author      Anton Danilchenko <happy@phpdays.org>
 */
class App_Controller_Blog extends Days_Controller {

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
        $this->_view->set('blog_items', $blog->find('last', array('count'=>12)));
    }


	/**
     * Item action.
     *
     * Call if typed path:
     *   http://phpdays.dev/blog/item/?item=1
     */
    public function itemAction() {
        $blog = Days_Model::factory('table_blog');
        $blog_row=$blog->find('one', array('where'=>'_blog_id='.(int)$_GET['item']));

        $this->_view->set('blog_item', $blog_row);
        $this->_view->set('title', $blog_row->title);
    }


	/**
     * Tag action.
     *
     * Call if typed path:
     *   http://phpdays.dev/blog/item/?item=1
     */
    public function tagAction() {
        $blog = Days_Model::factory('table_blog');
        $this->_view->set('blog_items', $blog->find('last', array('count'=>12)));
    }


	/**
     * Add action.
     *
     * Call if typed path:
     *   http://phpdays.dev/blog/add/
     */
    public function addAction() {

    }
}