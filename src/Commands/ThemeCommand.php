<?php

/**
 * @file
 * Commands relating to setting up the initial theme.
 */

namespace D7Setup\Commands;

use D7Setup\TaskTraits;
use \Robo\Tasks;

class ThemeCommand extends Tasks {

  use TaskTraits;

  /**
   * Perform all theme setup functions.
   */
  public function theme() {
    $this->themeName();
    $this->themeDir();

    $this->themeTemplate();
    $this->themeDirectories();
  }

  /**
   * Update the template.php file so that it attempts to include files from the
   */
  public function themeTemplate() {
    $this->io()->title("theme:template");
    $theme_name = $this->themeName();

    $this->io()->write("Updating <fg=blue>$theme_name</> template.php", TRUE);

    $lines = [
      '',
      '$theme_dir = version_compare(phpversion(), \'5.3.10\', \'<\') ? dirname(__FILE__) : __DIR__;',
      '',
      '/**',
      ' * Include helpers from the helpers folder.',
      ' *',
      ' * Naming convetion for helper files should be {helper}.inc.',
      ' */',
      'foreach (glob($theme_dir . \'/includes/helpers/*.inc\') as $filename) {',
      '  require_once $filename;',
      '}',
      '',
      '/**',
      ' * Include preprocessors from the preprocess folder.',
      ' *',
      ' * Naming convetion for helper preprocess should be {helper}.inc.',
      ' */',
      'foreach (glob($theme_dir . \'/includes/preprocess/*.inc\') as $filename) {',
      '  require_once $filename;',
      '}',
      '',
      '/**',
      ' * Include alters from the alter folder.',
      ' *',
      ' * Naming convetion for alter files should be {theme_hook}.inc.',
      ' */',
      'foreach (glob($theme_dir . \'/includes/alter/*.inc\') as $filename) {',
      '  require_once $filename;',
      '}',
    ];

    $this->taskWriteToFile($this->themeDir() . '/template.php')
      ->append(TRUE)
      ->lines($lines)
      ->run();

    $this->io()->success("Successfully updated template.php");
  }

  /**
   * Create the theme directories.
   */
  public function themeDirectories() {
    $this->io()->title('theme:directories');
    $theme_name = $this->themeName();
    $theme_dir = $this->themeDir();

    $dirs = [
      'includes',
      'includes/alter',
      'includes/helper',
      'includes/preprocess',
    ];

    $fs = $this->taskFilesystemStack();

    foreach ($dirs as $dir) {
      $fs->mkdir("{$theme_dir}/{$dir}");
    }

    $fs->run();

    $this->io()->success("Successfully created theme directories");
  }
}