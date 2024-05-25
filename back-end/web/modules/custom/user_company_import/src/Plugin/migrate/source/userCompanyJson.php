<?php

declare(strict_types = 1);

namespace Drupal\user_company_import\Plugin\migrate\source;

use Drupal\migrate_plus\Plugin\migrate\source\Url;
use Drupal\migrate\Row;

/**
 * Source plugin for users and companies.
 *
 * @MigrateSource(
 *   id = "json_user"
 * )
 */
class userCompanyJson extends Url {

  /**
   * {@inheritdoc}
   */
  public function fields(): array
  {
    return [
      'id' => $this->t('User ID'),
      'name' => $this->t('Name'),
      'username' => $this->t('Username'),
      'email' => $this->t('Email'),
      'address' => $this->t('Address'),
      'phone' => $this->t('Phone'),
      'website' => $this->t('Website'),
      'company' => $this->t('Company'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getIds(): array
  {
    return [
      'id' => [
        'type' => 'integer',
        'alias' => 'u',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $company = $row->getSourceProperty('company');
    $row->setSourceProperty('company_name', $company['name']);
    $row->setSourceProperty('company_catchphrase', $company['catchPhrase']);
    $row->setSourceProperty('company_bs', $company['bs']);

    return parent::prepareRow($row);
  }
}
