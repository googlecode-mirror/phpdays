#!/usr/bin/php
<?php
/**
 * Generate application in CLI (command line).
 *
 * PREPARE GENERATOR
 *  - open command line tool (linux: gnome-terminal, windows: C:\WINDOWS\system32\cmd.exe)
 *  - ONLY FOR LINUX: in terminal go to "phpdays/generator" dir and execute command "chmod 755 cli.php"
 *  - open "cli.php" and change path to php in first line (linux: /usr/bin/php, windows: C:\php\php.exe)
 *
 * GENERATE OR CHANGE PROJECT
 *  - go to you project root dir (linux: cd /path/to/project, windows: cd C:\path\to\project)
 *  - start generator: type path to current file (linux: /path/to/phpdays/generator/cli.php, windows: C:\path\to\phpdays\generator\cli.php)
 *  - type commands
 *
 * INSTRUCTION
 *  - go to site application directory in console
 *  - type path to project generator (/path/to/Generate.php)
 *  - press Enter
 *  - type available command
 *
 * COMMANDS
 *  - "help": show help
 *  - "project": work with project
 *    - "init": create empty project structure (set correct chmod for log and cache dirs)
 *    - "check": show warning messages for project files
 *    - "repair": check project and add not exist files
 *    - "clear": clear project (backup all files)
 *      - "cache": delete all cached templates
 *  - "page": work with pages in service
 *    - "add": create pages (config, content template, frame template, content controller)
 *    - "del": delete pages (move it to backup)
 *    - "rename": rename pages (backup file with old name)
 *    - "clear": clear pages (backup all files)
 *  - "block": work with blocks
 *    - "add": create blocks (config, block template, block controller)
 *    - "del": delete blocks (move it to backup)
 *    - "rename": rename blocks (backup file with old name)
 *    - "clear": clear blocks (backup all files)
 *  - "exit": exit
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysAcl
 * @package      Days
 * @subpackage   Tool
 * @author       Anton Danilchenko <happy@phpdays.org>
 * @version      1.1
 */

// include dependencies
include_once (realpath(dirname(__FILE__) . '/../lib/Days/Tool/AppGenerator.php'));

// start application
try {
    // create generator object
    $generator = Days_Tool_AppGenerator::singleton();
    // start screen (introduction)
    print "\tPHPDAYS APPLICATION GENERATOR\n";
    print "\n";
    print "Syntax: command [app_name|controller_name] parameter1 parameter2 parameter3\n";
    print "Example: add user: register login logout new\n";
    print "\n";
    print "Commands:\n";
    print " - NEW:     create new project\n";
    print " - ADD:     create new controller with actions (always create default action 'index')\n";
    print " - DEL:     delete actions in controller. Backup files save in directory 'backup'\n";
    print " - REPLACE: replace selected actions in controller to new empty actions. Backup files save in directory 'backup'\n";
    print " - CHECK:   check files structure (all files in project on relations) and show log\n";
    print "\n";
    print "Press Enter for exit (no input command name)\n";
    // handle user commands
    do {
        // read command
        print 'Command: ';
        // reads one line from STDIN
        $commandLine = trim(fgets(STDIN));
        // execute command
        if ('' != $commandLine) {
            // clear string
            $commandLine = str_replace(array(',',';',':','\\'), '', $commandLine);
            // parse string
            $aCommandLineParams = explode(' ', $commandLine);
            foreach ($aCommandLineParams as &$sParam){
                if($aCommandLineParams[0]=='new'){
                    if($aCommandLineParams[1]){
                        break;
                    }
                }
                $sParam = strtolower(trim($sParam));
            }
            // set correct params
            $command = array_shift($aCommandLineParams);
            $sController = array_shift($aCommandLineParams);
            // execute command
            switch ($command) {
                case 'new':
                    //create new project
                    $generator->createProject($sController);
                    echo "Project '{$sController}' succesfully created.\n";
                    break;
                case 'add':
                case 'create':
                    // create actions
                    if($generator->add($sController, $aCommandLineParams)) {
                        echo $sController." is added.\n";
                    } else {
                        echo "Fail!".$sController." is not added.\n";
                    };
                    break;
                case 'del':
                case 'delete':
                case 'rm':
                case 'rem':
                case 'remove':
                    // backup actions
                    // remove actions
                    $generator->del($sController, $aCommandLineParams);
                    // remove controller dir (if empty)
                    break;
                case 'up':
                case 'update':
                case 'replace':
                    // backup data
                    // create empty actions
                    $generator->add($sController, $aCommandLineParams, true);
                    break;
                case 'check':
                    break;
                default:
                    print "Command not supported!\n";
            }
        }
    } while('' != $commandLine);
}
catch (Exception $ex) {
    print $ex->getMessage();
    print "\n";
}
print "Generator has completed\n";