# wmtu.mtu.edu [![Build Status](https://travis-ci.org/WMTU/wmtu.mtu.edu.svg)](https://travis-ci.org/WMTU/wmtu.mtu.edu)

Welcome to the repo for WMTU's homepage. This page is built using [Jekyll](http://jekyllrb.com/docs/home/).
Please give the Jekyll docs a read before making any changes.

Some specific things to take note of:

 - The stream url is located in the _config.yml file, updating it there will update site wide
 - Pages can be added easily by adding a new markdown file like station-documents.md
 - Any changes to the master branch will be built in Travis and synced to the WMTU webserver
 - index.html contains all the department and advisor contact info
 - Jekyll pages are loaded with pjax automatically to prevent the player from reloading, all other external links open in new tabs
 - Keep an eye on the build status, should that ever not be green; something is broken and needs to be fixed
 - The site has some simple php, to render json for the current song info and playlists, located in the php folder
 - Scripts related to building and syncing should go in the scripts folder
 - Any client side js and css libraries should be installed using bower and loaded from their respective folders
 - Any builds that error won't push to production

For large changes, please put them in their own branch so every commit you push that breaks everything doesn't get
pushed to production. Once you're done making your changes merge master to your branch, make sure everything
is and then merge into master.

While you are developing updates test them locally with `jekyll serve` that way you can see the changes before
they get pushed and you can catch any issues before they get pushed to production.

If you want to skip building and pushing for a specific commit put `[ci skip]` somewhere in your git commit message
and that will skip the build process
