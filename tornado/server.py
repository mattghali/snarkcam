import tornado.httpserver
import tornado.ioloop
import tornado.web

import config

class MainHandler(tornado.web.RequestHandler):
    def get(self):
        args = {}

        args['mode'] = self.get_argument('mode', default='pause')
        args['cam'] = int(self.get_argument('cam', default=0))
        cam = args['cam']

        if cam + 1 < len(config.cams):
            args['next_idx'] = cam + 1
            args['next_cam'] = config.cams[cam + 1]
        else:
            args['next_idx'] = 0
            args['next_cam'] = config.cams[0]

        if cam - 1 >= 0:
            args['prev_idx'] = cam - 1
            args['prev_cam'] = config.cams[cam - 1]
        else:
            args['prev_idx'] = len(config.cams) -1
            args['prev_cam'] = config.cams[len(config.cams) -1]

        if 'iPhone' in self.request.headers['User-Agent']:
            sizearg = '?size=2'
            args['imgsize'] = 'width=320 height=240'
        else:
            sizearg = '?size=3'
            args['imgsize'] = 'width=640 height=480'

        if args['mode'] == 'play':
            args['active_url'] = config.cams[cam].mjpg
            args['alt_url'] = "%s:%i/?mode=pause&cam=%i" % (config.baseurl, config.port, cam)
            args['alt_txt'] = "pause video"
        else:
            args['active_url'] = config.cams[cam].jpeg + sizearg
            args['alt_url'] = "%s:%i/?mode=play&cam=%i" % (config.baseurl, config.port, cam)
            args['alt_txt'] = "play video"

        if self.get_argument('ptzframe', default=False):
            self.render("ptz_template.html", cam=config.cams[cam], config=config, args=args)
        else:
            self.render("main_template.html", cam=config.cams[cam], config=config, args=args)

class NullHandler(tornado.web.RequestHandler):
    def get(self): pass
    def post(self): pass

application = tornado.web.Application([
    (r"/", MainHandler),
    (r"/favicon.ico", NullHandler),
])

if __name__ == "__main__":
    http_server = tornado.httpserver.HTTPServer(application)
    http_server.listen(config.port)
    tornado.ioloop.IOLoop.instance().start()
