# wmtu.mtu.edu [![Build Status](https://travis-ci.org/WMTU/wmtu.mtu.edu.svg)](https://travis-ci.org/WMTU/wmtu.mtu.edu)
===============

Welcome to the repo for WMTU's homepage. This page is built using [Jekyll](http://jekyllrb.com/docs/home/).
Please give the Jekyll docs a read before making any changes.

Some things specific to take note of:

 - The stream url is located in the _config.yml file, updating it there will update site wide
 - Pages can be added easily by adding a new markdown file like station-documents.md
 - Any changes to the master branch will be built in Travis and synced to the WMTU webserver
 - index.html contains all the department and advisor contact info
 - Jekyll pages are loaded with pjax automatically to prevent the player from reloading, all other external links open in new tabs
 - Keep an eye on the build status, should that ever not be green; something is broken and needs to be fixed
