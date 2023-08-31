# CiviCRM Zapier Integration (nz.co.fuzion.zapier)

Triggers a zap configured on zapier.com from civicrm

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.0+
* CiviCRM 5.19+

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl nz.co.fuzion.zapier@https://github.com/FIXME/nz.co.fuzion.zapier/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/FIXME/nz.co.fuzion.zapier.git
cv en zapier
```

## Usage

### Create a new CiviCRM Zap on Zapier.com
- Log in to your Zapier.com (not platform.zapier.com) account.
- Create a zap from the menu on the left, with Event = CiviCRM.
- Choose Event = New Contact
- In the CiviCRM account field, setup a new account for your site as mentioned below.

- #### Connect your site account on Zapier.
    - Website Base URL = your site base url Eg http:://www.example.com
    - Api Key = api key of the permissioned cms contact. To make a new api key see: https://docs.civicrm.org/sysadmin/en/latest/setup/api-keys/
        note: zapier only accepts keys of 30 characters or less.
    - Key = CiviCRM site key found in civicrm.settings.php.

- When you view the zap - a hook URL is displayed. This is added to your civicrm extension settings. This hook can be viewed at `Administer => Zapier Hooks` menu page on your civicrm site.

![Screenshot](/images/connect_civicrm_on_zapier.jpg)

- Setup an action for a third party app, Eg insert a row in the Google sheet. A fully configured zap should be displayed like -

![Screenshot](/images/zap.jpg)

### On your civicrm site
- Create a civirule that triggers on “Individual is added”.
- In the Linked Action(s) section, Add an action with value = `Trigger Zap` and click save.
- On the next page, set “Select triggering Zap” = “Create Contact” => Save.

Now, when a contact is created in civicrm, the civirule is triggered which further triggers the zap on zapier.com to process the third-party app action.

Test by creating an individual contact on your site.
