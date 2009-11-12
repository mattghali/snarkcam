<?php
$baseurl  = 'http://cam.example.com';
$apptitle = 'apptitle';

$cookiedom  = 'cam.example.com';
$cookiename = 'cookiename';
$cookiepass = 'cookiepass';

$cams[] = array('name' => 'camera 0',
                'jpeg' => 'http://cam.example.com/img0/snapshot.cgi',
                'mjpg' => 'http://cam.example.com/img0/video.mjpeg',
                'rtsp' => 'rtsp://webcam0.example.com/img/video.sav',
                'mpeg' => 'http://cam.example.com:8080/',
                'ptz'  =>  false
);

$cams[] = array('name' => 'camera 1',
                'jpeg' => 'http://cam.example.com/img1/snapshot.cgi',
                'mjpg' => 'http://cam.example.com/img1/video.mjpeg',
                'rtsp' => 'rtsp://webcam1.example.com/img/video.sav',
                'mpeg' => 'http://cam.example.com:8081/',
                'ptz'  => 'http://webcam1.example.com/pt/ptctrl.cgi'
);

?>
