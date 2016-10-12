# Pre-commit tools

Pre-commit tools for Acquia Cloud Drupal projects. Performs quality assurance tasks for each commit made against a project. Code will not be able to be commited until it passes the minimum quality standards.

The tool uses [PHPCS][1], [PHP Unit][2] and [Drupal Coder][3]. These tools will be installed locally to the project so as not to conflict with other installed versions.

## Dependencies

- Acquia Cloud hosting directory structure
- git
- php
- wget

## Initial Setup

```
wget https://raw.githubusercontent.com/steveworley/commit-tools/master/setup -v -O setup && chmod +x ./setup && ./setup develop
```

Alternatively:

- Download [`setup`][4]
- Configure the upstream
- Execute `setup`

The `setup` file should be committed to the project repo so that developers can run `./setup` prior to starting work. This will ensure that all `pre-commit` tasks are available.

### Arguments

The `setup` script will accept a number of arguments to help generate the required files for the project.

#### UPSTREAM

The upstream branch that this project will use.

#### PREFIX

The project prefix. Typically should match the JIRA prefix.

#### LENGTH

The minimum length a commit message can be.

**Example**

```
wget https://raw.githubusercontent.com/steveworley/commit-tools/master/setup -v -O setup && chmod +x ./setup && ./setup develop PRO 20
```

Any arguments provided will be used to update the `setup` script so that subsequent runs can install dependencies without knowledge of configuration.

### Configuration

Alter the `setup` file and change the configuration variables so they match your project.

- `UPSTREAM` _[default: master]_: A branch that is considered the upstream. This will be the branch that is used to generate the diff when determining which files to validate.
- `TASKS` _[default: (code-review.sh tests.sh)]_: A list of tasks that you want to include with this project. These will be downloaded from [tasks][5] so only files available here can be used.
- `PREFIX` _[default: PROJ]_: Prefix used for commit messages typically set to JIRA project name
- `LENGTH` _[default: 15]_: Minimum length for commit messages

## Developer setup

When a new developer picks up the project they will be required to run the `./setup` script, this will ensure that all tools are downloaded and everything is setup ready for them to begin committing code.

## Notes

- Hooks can be skipped by adding the `--no-verify` option when committing

[1]: https://github.com/squizlabs/PHP_CodeSniffer
[2]: https://github.com/sebastianbergmann/phpunit
[3]: https://packagist.org/packages/drupal/coder
[4]: https://raw.githubusercontent.com/steveworley/commit-tools/master/setup
[5]: https://github.com/steveworley/commit-tools/tree/master/tasks
