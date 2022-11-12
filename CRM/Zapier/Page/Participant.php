<?php

class CRM_Zapier_Page_Participant {

  private function sampleParticipant() {
    $participant = civicrm_api3('Participant', 'get', [
      'sequential' => 1,
      'options' => ['limit' => 1, 'sort' => "id DESC"],
    ])['values'][0] ?? NULL;
    $contact = civicrm_api3('Contact', 'getsingle', [
      'id' => $participant['contact_id'],
    ]);
    if (!empty($contact)) {
      $participant['contact_first_name'] = $contact['first_name'] ?? '';
      $participant['contact_last_name'] = $contact['last_name'] ?? '';
      $participant['contact_email'] = $contact['email'] ?? '';
    }
    if (empty($participant)) {
      $participant = [
        'id' => '134',
        'contact_id' => 'John Doe',
        'contact_first_name' => 'John',
        'contact_last_name' => 'Doe',
        'contact_email' => 'john.doe@example.com',
        'event_title' => 'Fall Fundraiser Dinner',
        'participant_status' => 'Registered',
        'participant_role' => 'Volunteer',
        'participant_source' => 'created from zapier',
        'participant_fee_amount' => '100',
      ];
      // $participant = [
      //   'id' => '134',
      //   'contact_id' => 'John Doe',
      //   'contact_first_name' => 'John',
      //   'contact_last_name' => 'Doe',
      //   'contact_email' => 'john.doe@example.com',
      //   'event_id' => 'Fall Fundraiser Dinner',
      //   'status_id' => 'Registered',
      //   'role_id' => 'Volunteer',
      //   'source' => 'created from zapier',
      //   'fee_amount' => '100',
      // ];
    }
    return [$participant];
  }

  public function run() {
    $contact = $this->sampleParticipant();
    CRM_Utils_JSON::output($contact);
    CRM_Utils_System::civiExit();
  }

}