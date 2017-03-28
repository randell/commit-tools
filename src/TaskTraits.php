<?php
/**
 * Created by PhpStorm.
 * User: steven.worley
 * Date: 29/03/2017
 * Time: 9:21 AM
 */

namespace D7Setup;

trait TaskTraits {

  /**
   * @var
   */
  protected $theme_name;

  /**
   * @var
   */
  protected $theme_dir;

  /**
   * Request the theme name.
   *
   * @return string
   *
   * @throws \Exception
   */
  private function themeName() {
    if (empty($this->theme_name)) {
      $this->theme_name = $this->ask("What is the theme name?");
    }

    if (empty($this->theme_name)) {
      $this->io()->writeln('');
      throw new \Exception('A theme name is required.');
    }

    return $this->theme_name;
  }

  /**
   * Get the theme directory.
   *
   * @return string
   *
   * @throws \Exception
   */
  protected function themeDir() {
    if (!empty($this->theme_dir)) {
      return $this->theme_dir;
    }

    $confirm = FALSE;

    $theme_locations = [
      'sites/all/themes',
      'sites/all/themes/custom',
      'sites/default/themes',
      'sites/default/themes/custom',
    ];

    foreach ($theme_locations as $theme) {
      if (is_dir($this->drupalRoot() . "/$theme/" . $this->themeName())) {
        $this->theme_dir = $this->drupalRoot() . "/$theme/" . $this->themeName();
      }
    }

    if (!empty($theme_dir)) {
      $confirm = $this->confirm("Is this the correct theme directory <bg=green>$theme_dir</>?");
    }

    if (!$confirm) {
      $this->theme_dir = $this->ask('What is the theme directory? (relative to the current directory)');
      $this->theme_dir = $this->drupalRoot() . "/{$this->theme_dir}";
    }

    if (empty($this->theme_dir)) {
      $this->io()->writeln('');
      throw new \Exception('A theme directory is required.');
    }

    return $this->theme_dir;
  }

  private function drupalRoot() {
    $base_dir = is_dir(getcwd() . '/docroot') ? getcwd() . '/docroot' : getcwd();
    return $base_dir;
  }

}