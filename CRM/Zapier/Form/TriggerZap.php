<?php

use CRM_Zapier_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Zapier_Form_TriggerZap extends CRM_CivirulesActions_Form_Form {

  /**
   * Overridden parent method to set default values
   *
   * @return array $defaultValues
   * @access public
   */
  public function setDefaultValues() {
    $defaultValues = parent::setDefaultValues();
    if (empty($this->ruleAction->action_params)) {
      return $defaultValues;
    }
    $data = unserialize($this->ruleAction->action_params);
    if (!empty($data['zap_trigger'])) {
      $defaultValues['zap'] = $data['zap_trigger'];
    }
    return $defaultValues;
  }

  /**
   * Overridden parent method to build the form
   *
   * @access public
   */
  public function buildQuickForm() {
    $this->add('hidden', 'rule_action_id');

    $this->add('select', 'zap', ts('Select triggering Zap'), ['' => ts('- select -')] + CRM_Zapier_Utils::getZapOptions(), TRUE, ['class' => 'crm-select2 huge']);
    $this->addButtons([
      ['type' => 'next', 'name' => ts('Save'), 'isDefault' => TRUE,],
      ['type' => 'cancel', 'name' => ts('Cancel')]
    ]);
  }

  /**
   * Overridden parent method to process form data after submitting
   *
   * @access public
   */
  public function postProcess() {
    $data['zap_trigger'] = $this->_submitValues['zap'];

    $this->ruleAction->action_params = serialize($data);
    $this->ruleAction->save();
    parent::postProcess();
  }

}
