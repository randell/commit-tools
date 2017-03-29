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

  /**
   * Command theme:setup
   *
   * This will checkout and copy the directory into the sites theme folders.
   * This will allow a theme git repo to be managed out side of the
   * Drupal repo without subtrees + submodules which makes it compatible with
   * various hosting arrangements.
   */
  public function themeSetup() {
    if (!$this->getConfig('theme.name', FALSE)) {
      $this->io()->error('Theme name needs to be defined.');
      return;
    }

    $this->io()->title('Theme setup');

    // Create a git clone of the configured theme repo.
    $this->taskGitStack()
      ->stopOnFail()
      ->cloneRepo($this->getConfig('theme.repo'), __DIR__ . '/../' . $this->getConfig('theme.name'))
      ->run();

    $this->themeSync();
  }

  /**
   * Command theme:sync.
   *
   * Handles copying files back to to the docroot. We use PHP as opposed to the
   * filesystem so we can run this on Windows and 'nix systems a like.
   */
  public function themeSync() {
    $src = __DIR__ . '/../' . $this->getConfig('theme.name');
    $dst = $this->getConfig('theme.dir');

    $result = $this->taskCopyDir([$src => $dst])->run();

    if (!$result) {
      $this->io()->error('Unable to copy theme files');
      return;
    }

    $this->io()->success('Successfully copied theme files');
  }

  /**
   * Command theme:watch.
   *
   * This will watch the directory and monitor for any changes. If a file in the
   * directory changes we will build all the assets and sync the theme folder.
   *
   * This should be run when actively developing the theme.
   */
  public function themeWatch() {
    return $this->taskWatch()
      ->monitor('../'. $this->getConfig('theme.name'), function() {
        $this->themeSync();
      });
  }

  /**
   * Command theme:branch.
   */
  public function themeBranch() {
    chdir(__DIR__ . '/../' . $this->getConfig('theme.name'));
    $branch = $this->ask('Enter a branch name');

    $this->taskGitStack()
      ->stopOnFail()
      ->checkout("-b $branch")
      ->run();
  }

  public function themeCommit() {
    chdir(__DIR__ . '/../' . $this->getConfig('theme.name'));
    $message = $this->ask('Enter a commit message');

    $this->taskGitStack()
      ->stopOnFail()
      ->add('-A')
      ->commit($message)
      ->push()
      ->run();
  }

}