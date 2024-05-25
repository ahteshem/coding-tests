# User Company Import Module

## Introduction

The User Company Import module is a custom Drupal module designed to import and display user and company content from external JSON resources. It provides functionalities to import user and company nodes using the Drupal migration API and display the content on a custom page.

## Requirements

- Drupal 9 or later
- Migrate Plus module
- Migrate Tools module

## Installation

1. Download and enable the module:
-  drush pm:enable user_company_import

2. Run the migration
-  drush user_company_import:run
