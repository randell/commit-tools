# Pre-commit tools

Pre-commit tools for Acquia Cloud Drupal projects. Performs quality assurance tasks for each commit made against a project.

The tool uses [PHPCS](1), [PHP Unit] and [Drupal Coder] and these tools will be installed locally to the project. New developers on a project will have the prerequisites met when they perform their first commit.

## Dependencies

- Acquia Cloud hosting directory structure

## Install

- Copy `pre-commit` into `.git/hooks`
- Copy `pre-commit-hooks` directory into `.git/hooks`
- Perform a commit or run `./.git/hooks/pre-commit`

When the initial commit is run it will validate the project and fetch any missing files that it requires to run.

## Notes

- Hooks can be skipped by adding the `--no-verify` option when committing

(1): https://github.com/squizlabs/PHP_CodeSniffer
(2): https://github.com/sebastianbergmann/phpunit
(3): https://packagist.org/packages/drupal/coder
