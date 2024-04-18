<?php

class CRM_Zapier_Utils {

  /**
   * Returns a list of zap options
   *
   * @return array
   * @throws \CiviCRM_API3_Exception
   */
  public static function getZapOptions() {
    return [
      'create_contact' => 'Create Contact',
      'update_participant' => 'Update Participant',
      'membership_created' => 'Create Membership',
    ];
  }

  /**
   * Save hook URLs in the database.
   */
  public static function saveHookURL($trigger, $url) {
    $zapHooks = self::getZapHooks();
    if (!empty($zapHooks[$trigger]) && $zapHooks[$trigger] == $url) {
      return;
    }

    $zapHooks[$trigger] = $url;
    Civi::settings()->set('zapierHooks', serialize($zapHooks));
  }

  /**
   * This is called when create contact hook is selected on zapier.
   *
   * The hook is registered in civicrm and is triggerred via civirules.
   */
  public static function registerHooks() {
    $inputJSON = $_GET['body'] ?? file_get_contents('php://input') ?? NULL;

    $input = json_decode($inputJSON, TRUE);

    $trigger = $input['triggers'][0] ?? '';
    if (!empty($input['webhookUrl']) && !empty($trigger)) {
      self::saveHookURL($trigger, $input['webhookUrl']);
    }

  }

  public static function getZapHooks() {
    return self::unserialize_recursive(Civi::settings()->get('zapierHooks'));
  }

  public static function getZapHook($name) {
    $zapHooks = self::getZapHooks();
    return $zapHooks[$name] ?? NULL;
  }

  public static function unserialize_recursive($val) {
    //$pattern = "/.*\{(.*)\}/";
    if(self::is_serialized($val)){
      $val = trim($val);
      $ret = unserialize($val);
      if (is_array($ret)) {
        foreach($ret as &$r) $r = self::unserialize_recursive($r);
      }
      return $ret;
    } elseif (is_array($val)) {
      foreach($val as &$r) $r = self::unserialize_recursive($r);
      return $val;
    } else { return $val; }
  }

  public static function is_serialized($val) {
    if (!is_string($val)) return false;
    if (trim($val) == "") return false;
    $val = trim($val);
    if (preg_match('/^(i|s|a|o|d):.*{/si', $val) > 0) return true;
    return false;
  }


  /**
   *
   * @param $method
   * @param $url
   * @param $data
   */
  public static function triggerZap($method, $url, $data = array()) {
    $curl = curl_init();

    switch ($method) {
      case "POST":
        curl_setopt($curl, CURLOPT_POST, 1);
        if ($data) {
          if (is_array($data)) {
            $data = http_build_query($data);
          }
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        break;

      case "PUT":
        curl_setopt($curl, CURLOPT_PUT, 1);
        break;

      default:
        if ($data)
          $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return json_decode($result);
  }

}