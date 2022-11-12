<?php

class CRM_Zapier_Page_Contact {

  private function sampleContact() {
    return [[
      'id' => '1',
      'first_name' => 'Dummy',
      'last_name' => 'Dummy',
      'email' => 'dummy@email.com',
    ]];
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
