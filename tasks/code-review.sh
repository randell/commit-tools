#!/usr/bin/env bash

#
# govCMS Project
# Perform code review tasks against the changed files.
#
shift
CHANGED_FILES=$@

ROOT=`pwd`
PHPCS="$ROOT/vendor/bin/phpcs"

for FILE in $CHANGED_FILES
do
  # Lint the files to ensure no syntax errors.
  php -l $FILE
  if [ $? != 0 ]; then
		echo "Fix the error before commit."
		exit 1
  fi
done

# Run phpcs across changed files.
# @TODO: Could potentially include the Drupal best practice sniff from coder.
$PHPCS --standard=Drupal -n -p $CHANGED_FILES
if [ $? != 0 ]; then
	echo "Fix the error before commit."
	exit 1
fi
