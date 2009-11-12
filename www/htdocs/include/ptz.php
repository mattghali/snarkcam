<?php
# are we just serving the ptz control iframe?
if ( isset($_GET['ptzframe']) ) {
?>
<html>
    <head>
        <LINK REL=StyleSheet HREF="iframe.css">
    </head>
    <body>
        <table>
<?php
print "            <tr height=30>\n";
print "                <td width=30><a href=\"?cam=" . $cam . "&ptzmove=upleft\">&lceil;</a></td>\n";
print "                <td width=30><a href=\"?cam=" . $cam . "&ptzmove=up\">&uarr;</a></td>\n";
print "                <td width=30><a href=\"?cam=" . $cam . "&ptzmove=upright\">&rceil;</a></td>\n";
print "            </tr>\n";
print "            <tr height=30>\n";
print "                <td width=30><a href=\"?cam=" . $cam . "&ptzmove=left\">&larr;</a></td>\n";
print "                <td width=30><a href=\"?cam=" . $cam . "&ptzmove=home\">&diams;</a></td>\n";
print "                <td width=30><a href=\"?cam=" . $cam . "&ptzmove=right\">&rarr;</a></td>\n";
print "            </tr>\n";
print "            <tr height=30>\n";
print "                <td width=30><a href=\"?cam=" . $cam . "&ptzmove=downleft\">&lfloor;</a></td>\n";
print "                <td width=30><a href=\"?cam=" . $cam . "&ptzmove=down\">&darr;</a></td>\n";
print "                <td width=30><a href=\"?cam=" . $cam . "&ptzmove=downright\">&rfloor;</a></td>\n";
print "            </tr>\n";
?>
        </table>
    </body>
</html>
<?php
    exit(0);
}

# accept ptz motion commands
if ( isset($_GET['ptzmove']) ) {
    switch ($_GET['ptzmove']) {
        case "upleft":
            fopen($ptz . '?position=-48,36', 'r');
            break;
        case "up":
            fopen($ptz . '?mv=U,5', 'r');
            break;
        case "upright":
            fopen($ptz . '?position=48,36', 'r');
            break;
        case "left":
            fopen($ptz . '?mv=L,5', 'r');
            break;
        case "home":
            fopen($ptz . '?preset=move,103', 'r');
            break;
        case "right":
            fopen($ptz . '?mv=R,5', 'r');
            break;
        case "downleft":
            fopen($ptz . '?position=-48,-36', 'r');
            break;
        case "down":
            fopen($ptz . '?mv=D,5', 'r');
            break;
        case "downright":
            fopen($ptz . '?position=48,-36', 'r');
            break;
    }

    Header("Location: $baseurl/?cam=$cam&ptzframe");
    exit(0);
}
?>
