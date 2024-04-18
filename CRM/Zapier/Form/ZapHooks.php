<?php

use CRM_Zapier_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Zapier_Form_ZapHooks extends CRM_Core_Form {

  public function buildQuickForm() {

    // add form elements
    $this->add('text', 'create_contact', ts('Create Contact'), ['size' => 60]);
    $this->add('text', 'update_participant', ts('Update Participant'), ['size' => 60]);
    $this->add('text', 'membership_created', ts('Create Membership'), ['size' => 60]);

    $this->addButtons([
      [
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ]
    ]);

    $zapHooks = unserialize(Civi::settings()->get('zapierHooks'));
    $this->setDefaults($zapHooks);

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    $values = $this->exportValues();
    $zapHooks = serialize([
      'create_contact' => $values['create_contact'] ?? '',
      'update_participant' => $values['update_participant'] ?? '',
    ]);
    Civi::settings()->set('zapierHooks', serialize($zapHooks));
    CRM_Core_Session::setStatus(E::ts('Zapier hooks are saved.'));
    parent::postProcess();
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = [];
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

}
