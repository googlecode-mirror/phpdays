<?php
/**
 * Templum - php template engine.
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
abstract class Templum_Component_Abstract {
    protected $_required = array();

    protected function _check(array $params, $key=null) {
        // get current class name
        $class = get_class($this);
        // check specified key
        if (! is_null($key)) {
            if (! isset($params[$key]))
                return false;
            return true;
        }
        // check all required keys
        else {
            foreach ($this->_required as $key)
                if (! isset($params[$key]))
                    throw new Templum_Exception("{$class}: not passed parameter `{$key}`");
        }
    }
}