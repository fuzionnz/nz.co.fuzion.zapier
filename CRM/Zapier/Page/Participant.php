<?php

class CRM_Zapier_Page_Participant {

  public function run() {

    $contact = [
      0 => [
        'id' => '134',
        'contact_id' => 'John Doe',
        'event_id' => 'Fall Fundraiser Dinner',
        'status_id' => 'Registered',
        'role_id' => 'Volunteer',
        'source' => 'created from zapier',
        'fee_amount' => '100',
      ]
    ];

    CRM_Utils_JSON::output($contact);
    CRM_Utils_System::civiExit();
  }

}