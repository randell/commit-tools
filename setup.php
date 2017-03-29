<?php

/**
 * @file
 * Project set up entry point.
 */
$pharPath = \Phar::running(true);

if ($pharPath) {
  require_once "$pharPath/vendor/autoload.php";
} else {
  if (file_exists(__DIR__.'/vendor/autoload.php')) {
    require_once __DIR__.'/vendor/autoload.php';
  } elseif (file_exists(__DIR__.'/../../autoload.php')) {
    require_once __DIR__ . '/../../autoload.php';
  }
}

$name = 'Drupal theme setup';
$ver = '0.0.0-alpha0';

$discovery = new \Consolidation\AnnotatedCommand\CommandFileDiscovery();
$discovery->setSearchPattern('*Command.php');
$commands = $discovery->discover('src/Commands', '\D7Setup\Commands');

$status = \Robo\Robo::run($_SERVER['argv'], $commands, $name, $ver);

exit($status);
