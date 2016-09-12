# Pre-commit tools

Pre-commit tools for Acquia Cloud Drupal projects. Performs quality assurance tasks for each commit made against a project.

The tool uses [PHPCS][1], [PHP Unit][2] and [Drupal Coder][3] and these tools will be installed locally to the project. New developers on a project will have the prerequisites met when they perform their first commit.

## Dependencies

- Acquia Cloud hosting directory structure
- git
- php
- wget

## Install

```
wget https://raw.githubusercontent.com/steveworley/pre-commit-tools/master/setup -v -O setup && chmod +x ./setup && ./setup {UPSTREAM}
```

Alternatively:

- Download [`setup`][4]
- Configure the upstream
- Execute `setup`

When sharing a project around, developers will need to run `./setup` prior to starting work, this will ensure that all `pre-commit` hooks are available.

## Configuration

Alter the `setup` file and change the configuration variables so they match your project.

- `UPSTREAM` _[default: master]_: A branch that is considered the upstream. This will be the branch that is used to generate the diff when determining which files to validate.
- `TASKS` _[default: (code-review.sh tests.sh)]_: A list of tasks that you want to include with this project. These will be downloaded from [tasks][5] so only files available here can be used.

## Notes

- Hooks can be skipped by adding the `--no-verify` option when committing

[1]: https://github.com/squizlabs/PHP_CodeSniffer
[2]: https://github.com/sebastianbergmann/phpunit
[3]: https://packagist.org/packages/drupal/coder
[4]: https://raw.githubusercontent.com/steveworley/pre-commit-tools/master/setup
[5]: https://github.com/steveworley/pre-commit-tools/tree/master/tasks
