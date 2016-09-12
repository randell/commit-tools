# Pre-commit tools

Pre-commit tools for Acquia Cloud Drupal projects. Performs quality assurance tasks for each commit made against a project.

The tool uses [PHPCS], [PHP Unit] and [Drupal Code] and these tools will be installed locally to the project.

## Dependencies

- Acquia Cloud hosting directory structure
- Git is initialised

## Install

- Add `setup` to your project
- Run `./setup`

## Project

When sharing a project around, developers will need to run `./setup` prior to starting work. This will ensure that all `pre-commit` hooks are available.

## Notes

- Hooks can be skipped by adding the `--no-verify` option when committing
