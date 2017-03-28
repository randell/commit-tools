<?php

namespace D7Setup\Commands;

use D7Setup\TaskTraits;
use Robo\Tasks;

class ConfigurationCommand extends Tasks {

  use TaskTraits;

  public function configSetup() {
    $this->io()->title('Configuration management setup');
    $this->io()->writeln(' - Downloading latest version of features');

    $this->drush('dl features-7.x-2.10 --destination=sites/all/modules/contrib > /dev/null 2>&1');
    chdir($this->drupalRoot() . '/sites/all/modules/contrib/features');

    // Download and apply the patch.
    $this->io()->writeln(' - Downloading and applying the patch files');
    $fh = fopen('https://www.drupal.org/files/issues/features-allow-for-remport-of-objects_0.patch', 'r');
    file_put_contents('features-allow-for-remport-of-objects_0.patch', $fh);

    // Patch P1 works more frequently that git apply.
    `patch -p1 < features-allow-for-remport-of-objects_0.patch`;
    unlink('features-allow-for-remport-of-objects_0.patch');

    // Let's see if we've applied the patch correctly.
    include_once('features.drush.inc');
    $drush_cmds = features_drush_command();

    if (isset($drush_cmds['features-import'])) {
      $this->io()->success('Successfully setup configuration management');
      return;
    }

    // Patch not successful- show a message for manual application.
    $this->io()->writeln('');
    $this->io()->warning('Manually download and apply https://www.drupal.org/files/issues/features-allow-for-remport-of-objects_0.patch');
    $this->io()->error('Patch was not able to be applied.');
  }

}