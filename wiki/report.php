<?php
/**
 * This script prints documentation status information and 
 * creates a wiki status page.
 * To share this information, please checkin the wiki page
 *  into the svn repository.
 * 
 */
define("OLD_REVISION", -4);
define("MISSING_FILE", -3);
define("FILE_ERROR", -2);
define("MISSING_REVISION", -1);
define("OK", 0);
$statusDesc = array( 
    MISSING_FILE => array('symbol' => '-',
        'description' => 'missing file'),
    FILE_ERROR => array('symbol' => 'e',
        'description' => 'error reading file'),
    MISSING_REVISION => array('symbol' => '?',
        'description' => 'missing revision number'),
    OLD_REVISION => array('symbol' => '+',
        'description' => 'old revision'),
    OK => array('symbol' => ' ',
        'description' => 'OK')
    );

$docs = getStatus();
doReport($docs);

/**
 * Collect information about documentation files.
 * Returns an array of status information about each document.
 */
function getStatus() {
    $filePattern = '/^(?P<lang>[A-Z][A-Za-z])(?P<doc>.*)\.wiki$/';
    $revisionPattern = 
        '/<wiki:comment>\s*revision:\D*(?P<revision>\d+)\D*<\/wiki:comment>/i';

    $docs = array();
    $languages = array();
    $topRevisions = array();
	foreach (glob('*.wiki') as $filename) {
	    if (1 != preg_match($filePattern, "$filename", $matches)) {
	        continue;
	    }
	    $lang = $matches['lang'];
	    $doc = $matches['doc'];
	    $result;
	    $buf = file_get_contents($filename);
	    if ($buf == FALSE) {
	        $result = FILE_ERROR;
	    } else if (1 == preg_match($revisionPattern, $buf, $rev)) {
	        $result = $rev['revision'];
	    } else {
	        $result = MISSING_REVISION;
	    }
	    $languages[$lang] = $lang;
	    $docs[$doc][$lang] = $result;
	}
	// Get the top revision number for each document.
	foreach (array_keys($docs) as $doc) {
	    $topRevisions[$doc] = getTopRevision($docs[$doc]);
	}
	// Find missing files.
	foreach (array_keys($docs) as $doc) {
	    foreach ($languages as $lang) {
	        if (!isset($docs[$doc][$lang])) {
	            $docs[$doc][$lang] = MISSING_FILE;
	        }
	    }
	}
	createReportTable($docs, $languages, $topRevisions);
	return $docs;
}
/**
 * Prepare the report table.
 */
function createReportTable($docs, $languages, $topRevisions) {
    global $statusDesc;
    sort($languages);
    $names = array_keys($docs);
    sort($names);
    $reportTable = array();    
    // Create a table header.
    $reportTable[] = array_merge(array('Document', 'Top Rev.'),
        $languages);
    foreach ($names as $name) {
        $line = array();
        $line[] = empty($name) ? '_Root_' : $name;
        $revision = $topRevisions[$name];
        $line[] = $revision;
        foreach ($languages as $lang) {
            $status = $docs[$name][$lang];
            $out = '';
            if ($status < 0) {
                $out = $statusDesc[$status]['symbol'];
            } else if ($status == $revision) {
                $out = $statusDesc[OK]['symbol'];
            } else {
                $out = $statusDesc[OLD_REVISION]['symbol'];
            }
            $line[] = $out;
        }
        $reportTable[] = $line;
    }
    print_r($reportTable);
}
/** 
 * Get the maximum name length.
 */
function getMaxNameLength ($names) {
    $maxLength = 0;
    foreach ($names as $name) {
        $length = strlen($name);
        if ($maxLength < $length) {
            $maxLength = $length;
        }
    }
    return $maxLength;
}

/**
 * Get the top revision number.
 */
function getTopRevision($revisions) {
    $topRevision = -1;
    foreach ($revisions as $rev) {
        if ($rev > $topRevision) {
            $topRevision = $rev;
        }
    }
    return $topRevision;
}

function doReport($docs) {
    // Document names.
    $names = array_keys($docs);
    sort($names);
    // Languages.
    $languages = array_keys($docs[$names[0]]);
    sort($languages);
    // Top revisions.
    $topRevisions = array();
    foreach ($names as $name) {
        $topRevisions[$name] = getTopRevision($docs[$name]);
    } 

    // Formatting.
    $docHeader = 'Document';
    $topRevHeader = 'Top Rev.';
    $maxNameLength = getMaxNameLength($names);
    if ($maxNameLength < strlen($docHeader)) {
        $maxNameLength = strlen($docHeader);
    }
    $docLineFormat = '%-' . $maxNameLength . 's  |';
    $docLineFormat .= ' %' . strlen($topRevHeader) . 's |';
    $langTitleLine = sprintf($docLineFormat, $docHeader, $topRevHeader);

    foreach($languages as $lang) {
        $langTitleLine .= sprintf(' %2s  |', $lang);
        $docLineFormat .= '  %s  |';
    }
    $docLineFormat .= "\n";
    $lineSeparator = sprintf('%\'-' . strlen($langTitleLine) . 's', '-');
    
    echo $langTitleLine . "\n";
    echo $lineSeparator . "\n";

    $status[] = array_merge(array($docHeader, $topRevHeader), $languages);
    
    foreach($names as $name) {
        $out = array();
        $out[] = empty($name) ? '_Root_' : $name;
        $topRevision = $topRevisions[$name];
        $out[] = $topRevision == MISSING_REVISION ? '?' : $topRevision;
        $doc = $docs[$name];
        foreach ($languages as $lang) {
            switch ($doc[$lang]) {
                case MISSING_FILE: 
                    $out[] = '-';
                    break;
                case FILE_ERROR:
                    $out[] = 'e';
                    break;
                case MISSING_REVISION:
                    $out[] = '?';
                    break;
                default:
                if ($doc[$lang] == $topRevision) {
                    $out[] = ' ';
                } else {
                    $out[] = '+';
                }
            }
        }
        $status[] = $out;
        vprintf($docLineFormat, $out);
    }
    echo $lineSeparator . "\n";
    echo printLegend() ."\n";
    createWikiPage($status, $topRevisions);
}
function printLegend() {
    global $statusDesc;
    $out = '';
    foreach ($statusDesc as $item) {
        $out .= $item['symbol'] 
            . ' ' . $item['description'] 
            . "\n";
    }
    return $out;
}
function getWikiHeader() {
    $scriptName = basename(__FILE__);
    $out = <<<EndOfHeader
<wiki:comment>
DO NOT EDIT THIS FILE.
This file is generated by the $scriptName script. To update this
file run the script and commit the change to the wiki's svn repository.
</wiki:comment>
EndOfHeader;
    return $out;
}
function createWikiPage($status, $topRevisions) {
    $file = 'documentationStatus.wiki';
    $table[] = '#summary Documentation status. ' . date('d.m.Y') . "\n";
    $table[] = getWikiHeader() . "\n";
    // Print the table header in bold.
    $line = '|| ';
    foreach ($status[0] as $item) {
        $line .= '*' . $item . '* || ';
    }
    $table[] = $line . "\n";
    for ($i = 1, $size = sizeof($status); $i < $size; ++$i) {
        $line = '|| ';
        foreach ($status[$i] as $item) {
            $line .= $item . ' || ';
        }
        $table[] = $line . "\n";
    }
    $table[] = "\n";
    $footer = printLegend();
    $footer = preg_replace('/$/m', "\n\n", $footer);
    if (!is_null($footer)) {
        $table[] = $footer;
    }
    file_put_contents($file, $table);
}
?>