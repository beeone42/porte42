#!/usr/bin/env python

import os, json, signal, sys, urllib, urllib2, time, subprocess, hashlib
from random import *

CONFIG_FILE = 'config.json'

"""
Open and load a file at the json format
"""

def open_and_load_config():
    if os.path.exists(CONFIG_FILE):
        with open(CONFIG_FILE, 'r') as config_file:
            return json.loads(config_file.read())
    else:
        print "File [%s] doesn't exist, aborting." % (CONFIG_FILE)
        sys.exit(1)

def signal_handler(signal, frame):
        print('You pressed Ctrl+C!')
        sys.exit(0)

def say(txt):
    hash = hashlib.md5(txt).hexdigest()
    fname = "cache/" + hash + ".mp3"
    if (os.path.isfile(fname) == False):
        urltts = config["tts"] + "?" + urllib.urlencode({'t':msg, 'l':'fr'})
        print urltts
        urllib.urlretrieve(urltts, fname)
    subprocess.call([config["player"], fname])

"""
Main
"""

if __name__ == "__main__":
    porte = sys.argv[1]
    m = sys.argv[2]
    signal.signal(signal.SIGINT, signal_handler)
    config = open_and_load_config()
    last_id = ""
    url = config["host"] + "?pid=" + config["doors"][porte] + "&eid=0"
    while 1:
        res = json.loads(urllib2.urlopen(url).read())
        if (res["id"] != last_id):
            msg = choice(config["msgs"][m]) + " " + res["firstname"]
            print msg
            say(msg)
            last_id = res["id"]
        time.sleep(1)
