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
    // $inputJSON = file_get_contents('php://input');
    // $input = json_decode($inputJSON, TRUE); //convert JSON into array

    // $id = CRM_Utils_Request::retrieveValue('id', 'Integer', NULL, FALSE);
    // if (empty($id)) {
    //   $contact = $this->sampleContact();
    // }
    // else {
    //   $contact = \Civi\Api4\Contact::get(FALSE)
    //   ->addWhere('id', '=', $id)
    //   ->execute()
    //   ->first();
    //   if (empty($contact['id'])) {
    //     $contact = $this->sampleContact();
    //   }
    // }
    $contact = $this->sampleContact();
    // $contact = [
    //   0 => [
    //     'id' => '134',
    //     'first_name' => 'Dummy4',
    //     'last_name' => 'Dummy4',
    //     'email' => 'dummy4@email.com',
    //   ]
    // ];

    CRM_Utils_JSON::output($contact);
    CRM_Utils_System::civiExit();
  }

  // public static function createContact($id) {

  // }

}
