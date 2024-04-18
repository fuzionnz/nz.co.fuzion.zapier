<?php

use CRM_Civirules_ExtensionUtil as E;

class CRM_CivirulesActions_Zapier_Trigger extends CRM_Civirules_Action {

  /**
   * Process the action
   *
   * @param CRM_Civirules_TriggerData_TriggerData $triggerData
   * @access public
   */
  public function processAction(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $params = $this->getActionParameters();
    $entity = $triggerData->getEntity();
    $entityParams = [
      'Contact' => ['*', 'custom.*', 'address_primary.*', 'email_primary.*', 'phone_primary.*'],
      'Membership' => ['*', 'custom.*', 'contact_id.*'],
      'Participant' => ['*', 'custom.*', 'contact_id.*', 'event_id.*'],
    ];
    if (isset($entityParams[$entity])) {
      $entityData = $triggerData->getEntityData($entity);

      $apiValues = civicrm_api4($entity, 'get', [
        'select' => $entityParams[$entity],
        'checkPermissions' => FALSE,
        'where' => [
          ['id', '=', $entityData['id']],
        ],
      ])->first();

      $hookURL = CRM_Zapier_Utils::getZapHook($params['zap_trigger']);
      if (!empty($hookURL) && !empty($apiValues)) {
        CRM_Zapier_Utils::triggerZap('POST', $hookURL, $apiValues);
      }
    }
  }

  /**
   * Returns a redirect url to extra data input from the user after adding a action
   *
   * @param int $ruleActionId
   * @return bool|string
   * @access public
   */
  public function getExtraDataInputUrl($ruleActionId) {
    return CRM_Utils_System::url('civicrm/civirule/form/action/zapier', 'rule_action_id='.$ruleActionId);
  }


  /**
   * Returns a user friendly text explaining the condition params
   * e.g. 'Older than 65'
   *
   * @return string
   * @access public
   */
  public function userFriendlyConditionParams() {
    $params = $this->getActionParameters();
    $roles = CRM_Zapier_Utils::getZapOptions();
    $zap = $roles[$params['zap_trigger']];
    return E::ts('Trigger Zap for <em>%1</em>', [1 => $zap]);
  }

}
