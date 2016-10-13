#
# @file
# Perform security scan against changed files.
#
ROOT="$(pwd)"
EXCLUDE="/modules/contrib"

shift
CHANGED_FILES=$@
declare -a SNIFF_FILES

for FILE in $CHANGED_FILES
do
  # Exclude the files that we dont want to run audit for.
  if [[ ! $FILE =~ $EXCLUDE ]]; then
    SNIFF_FILES=("${SNIFF_FILES[@]}" "$FILE")
  fi

  if [ ! $FILE =~ *.tpl.php ]; then
    continue
  fi

  # Restricted functions
  FN=(
    "exec"
    "passthru"
    "shell_exec"
    "system"
    "proc_open"
    "popen"
    "curl_exec"
    "curl_multi_exec"
    "parse_ini_file"
    "show_source"
  )

  for F in $FN
  do
    # Check if the file contains a restricted function.
    grep -q "${F}(" $FILE && { printf "Error in $FILE:\n$F is disallowed."; exit; }
  done

done


# PHPCS Security Audit is shipped with an example Drupal security scan.
if [ ! -z "$SNIFF_FILES" ]; then
  $PHPCS --standard="$ROOT/vendor/pheromone/phpcs-security-audit/example_drupal7_ruleset.xml" -n -p $CHANGED_FILES
  if [ $? != 0 ]; then
	  echo "Fix the error before commit."
	  exit 1
  fi
fi
