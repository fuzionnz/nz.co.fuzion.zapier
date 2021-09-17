<?php

use CRM_Zapier_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Zapier_Form_TriggerZap extends CRM_CivirulesActions_Form_Form {

  /**
   * Method to get groups
   *
   * @return array
   * @access protected
   */
  protected function getZapOptions() {
    $options = [
      'create_contact' => 'Create Contact',
      'update_participant' => 'Update Participant',
    ];
    return $options;
  }

  /**
   * Overridden parent method to build the form
   *
   * @access public
   */
  public function buildQuickForm() {
    $this->add('hidden', 'rule_action_id');

    $this->add('select', 'zap', ts('Select triggering Zap'), array('' => ts('-- please select --')) + $this->getZapOptions());
    $this->addButtons(array(
      array('type' => 'next', 'name' => ts('Save'), 'isDefault' => TRUE,),
      array('type' => 'cancel', 'name' => ts('Cancel'))));
  }

  public function addRules() {
    $this->addFormRule(array('CRM_Zapier_Form_TriggerZap', 'validateZap'));
  }

  /**
   * Function to validate value of rule action form
   *
   * @param array $fields
   * @return array|bool
   * @access public
   * @static
   */
  static function validateZap($fields) {
    $errors = array();
    if (empty($fields['zap'])) {
      $errors['zap'] = ts('You have to select at least one trigger');
    }

    if (count($errors)) {
      return $errors;
    }
    return true;
  }

  /**
   * Overridden parent method to set default values
   *
   * @return array $defaultValues
   * @access public
   */
  public function setDefaultValues() {
    $defaultValues = parent::setDefaultValues();
    $data = unserialize($this->ruleAction->action_params);
    if (!empty($data['zap_trigger'])) {
      $defaultValues['zap'] = $data['zap_trigger'];
    }
    return $defaultValues;
  }

  /**
   * Overridden parent method to process form data after submitting
   *
   * @access public
   */
  public function postProcess() {
    $data['zap_trigger'] = array();

    $data['zap_trigger'] = $this->_submitValues['zap'];

    $this->ruleAction->action_params = serialize($data);
    $this->ruleAction->save();
    parent::postProcess();
  }


}
