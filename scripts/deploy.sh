#!/usr/bin/env bash

echo 'Installing SCP Gem'
travis_retry gem install net-scp

echo 'Copying Built Site to Server'
ruby scripts/scp.rb $USERNAME $PASSWORD wmtu.mtu.edu _site /var/www/
