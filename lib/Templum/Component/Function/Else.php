<?php
/**
 * Templum - php template engine.
 *
 * Parameters:
 *  - (no parameters)
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
class Templum_Component_Function_Else extends Templum_Component_Function_Abstract {
    protected $_required = array();

    protected function _handle(array $params=array()) {
        return "<?php } else { ?>";
    }
}