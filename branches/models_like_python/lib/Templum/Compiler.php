<?php
/**
 * Templum - php template engine.
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
class Templum_Compiler {
    /** Handlers objects */
    private static $_handlers = array();

    /**
     * Parse content and return result.
     *
     * @param string $content Original content
     * @return string Parsed content
     */
    protected static function _parce($content) {
        // check content to php tags
        if (preg_match('`<\?php`', $content))
            throw new Templum_Exception('Remove all php tags from template');
        // replace blocks: {block_name param=$value} ... {/block_name}
        $content = preg_replace_callback('`\{([^\n ]+)( [^\n]+)?\}(.*)\{/\1\}`Us', array(__CLASS__, '_parceBlock'), $content);
        // replace all instructions: {$value}, {function_name param=$value}
        return preg_replace_callback('`\{([^\n ]+)(| [^\n]*)\}`Us', array(__CLASS__, '_parceFunction'), $content);
    }

    /**
     * Parse block and return result.
     *
     * @param string $block Block information
     * @return string Parsed block content
     */
    protected static function _parceBlock($block) {
        // set values
        $name = ucfirst($block[1]);
        $params = self::_parceParams($block[2]);
        $content = $block[3];
        // handle block and return result
        return self::_handle("Block_{$name}", $params, $content);
    }

    /**
     * Parse function and return result.
     *
     * @param string $function Function information
     * @return string Parsed function content
     */
    protected static function _parceFunction($function) {
        // without parameters
        if (! isset ($function[2]))
            $function[2] = '';
        // if specified variable as funtion name
        if ('$'==$function[1][0]) {
            $function[2] .= " var={$function[1]}";
            $function[1] = 'var';
        }
        // set values
        $name = ucfirst($function[1]);
        $params = (empty($function[2]) ? array() : self::_parceParams($function[2]));
        // handle function and return result
        return self::_handle("Function_{$name}", $params);
    }

    /**
     * Parse parameters from string to array.
     *
     * @param string $params Parameters as line
     * @return string Parameters as array
     */
    protected static function _parceParams($params) {
        $paramLines = preg_split(
            '`' .
            '[\s]*([a-z0-9_]+="[^"]*")[\s]*|' .
            "[\s]*([a-z0-9_]+='[^']*')[\s]*|" .
            "[\s]*([a-z0-9_]+=[^ ]+)[\s]*" .
            '`',
            $params, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        // set name and value in array
        $params = array();
        foreach ($paramLines as $paramLine) {
            // check correct parsing
            if (! preg_match('`^([a-z0-9_]+) *= *(.+)$`', $paramLine, $paramInfo))
                throw new Templum_Exception("Incorrect parameter definition `{$paramLine}`");
            // set parameter
            $key = $paramInfo[1];
            $value = $paramInfo[2];
            $params[$key] = $value;
        }
        // return parameter pairs
        return $params;
    }

    /**
     * Execute instruction and return result.
     *
     * @param string $instruction Instruction name
     * @param array $params Parameters for instruction
     * @return string Parsed instruction content
     */
    protected static function _handle($instruction, array $params, $content='') {
        // create handler
        if (! isset (self::$_handlers[$instruction])) {
            $class = "Component_{$instruction}";
            self::$_handlers[$instruction] = Templum::factory($class);;
        }
        // handle instruction and return result
        return self::$_handlers[$instruction]->handle($params, $content);
    }

    public function get($template, array $vars=array()) {
        // renew compiled template
        if (! self::_isCompiled($template)) {
            $path = Templum::getTemplateDir() . $template;
            if (! file_exists($path))
                throw new Templum_Exception("file `{$path}` not found");
            $content = file_get_contents($path);
            try {
                // load and parce template
                $templateData = self::_parce($content);
            }
            catch (Exception $ex) {
                throw new Templum_Exception($ex->getMessage() . " file: `{$path}`");
            }
            // save changed template data to cache
            self::_setCompile($template, $templateData);
        }
        // return executed template
        return self::_getCompile($template, $vars);
    }

    /** Clear all compiled templates */
    public static function clearCompiled() {
        self::_rmDir(Templum::getCompileDir(), true, false);
    }

    /**
     * Check if compiled file is actual.
     *
     * @param string $templateName Template file name
     * @return bool
     */
    private static function _isCompiled($templateName) {
        // full path to template and cache files
        $compilePath  = Templum::getCompileDir()  . $templateName;
        $templatePath = Templum::getTemplateDir() . $templateName;
        // cache newest
        if (file_exists($templatePath) AND file_exists($compilePath) AND filemtime($templatePath) <= filemtime($compilePath))
            return true;
        // cache expired or not exists
        return false;
    }

    /**
     * Return executed template.
     *
     * @param string $templateName Template file name
     * @return string
     */
    private function _getCompile($templateName, array $vars=array()) {
        // full path to template
        $sCompilePath = Templum::getCompileDir() . $templateName;
        // check template in cache
        if(! self::_isCompiled($templateName))
            throw new Templum_Exception("Compiled template file `{$sCompilePath}` not found");
        // insert variables to view in template
        extract($vars);
        // collect printed data in buffer
        ob_start();
        // execute cache
        include ($sCompilePath);
        // save collected data in variable
        $sProcessedTemplate = ob_get_contents();
        // stop collect data
        ob_end_clean();
        // return executed template
        return $sProcessedTemplate;
    }

    /**
     * Save compiled template in file.
     *
     * @param string $templateName Path to template file (start from template dir)
     * @param string $sData Saved data to cache
     * @return bool
     */
    private static function _setCompile($templateName, $sData) {
        // full path to template
        $sCompilePath  = Templum::getCompileDir()  . $templateName;
        $sTemplatePath = Templum::getTemplateDir() . $templateName;
        // create directory hierarhy
        $sDirs = dirname($sCompilePath);
        if (! is_dir($sDirs))
            mkdir($sDirs, 0755, true);
        // save cache
        $oFile = file_put_contents($sCompilePath, $sData);
        // set cache modification time
        $iDate = filemtime($sTemplatePath);
        touch($sCompilePath, $iDate);
    }

    /**
     * Delete selected directory with all content in this directory.
     *
     * @param string $path: Full path to directory
     * @param bool $recursive: Delete if dir not empty
     * @param bool $deleteSourceDir: Delete current directory or all content
     */
    private static function _rmDir($path, $recursive=false, $deleteSourceDir=true) {
        // not delete all files from root directory
        if (''==$path OR '/'==$path OR ! is_dir($path))
            return;
        $path = rtrim($path, '/') . '/';
        $oHandle = opendir($path);
        while (false !== ($sFile = readdir($oHandle))) {
            if($sFile == "." OR $sFile == ".." OR '.'==$sFile[0])
                continue;
            // set fullpath to file
            $sFullpath = $path . $sFile;
            if (is_dir($sFullpath))
                self::_rmDir($sFullpath, $recursive, true);
            else
                unlink($sFullpath);
        }
        // close current dir
        closedir($oHandle);
        // delete current dir
        if ($deleteSourceDir)
            rmdir($path);
    }
}