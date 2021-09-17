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
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function zapier_civicrm_xmlMenu(&$files) {
  _zapier_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function zapier_civicrm_install() {
  _zapier_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function zapier_civicrm_postInstall() {
  _zapier_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function zapier_civicrm_uninstall() {
  _zapier_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function zapier_civicrm_enable() {
  _zapier_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function zapier_civicrm_disable() {
  _zapier_civix_civicrm_disable();
}

function zapier_civicrm_post($op, $objectName, $objectId, &$objectRef) {
  if (($op == 'create' || $op == 'edit') && $objectName == 'Individual') {
    $email = civicrm_api3('Email', 'get', [
      'sequential' => 1,
      'contact_id' => $objectId,
      'is_primary' => 1,
    ])['values'][0]['email'] ?? '';
    $data = [
      'id' => $objectId,
      'first_name' => $objectRef->first_name,
      'last_name' => $objectRef->last_name,
      'email' => $email,
    ];
    $hookURL = CRM_Zapier_Utils::getZapHook('create_contact');
    CRM_Zapier_Utils::triggerZap('POST', $hookURL, $data);
  }

  if (($op == 'create' || $op == 'edit') && $objectName == 'Participant') {
    $participant = civicrm_api3('Participant', 'get', [
      'sequential' => 1,
      'id' => $objectId,
    ])['values'][0] ?? [];

    $data = [
      'id' => $objectId,
      'contact_id' => $participant['display_name'] ?? '',
      'event_id' => $participant['event_title'] ?? '',
      'status_id' => $participant['participant_status'] ?? '',
      'role_id' => $participant['participant_role'] ?? '',
      'source' => $participant['participant_source'] ?? '',
      'fee_amount' => $participant['participant_fee_amount'] ?? '',
    ];
    $hookURL = CRM_Zapier_Utils::getZapHook('update_participant');
    CRM_Zapier_Utils::triggerZap('POST', $hookURL, $data);
  }

}


/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function zapier_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _zapier_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function zapier_civicrm_managed(&$entities) {
  _zapier_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function zapier_civicrm_caseTypes(&$caseTypes) {
  _zapier_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function zapier_civicrm_angularModules(&$angularModules) {
  _zapier_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function zapier_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _zapier_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function zapier_civicrm_entityTypes(&$entityTypes) {
  _zapier_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function zapier_civicrm_themes(&$themes) {
  _zapier_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
function zapier_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 *
function zapier_civicrm_navigationMenu(&$menu) {
  _zapier_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _zapier_civix_navigationMenu($menu);
} // */
