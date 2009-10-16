<?php
/**
 * Truncate string.
 *
 * Parameters:
 *  - len: string length (optional)
 *  - suffix: add to end of string (optional)
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
class Templum_Component_Filter_Crop extends Templum_Component_Filter_Abstract {
    protected $_required = array();

    protected function _handle(array $params=array(), $content) {
        // check params
        $length = (isset($params['len'])) ? $params['len'] : 100;
        $suffix = (isset($params['suffix'])) ? $params['suffix'] : '...';
        // processing data
        $content = substr($content, 0, $length) . $suffix;
        $content = addslashes($content);
        // schow result
        return "<?php echo '{$content}'; ?>";
    }
}