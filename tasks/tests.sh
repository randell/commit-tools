#!/usr/bin/env bash

#
# govCMS Project
# Perform unit tets against the custom themes.
#

ROOT=`pwd`
PHPUNIT="$ROOT/vendor/bin/phpunit"
DIR="$ROOT/docroot/sites/all/themes/custom"

if [ ! -d "$DIR" ]; then
  echo "Custom theme directory is not found... skipping theme tests."
  exit 0;
fi

DIRS=`find $DIR -name tests -type d`

# Run all tests to make sure they're working.
for d in $DIRS
do
  $PHPUNIT $d
  if [ $? != 0 ]; then
  	echo "Tests failing, fix the tests before commit."
  	exit 1
  fi
done
