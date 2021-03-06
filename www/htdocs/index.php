<?php
include 'include/config.php';
include 'include/init.php';
include 'include/ptz.php';
include 'include/analytics.php';
?>
<html>
    <head>
<?php
print "        <title>$apptitle</title>\n";

# send Google Analytics script
print $analyticsScript;

# handle auto-cycle
if ( isset($_GET['cycle']) ) {
    $cycle = $_GET['cycle'];
    if ( isset($next) ) {
        print "        <META HTTP-EQUIV=\"Refresh\" CONTENT=\"$cycle;URL=$baseurl/?cam=$next&mode=$mode&cycle=$cycle\"\n";
    } else {
        print "        <META HTTP-EQUIV=\"Refresh\" CONTENT=\"$cycle;URL=$baseurl/?cam=0&mode=$mode&cycle=$cycle\"\n";
    }
}
?>
        <meta name="viewport" content="initial-scale=0.925" />
        <LINK REL=StyleSheet HREF="cam.css">
    </head>
    <body>
        <table>
            <tr>
<?php
# display 'prev' nav arrow if needed
if ( isset($prev) ) {
    $url = "?cam=$prev&mode=$mode";
    $prevname = $cams[$prev]['name'];
    print "                <td width=20 bgcolor=\"DarkGray\"><a href=\"$url\" title=\"$prevname\">&larr;</a></td>\n";
} else {
    print "                <td width=20>&nbsp;</td>\n";
}

# display camera name
print "                <td colspan=3>$name</td>\n";

# display 'next' nav arrow if needed
if ( isset($next) ) {
    $url = "?cam=$next&mode=$mode";
    $nextname = $cams[$next]['name'];
    print "                <td width=20 bgcolor=\"DarkGray\"><a href=\"$url\" title=\"$nextname\">&rarr;</a></td>\n";
} else {
    print "                <td width=20>&nbsp;</td>\n";
}

?>
            </tr>
            <tr>
<?php
# display jpeg/mjpeg
if ($pvt) {
    if ($authed) {
        print "                <td colspan=5><img src=\"$image\" $imgsize></td>\n";
    } else {
        print "                <td colspan=5 $imgsize bgcolor=black>\n";
        print "                    <font color=\"white\">disabled</font>\n";
        print "                </td>\n";
    }
} else {
    print "                <td colspan=5><img src=\"$image\" $imgsize></td>\n";
}
?>
            </tr>
            <tr>
                <td colspan=2></td>
                <td width=98 bgcolor="DarkGray">
<?php
# play/pause button
if ( $mode == 'play' ) {
    print "                    <a href=\"?cam=$cam\" title=\"display still jpeg\">pause</a>\n";
} else {
    print "                    <a href=\"?cam=$cam&mode=play\" title=\"play motion jpeg\">play</a>\n";
}
?>
                </td>
                <td colspan=2></td>
            </tr>
<?php
# options line
if ($authed) {
    print "            <tr height=20>\n";
    print "                <td colspan=5>\n";
    print "                    <p>\n";
    print "                        cycle: \n";
    print "                        <a href=\"?cam=$cam&mode=$mode\" title=\"stop cycling\">off</a>\n";
    foreach ( array(15, 30, 60) as $i ) {
        print "                        <a href=\"?cam=$cam&mode=$mode&cycle=$i\" title=\"cycle through all cameras at a $i second interval\">$i</a>\n";
    }
    print "                    </p>\n";
    print "                </td>\n";
    print "            </tr>\n";
}

# debug output
if ( isset($_GET['debug']) ) {
    print "            <tr height=20>\n";
    print "                <td colspan=5>\n";
    print "                    <p>\n";
    print "                    $debug\n";
    print "                    </p>\n";
    print "                </td>\n";
    print "            </tr>\n";
}

# ptz directional controls
if ($ptz && $authed) {
    print "            <tr>\n";
    print "                <td colspan=5>\n";
    print "                        <iframe src=\"?cam=$cam&mode=$mode&ptzframe\" frameborder=no width=98 height=98>\n";
    print "                </td>\n";
    print "            </tr>\n";
}
?>
        </table>
    </body>
</html>
