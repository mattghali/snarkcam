#! /usr/bin/env python

import glob
import os
import signal
import sys
import time

interval = 600
sunrise = 06
sunset = 17
basedir  = '/data/record'
vlcbin = '/usr/bin/vlc'
vlcargs =  "vlc --quiet -I dummy --vlm-conf /etc/vlm-record.conf".split()

try:
    os.stat(basedir)
except OSError:
    sys.exit("Error: record dir %s doesn't exist" % basedir)

try:
    os.stat(vlcbin)
except OSError:
    sys.exit("Error: vlc binary %s doesn't exist" % vlcbin)

class NullDevice:
    def write(self, s):
        pass

class Time(object):
    def __init__(self):
        self.t = time.localtime()
        self.year = time.strftime('%Y', self.t)
        self.month = time.strftime('%B', self.t)
        self.day = time.strftime('%d', self.t)
        self.hour = time.strftime('%H', self.t)
        self.min = time.strftime('%M', self.t)
    def __repr__(self):
        return time.asctime(self.t)


if __name__ == '__main__':
    pid = os.fork()
    if pid:
        os._exit(0)
    
    os.chdir(basedir + '/tmp')
    os.setpgrp()
    sys.stdin.close()
    sys.stdout = NullDevice()
    sys.stderr = NullDevice()
    
    while True:
        t = Time()
    
        if int(t.hour) >= sunrise and int(t.hour) < sunset:
            pid = os.spawnv(os.P_NOWAIT, vlcbin, vlcargs)
            time.sleep(interval)
            os.kill(pid, signal.SIGTERM)
            os.waitpid(pid, 0)
            
            destdir = os.path.join(basedir, t.year, t.month, t.day, t.hour)
            try:
                os.stat(destdir)
            except OSError:
                os.makedirs(destdir)

            for file in glob.glob('*.mov'):
                os.rename(file,'%s/%s:%s-%s' % (destdir, t.hour, t.min, file))
    
        else:
            time.sleep(interval)
    
