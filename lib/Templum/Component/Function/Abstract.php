<?php
/**
 * Templum - php template engine.
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
abstract class Templum_Component_Function_Abstract extends Templum_Component_Abstract {
    abstract protected function _handle(array $params=array());

    final public function handle(array $params=array()) {
        // check variables
        $this->_check($params);
        // call hendle function
        return $this->_handle($params);
    }
}