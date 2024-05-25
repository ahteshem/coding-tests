<?php

declare(strict_types = 1);

namespace Drupal\user_company_import\Drush\Commands;

use Drush\Commands\DrushCommands;
use Drupal\migrate\Plugin\MigrationPluginManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\migrate_tools\MigrateExecutable;
use Drupal\migrate\MigrateMessage;

/**
 * A Drush command file.
 */
class JsonImportCommands extends DrushCommands {

  /**
   * The migration plugin manager.
   *
   * @var \Drupal\migrate\Plugin\MigrationPluginManagerInterface
   */
  protected $migrationPluginManager;

  /**
   * Constructs a new JsonImportCommands object.
   *
   * @param \Drupal\migrate\Plugin\MigrationPluginManagerInterface $migration_plugin_manager
   *   The migration plugin manager.
   */
  public function __construct(MigrationPluginManagerInterface $migration_plugin_manager) {
    parent::__construct();
    $this->migrationPluginManager = $migration_plugin_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.migration')
    );
  }

  /**
   * Run the JSON user migration.
   *
   * @command user_company_import:run
   * @aliases uimp
   * @description Runs the JSON user migration.
   */
  public function runMigration() {
    $migration_id = 'user_company_import';
    $migration = $this->migrationPluginManager->createInstance($migration_id);
    if ($migration) {
      $this->output()->writeln("Migration instance created successfully.");
      /** @var \Drupal\migrate\Plugin\MigrationInterface $migration */
      // Debug: Output migration configuration.
      $configuration = $migration->get('source');
      $this->output()->writeln(print_r($configuration, true));
      $migrate_executable = new MigrateExecutable($migration, new MigrateMessage());
      $migrate_executable->import();
      $this->output()->writeln('Migration completed.');
    } else {
      $this->output()->writeln("Migration ID {$migration_id} not found.");
    }
  }
}
