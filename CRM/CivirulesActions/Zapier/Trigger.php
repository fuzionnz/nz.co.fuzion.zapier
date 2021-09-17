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
    switch ($params['zap_trigger']) {
      case 'create_contact':
        $entity = $triggerData->getEntityData("Contact");
        CRM_Zapier_Triggers_CreateContact::sendData($entity['id'], $entity);
        break;

      case 'update_participant':
        $entity = $triggerData->getEntityData("Participant");
        CRM_Zapier_Triggers_UpdateParticipant::sendData($entity['id'], $entity);
        break;

      default:
        break;
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
    // return FALSE;
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
    $roles = self::getZapOptions();
    $zap = $roles[$params['zap_trigger']];
    return E::ts('Trigger Zap for <em>%1</em>', array(1 => $zap));
  }


  /**
   * Returns a list of possible case roles
   *
   * @return array
   * @throws \CiviCRM_API3_Exception
   */
  public static function getZapOptions() {
    $caseRoles = [
      'create_contact' => 'Create Contact',
      'update_participant' => 'Update Participant',
    ];
    return $caseRoles;
  }
}
