<?php

namespace Drupal\user_company_import\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Controller for displaying user and company content.
 */
class UserCompanyContentController extends ControllerBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new UserCompanyContentController object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Displays user and company content.
   *
   * @return array
   *   A render array.
   */
  public function content() {
    $build = [];

    // Load user nodes.
    $user_storage = $this->entityTypeManager->getStorage('node');
    $user_query = $user_storage->getQuery()
      ->accessCheck(FALSE)
      ->condition('type', 'user');
    $user_nids = $user_query->execute();
    $users = $user_storage->loadMultiple($user_nids);

    // Load company nodes.
    $company_query = $user_storage->getQuery()
      ->accessCheck(FALSE)
      ->condition('type', 'company');
    $company_nids = $company_query->execute();
    $companies = $user_storage->loadMultiple($company_nids);

    // Build render array for user nodes.
    $user_render = [
      '#theme' => 'item_list',
      '#items' => [],
    ];
    foreach ($users as $user) {
      $user_render['#items'][] = $user->toLink()->toString();
    }

    // Build render array for company nodes.
    $company_render = [
      '#theme' => 'item_list',
      '#items' => [],
    ];
    foreach ($companies as $company) {
      $company_render['#items'][] = $company->toLink()->toString();
    }

    // Combine user and company content.
    $build[] = $user_render;
    $build[] = $company_render;

    return $build;
  }

}
