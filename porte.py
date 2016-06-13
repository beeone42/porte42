#!/usr/bin/env python

import os, json, sys, requests, urllib, urllib2

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

"""
Main
"""
        
if __name__ == "__main__":
    config = open_and_load_config()
    print config
