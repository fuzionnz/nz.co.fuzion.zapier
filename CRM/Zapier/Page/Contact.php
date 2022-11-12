<?php

class CRM_Zapier_Page_Contact {

  private function sampleContact() {
    $contact = civicrm_api3('Contact', 'get', [
      'sequential' => 1,
      'contact_type' => "Individual",
      'options' => ['limit' => 1, 'sort' => "id DESC"],
    ])['values'][0] ?? NULL;
    if (empty($contact)) {
      $contact = [
        'id' => '1',
        'first_name' => 'Dummy',
        'last_name' => 'Dummy',
        'email' => 'dummy@email.com',
      ];
    }
    return [$contact];
  }

  public function run() {
    $contact = $this->sampleContact();
    CRM_Utils_JSON::output($contact);
    CRM_Utils_System::civiExit();
  }

}
