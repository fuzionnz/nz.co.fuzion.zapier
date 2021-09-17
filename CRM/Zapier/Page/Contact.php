<?php

class CRM_Zapier_Page_Contact {

  public function run() {
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE); //convert JSON into array

    $id = CRM_Utils_Request::retrieveValue('id', 'Integer', NULL, FALSE);
    if (empty($id)) {
      $contact = [
        0 => [
          'id' => '1',
          'first_name' => 'Dummy22',
          'last_name' => 'Dummy22',
          'email' => 'dummy22@email.com',
        ],
        1 => [
          'id' => '2',
          'first_name' => 'Dummy2',
          'last_name' => 'Dummy2',
          'email' => 'dummy2@email.com',
        ],
      ];
    }
    else {
      $contact = \Civi\Api4\Contact::get(FALSE)
      ->addWhere('id', '=', $id)
      ->execute()
      ->first();
      if (empty($contact['id'])) {
        $contact = [
          0 => [
            'id' => '1',
            'first_name' => 'Dummy',
            'last_name' => 'Dummy',
            'email' => 'dummy@email.com',
          ],
          1 => [
            'id' => '2',
            'first_name' => 'Dummy2',
            'last_name' => 'Dummy2',
            'email' => 'dummy2@email.com',
          ],
        ];
      }
    }
    $contact = [
      0 => [
        'id' => '134',
        'first_name' => 'Dummy4',
        'last_name' => 'Dummy4',
        'email' => 'dummy4@email.com',
      ]
    ];

    CRM_Utils_JSON::output($contact);
    CRM_Utils_System::civiExit();
  }

  // public static function createContact($id) {

  // }

}
