<?php
/**
 * Show variable or set specified value.
 *
 * Parameters:
 *  - var: variable name
 *  - value: new variable value (optional)
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
class Templum_Component_Function_Var extends Templum_Component_Function_Abstract {
    protected $_required = array('var');

    protected function _handle(array $params=array()) {
        // set value to variable
        if (isset($params['value']))
            return "<?php {$params['var']}={$params['value']}; ?>";
        // print value
        else
            return "<?php if (isset ({$params['var']})) echo {$params['var']}; ?>";
    }
}