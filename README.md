# Commit Tools

Project set up tools for Drupal 7 based projects. Automated tasks to help speed up the initial project set up phase and help best practice adoption.

## Install

```
wget https://raw.githubusercontent.com/steveworley/commit-tools/master/d7setup.phar
```

## Running commands

The commands are bundled as a phar archive and should contain all the dependencies.

```
php d7setup.phar theme
```

## Avaialable commands

### theme

Runs all commands to set up a theme ready for best practice development.

#### theme:template 

Modifies `template.php` for better code organisation.

#### theme:directories

Creates directories in your theme folder to allow for better code organisation.

### config:setup

Downloads the latest versioin of the features module and attempts to patch the module to allow for configuration imports back into the database.