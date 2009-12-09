<?php
/**
 * BlogCategory controller - show blog posts.
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
class Controller_Block_Category extends Days_Controller {

    /**
     * Call before all controller actions.
     */
    public function init() {
        $blog = Days_Model::factory('table_blog_category');
        $this->_view->set('categorys', $blog->find('all'));
        $this->_view->set('title', 'Category');
    }
}