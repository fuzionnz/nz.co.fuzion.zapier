<?php

class CRM_Zapier_Triggers_UpdateParticipant {

  public function sendData($participantID, $params = []) {
    $participant = civicrm_api3('Participant', 'get', [
      'sequential' => 1,
      'id' => $participantID,
    ])['values'][0] ?? [];

    $data = [
      'id' => $participantID,
      'contact_id' => $participant['display_name'] ?? '',
      'event_id' => $participant['event_title'] ?? '',
      'status_id' => $participant['participant_status'] ?? '',
      'role_id' => $participant['participant_role'] ?? '',
      'source' => $participant['participant_source'] ?? '',
      'fee_amount' => $participant['participant_fee_amount'] ?? '',
    ];
    $hookURL = CRM_Zapier_Utils::getZapHook('update_participant');
    CRM_Zapier_Utils::triggerZap('POST', $hookURL, $data);
  }

}