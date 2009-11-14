<?php
/**
 * Collect data to variable.
 *
 * Parameters:
 *  - var: name of variable
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
class Templum_Component_Block_Collect extends Templum_Component_Block_Abstract {
    protected $_required = array('var');

    protected function _handle(array $params=array(), $content) {
        // delete quotes
        $content = str_replace("'", "\'", $content);
        // return code
        return "<?php {$params['var']}='{$content}'; ?>";
    }
}