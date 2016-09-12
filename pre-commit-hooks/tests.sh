#!/usr/bin/env bash

#
# govCMS Project
# Perform unit tets against the custom themes.
#

ROOT=`pwd`
PHPUNIT="$ROOT/vendor/bin/phpunit"
DIRS=`find $ROOT/docroot/sites/all/themes/custom -name tests -type d`

# Run all tests to make sure they're working.
for d in $DIRS
do
  $PHPUNIT $d
  if [ $? != 0 ]; then
  	echo "Tests failing, fix the tests before commit."
  	exit 1
  fi
done
