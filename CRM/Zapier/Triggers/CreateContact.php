<?php

class CRM_Zapier_Triggers_CreateContact {

  public function sendData($contactID, $params = []) {
    $email = civicrm_api3('Email', 'get', [
      'sequential' => 1,
      'contact_id' => $contactID,
      'is_primary' => 1,
    ])['values'][0]['email'] ?? '';
    $data = [
      'id' => $contactID,
      'first_name' => $objectRef->first_name,
      'last_name' => $objectRef->last_name,
      'email' => $email,
    ];
    $hookURL = CRM_Zapier_Utils::getZapHook('create_contact');
    CRM_Zapier_Utils::triggerZap('POST', $hookURL, $data);
  }

}