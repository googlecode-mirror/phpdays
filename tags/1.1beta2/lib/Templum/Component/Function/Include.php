<?php
/**
 * Templum - php template engine.
 *
 * Parameters:
 *  - file: file name
 *  - var: variable name to set template (optional)
 *  - ...: variables to pass in template (optional)
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
class Templum_Component_Function_Include extends Templum_Component_Function_Abstract {
    protected $_required = array('file');

    protected function _handle(array $params=array()) {
        // get template file name
        $templateName = $params['file'];
        unset ($params['file']);
        // create template
        $template = new Templum();
        $content = $template->get($templateName, $params);
        // set template to variable
        if (isset($params['var'])) {
            $content = addslashes($content);
            return "<?php {$params['var']}='{$content}'; ?>";
        }
        // print template
        else
            return $content;
    }
}