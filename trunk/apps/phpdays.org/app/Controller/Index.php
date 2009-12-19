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
    /** Call before all controller actions */
    public function init() {
        $this->_view->set('title', 'phpDays - php community');
    }

    /** Index action */
    public function indexAction() {
        // find blog posts
        $blogPosts = new Model_BlogPost();
        $blogPosts->limit(10)->sort('date DESC');
        // work with environment
        // get values
        $userName   = $this->post('name') OR 'noname';
        $sessEmail  = $this->session('email') OR '';
        $urlAddress = $this->url('address') OR '';
        // set value
        $this->post('name', 'Anton');
        $this->session('email', 'test@mail.com');
        // send message to developer (in firebug or in log file)
        $this->log('All right. All work well!');
        // add event handler (need create method for handle this event)
//        $this->event('user/logged', array($this, '_onUserLogin'));
        // set data to template
        $this->posts = $blogPosts;
    }
}
