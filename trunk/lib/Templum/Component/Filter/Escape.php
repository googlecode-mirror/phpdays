<?php
/**
 * Escape string - delete all quote symbols.
 *
 * Parameters:
 *  - value: default value
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
class Templum_Component_Filter_Escape extends Templum_Component_Filter_Abstract {
    protected $_required = array('value');

    protected function _handle(array $params=array(), $content) {
        // escape string
        $content = htmlspecialchars($params['value'], ENT_QUOTES);
        // schow result
        return "<?php echo '{$content}'; ?>";
    }
}