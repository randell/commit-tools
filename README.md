# Pre-commit tools

Pre-commit tools for Acquia Cloud Drupal projects. Performs quality assurance tasks for each commit made against a project.

The tool uses [PHPCS], [PHP Unit] and [Drupal Code] and these tools will be installed locally to the project.

## Dependencies

- Acquia Cloud hosting directory structure

## Install

- Copy `pre-commit` into `.git/hooks`
- Copy `pre-commit-hooks` directory into `.git/hooks`
- Perform a commit or run `./.git/hooks/pre-commit`

When the initial commit is run it will validate the project and fetch any missing files that it requires to run.

## Project

The tool is written in a way that will validate installation prior to committing. New developers on a project will have the prerequisites met when they perform their first commit.

## Notes

- Hooks can be skipped by adding the `--no-verify` option when committing
