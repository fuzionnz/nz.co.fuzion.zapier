<?php

class CRM_Zapier_Page_Auth {

  /**
   * Authenticate CiviCRM on zapier account.
   */
  public function run() {
    $apiKey = CRM_Utils_Request::retrieveValue('apiKey', 'String', NULL, TRUE);
    CRM_Utils_Request::retrieveValue('key', 'String', NULL, TRUE);

    $contactsWithApiKey = \Civi\Api4\Contact::get(FALSE)
      ->addWhere('api_key', '=', $apiKey)
      ->execute()
      ->count();
    if ($contactsWithApiKey < 1) {
      throw new CRM_Core_Exception(ts('API Key not found.'));
    }

    $keyValid = CRM_Utils_System::authenticateKey(FALSE);
    if (empty($keyValid)) {
      throw new CRM_Core_Exception(ts('Invalid Site key.'));
    }


    CRM_Utils_JSON::output(['success']);

    CRM_Utils_System::civiExit();
  }

}
