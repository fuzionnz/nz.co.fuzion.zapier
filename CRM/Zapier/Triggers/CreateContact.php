<?php

class CRM_Zapier_Triggers_CreateContact {

  public function sendData($contactID, $params = []) {
    $contact = civicrm_api3('Contact', 'getsingle', [
      'sequential' => 1,
      'id' => $contactID,
    ]);
    $hookURL = CRM_Zapier_Utils::getZapHook('create_contact');
    CRM_Zapier_Utils::triggerZap('POST', $hookURL, $contact);
  }

}