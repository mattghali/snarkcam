<?php
$baseurl  = 'http://cam.example.com';
$apptitle = 'apptitle';

$cookiedom  = 'cam.example.com';
$cookiename = 'cookiename';
$cookiepass = 'cookiepass';

# your google analytics ID
# $analyticsID = '12343277323';

$cams[] = array('name' => 'camera 0',
                'jpeg' => 'http://cam.example.com/img0/snapshot.cgi',
                'mjpg' => 'http://cam.example.com/img0/video.mjpeg',
                'ptz'  =>  false,
                'pvt'  =>  false
);

$cams[] = array('name' => 'camera 1',
                'jpeg' => 'http://cam.example.com/img1/snapshot.cgi',
                'mjpg' => 'http://cam.example.com/img1/video.mjpeg',
                'ptz'  => 'http://webcam1.example.com/pt/ptctrl.cgi',
                'pvt'  =>  true
);

?>
