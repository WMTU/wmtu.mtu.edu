#!/usr/bin/env bash

echo 'Installing SCP Gem'
gem install net-scp


RUBY_VERSION=`ruby -v`
echo 'Ruby Version $RUBY_VERSION'

echo 'Copying Built Site to Server'
ruby scripts/scp.rb $USERNAME $PASSWORD wmtu.mtu.edu _site /var/www/
