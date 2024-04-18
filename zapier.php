<?php

require_once 'zapier.civix.php';
use CRM_Zapier_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function zapier_civicrm_config(&$config) {
  _zapier_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function zapier_civicrm_install() {
  CRM_Core_DAO::executeQuery("INSERT INTO civirule_action (name, label, class_name, is_active)
  VALUES('trigger_zap', 'Trigger Zap', 'CRM_CivirulesActions_Zapier_Trigger', 1)");
  _zapier_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function zapier_civicrm_enable() {
  _zapier_civix_civicrm_enable();
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function zapier_civicrm_navigationMenu(&$menu) {
  _zapier_civix_insert_navigation_menu($menu, 'Administer', [
    'label' => E::ts('Zapier Hooks'),
    'name' => 'Zapier Hooks',
    'url' => 'civicrm/zaphooks?reset=1',
    'permission' => 'access CiviCRM',
    'separator' => 0,
  ]);
  _zapier_civix_navigationMenu($menu);
}
