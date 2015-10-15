#!/usr/bin/env bash

echo "Checking Git Branch $DEPLOY_BRANCH"
echo "Currently on Branch $TRAVIS_BRANCH"

if [ "$TRAVIS_BRANCH" != "$DEPLOY_BRANCH" ]; then
  echo "Not On $DEPLOY_BRANCH, Not Deploying"
  exit 0;
fi

echo 'Copying Built Site to Server'
cd _site
ruby ../scripts/scp.rb $USERNAME $PASSWORD wmtu.mtu.edu . /var/www/
