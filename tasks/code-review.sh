#!/usr/bin/env bash

#
# govCMS Project
# Perform code review tasks against the changed files.
#
shift
CHANGED_FILES=$@

ROOT=`pwd`
PHPCS="$ROOT/vendor/bin/phpcs"
EXCLUDE="/modules/contrib"

declare -a SNIFF_FILES

for FILE in $CHANGED_FILES
do
  # Exclude the files that we dont want to sniff.
  if [[ ! $FILE =~ $EXCLUDE ]]; then
    SNIFF_FILES=("${SNIFF_FILES[@]}" "$FILE")
  fi

  # Lint the files to ensure no syntax errors.
  php -l $FILE
  if [ $? != 0 ]; then
		echo "Fix the error before commit."
		exit 1
  fi
done

# Run phpcs across changed files.
# @TODO: Could potentially include the Drupal best practice sniff from coder.
if [ ! -z "$SNIFF_FILES" ]; then
  $PHPCS $PHPCS --standard=$ROOT/vendor/drupal/coder/coder_sniffer/Drupal -n -p ${SNIFF_FILES[@]} -n -p ${SNIFF_FILES[@]}
  if [ $? != 0 ]; then
	  echo "Fix the error before commit."
	  exit 1
  fi
fi
