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

$status = getStatus();
$report = createReport($status);
printReport($report);
createWikiPage($report);

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
	return array( 'docs' => $docs,
	    'languages' => $languages,
	    'topRevisions' => $topRevisions);
}
/**
 * Prepare the report table.
 */
function createReport($status) {
    global $statusDesc;
    $languages = $status['languages'];
    $topRevisions = $status['topRevisions'];
    $docs = $status['docs'];
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
    return $reportTable;
}
/**
 * Print the report on the screen.
 */
function printReport($reportTable) {
    // Calculate column widths.
    $columnWidths = array();
    for ($i = 0, $size = sizeof($reportTable[0]);
        $i < $size; ++$i) {
        $columnWidths[$i] = getMaxColumnWidth($i, $reportTable);
    }
    // Create a format string.
    $formatStr = '';
    foreach ($columnWidths as $width) {
        $formatStr .= ' %-' . $width . 's |';
    }
    $formatStr .= "\n";
    // Line separator.
    $lineWidth = 0;
    foreach ($columnWidths as $width) {
        $lineWidth += $width + 3; // ' ' + ' ' + '|'
    }
    $lineSeparator = sprintf('%\'-' . $lineWidth . "s\n", '-');
    // Print the table header.
    vprintf($formatStr, $reportTable[0]);
    echo $lineSeparator;
    for ($i = 1, $size = sizeof($reportTable); $i < $size; ++$i) {
        vprintf($formatStr, $reportTable[$i]);
    }
    echo $lineSeparator;
    echo printLegend() ."\n";
}
/**
 * Create the documentation status wiki page.
 */
function createWikiPage($reportTable) {
    $file = 'documentationStatus.wiki';
    $table[] = '#summary Documentation status. ' . date('d.m.Y') . "\n";
    $table[] = getWikiHeader() . "\n";
    // Print the table header in bold.
    $line = '|| ';
    foreach ($reportTable[0] as $item) {
        $line .= '*' . $item . '* || ';
    }
    $table[] = $line . "\n";
    for ($i = 1, $size = sizeof($reportTable); $i < $size; ++$i) {
        $line = '|| ';
        foreach ($reportTable[$i] as $item) {
            $line .= $item . ' || ';
        }
        $table[] = $line . "\n";
    }
    $table[] = getWikiLegend();
    file_put_contents($file, $table);
}
function getMaxColumnWidth($col, $arr) {
    $max = 0;
    for ($i = 0, $size = sizeof($arr); $i < $size; ++$i) {
        $length = strlen($arr[$i][$col]);
        if ($max < $length) {
            $max = $length;
        }
    }
    return $max;
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
function getWikiLegend() {
    global $statusDesc;
    $out = "\n";
    foreach ($statusDesc as $item) {
        $out .= '|| ' . $item['symbol']
            . ' || ' . $item['description'] . " ||\n";
    }
    return $out;
}
?>