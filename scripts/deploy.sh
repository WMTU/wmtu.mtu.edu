#!/usr/bin/env bash

CURRENT_BRANCH=`git branch | grep '*' | awk '{ print($2); }'`
echo "Checking Git Branch $DEPLOY_BRANCH"
echo "Currently on Branch $CURRENT_BRANCH"

if [ "$CURRENT_BRANCH" != "$DEPLOY_BRANCH" ]; then
  echo "Not On $DEPLOY_BRANCH, Not Deploying"
  exit 0;
fi

echo 'Copying Built Site to Server'
ruby scripts/scp.rb $USERNAME $PASSWORD wmtu.mtu.edu _site /var/www/
