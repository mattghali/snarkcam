<?php
# default to cam 0
if ( isset($_GET['cam']) && isset($cams[$_GET['cam']])) {
   $cam = $_GET['cam'];
} else {
   $cam = 0;
}

# shorter variable names from the config array.
$name = $cams[$cam]['name'];
$ptz  = $cams[$cam]['ptz'];
$pvt  = $cams[$cam]['pvt'];

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

?>
