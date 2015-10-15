#!/usr/bin/env bash

CURRENT_BRANCH=`git rev-parse --abbrev-ref HEAD`
echo "Checking Git Branch $DEPLOY_BRANCH"

if [ "$CURRENT_BRANCH" != "$DEPLOY_BRANCH" ]; then
  echo "Not On $DEPLOY_BRANCH, Not Deploying"
  exit 0;
fi

echo 'Copying Built Site to Server'
ruby scripts/scp.rb $USERNAME $PASSWORD wmtu.mtu.edu _site /var/www/
