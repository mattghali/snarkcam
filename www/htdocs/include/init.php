<?php
# default to cam 0
if ( isset($_GET['cam']) && isset($cams[$_GET['cam']])) {
   $cam = $_GET['cam'];
} else {
   $cam = 0;
}

# shorter variable names from the config array.
$name = $cams[$cam]['name'];
$rtsp = $cams[$cam]['rtsp'];
$mpeg = $cams[$cam]['mpeg'];
$ptz  = $cams[$cam]['ptz'];

# define 'previous' cam if exists
if ( isset($cams[$cam - 1]) ) {
    $prev = $cam - 1;
}

# define 'next' cam if exists
if ( isset($cams[$cam + 1]) ) {
    $next = $cam + 1;
}

# are we on an iphone or ipod touch?
if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')) {
    $cams[$cam]['jpeg'] .= '?size=2';
    $imgsize = 'width=320 height=240';
} else {
    $cams[$cam]['jpeg'] .= '?size=3';
    $imgsize = 'width=640 height=480';
}

# default to 'pause' mode
if ( isset($_GET['mode']) ) {
   $mode = $_GET['mode'];
} else {
   $mode = 'pause';
}

# if mode is 'play', return mjpeg
if ( $mode == 'play' ) {
   $image = $cams[$cam]['mjpg'];
} else {
   $image = $cams[$cam]['jpeg'];
}

# set cookie to enable options
if ( isset($_GET['setcookie']) ) {
    if ( $_GET['setcookie'] == $cookiepass ) {
        setcookie($cookiename, $cookiepass, time()+31104000, '/', $cookiedom);
        # force page to reload with cookie
        header("Location: $baseurl/?cam=$cam&mode=$mode");
        exit(0);
    }
}

# check for cookie
if ( isset($_COOKIE[$cookiename])  && ($_COOKIE[$cookiename] == $cookiepass)) {
    $authed = true;
} else {
    $authed = false;
}

if ($authed) {
    # check if vlc proxy is running
    exec('pgrep -f vlm' . $cam, $out, $ret);
    if ($ret) {
        $vlcstatus = 'off';
    } else {
        $vlcstatus = 'on';
    }

    # toggle vlc proxy state - this prevents more than one per cam from being run
    if ( isset($_GET['vlc']) ) {
        if ( $vlcstatus == 'off' ) {
            exec('/usr/bin/vlc -I dummy --vlm-conf /etc/vlm' . $cam . '.conf > /dev/null 2>&1 &');
        } else {
            exec('pkill -f vlm' . $cam . '.conf');
        }
        # leaving vlc get arg in address bar url gets messy.
        header("Location: $baseurl/?cam=$cam&mode=$mode");
        exit(0);
    }
}
?>
