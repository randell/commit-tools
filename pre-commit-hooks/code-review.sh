#!/usr/bin/env bash

#
# govCMS Project
# Perform code review tasks against the changed files.
#

ROOT=`pwd`
PHPCS="$ROOT/vendor/bin/phpcs"
UPSTREAM=$1
FILES=$2
LINTED_FILES=''

for f in $FILES
do

  if [ ! -f $f ]; then
    # If the file has been deleted we can skip this file.
    continue
  fi

  # Lint the files to ensure no syntax errors.
  php -l $f
  if [ $? != 0 ]; then
		echo "Fix the error before commit."
		exit 1
  fi

  # Keep track of the files that have been linted as these will be passed to
  # phpcs for code standard checking.
  LINTED_FILES="$LINTED_FILES $f"
done

# Run phpcs across changed files.
# @TODO: Could potentially include the Drupal best practice sniff from coder.
$PHPCS --standard=Drupal -n -p $LINTED_FILES
if [ $? != 0 ]; then
	echo "Fix the error before commit."
	exit 1
fi
