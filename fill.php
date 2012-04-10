<?php
/**
 * Script to send random data to a graphite server, usefull for testing new
 * graphite installs and getting your config in shape.
 *
 * @author Stuart Grimshaw <stuart@localphone.com>
 * @version $Id$
 * @copyright Stuart Grimshaw <stuart@localphone.com>, 08 April, 2012
 * @package default
 */

require_once 'src/GraphiteFiller/Connection.php';

use GraphiteFiller\Connection;

$date = strtotime('-1 day');
$time = '00:00:00';
$interval = 1;
$max = 10;
$stat = "test.stat";
$port = 2003;
$host = "localhost";

// Check the parameters passes to the script.
if(count($argv <= 1)) {
    // print options.
}

$arrOpts = getopt("dtimhps", array('date:', 'time:', 'interval:', 'max:', 'host:', 'port:', 'stat:'));

if(isset( $arrOpts['date'] ) && $arrOpts[ 'date' ]) {
    $date = strtotime($arrOpts['date']);
}

if(isset($arrOpts['time']) && $arrOpts[ 'time' ]) {
    $time = $arrOpts[ 'time' ];
}

if(isset($arrOpts['interval']) && $arrOpts[ 'interval' ]) {
    $interval = $arrOpts[ 'interval' ];
}

if(isset($arrOpts['max']) && $arrOpts[ 'max' ]) {
    $max = $arrOpts[ 'max' ];
}

if(isset($arrOpts['stat']) && $arrOpts[ 'stat' ]) {
    $stat = $arrOpts[ 'stat' ];
    print "Stat = " . $stat . "\n";
}

if(isset($arrOpts['host']) && $arrOpts[ 'host' ]) {
    $host = $arrOpts[ 'host' ];
}

if(isset($arrOpts['port']) && $arrOpts[ 'port' ]) {
    $port = $arrOpts[ 'port' ];
}

// work out the start date.
$statDate = $date + strtotime("Januray 1 1970 $time");

print "Start date is " . date("Y-m-d h:m:s", $statDate) . "\n";
print "Stat is " . $stat . "\n";

$conn = new Connection($host, $port);
$conn->connect();

while($statDate < time()) {
    $value = rand(0, $max);
    $conn->send($stat, $value, $statDate);

    $statDate += $interval;
}

?>
