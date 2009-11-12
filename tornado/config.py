import webcam

apptitle = 'apptitle'

cookiedom = 'cam.example.com'
cookiename = 'cookiename'
cookiepass = 'cookiepass'

port = 8888
baseurl = 'http://' + cookiedom

cams = []

cam0 = webcam.webcam()
cam0.name = 'camera 0'
cam0.jpeg = baseurl + '/img0/snapshot.cgi'
cam0.mjpg = baseurl + '/img0/video.mjpeg'
cam0.rtsp = 'rtsp://webcam0.example.com/img/video.sav'
cam0.mpeg = 'http://cam.example.com:8080/'
cam0.ptz  = False
cams.append(cam0)

cam1 = webcam.webcam()
cam1.name = 'camera 1'
cam1.jpeg = baseurl + '/img1/snapshot.cgi'
cam1.mjpg = baseurl + '/img1/video.mjpeg'
cam1.rtsp = 'rtsp://webcam1.example.com/img/video.sav'
cam1.mpeg = 'http://cam.example.com:8081/'
cam1.ptz  = 'http://webcam1.example.com/pt/ptctrl.cgi'
cams.append(cam1)

