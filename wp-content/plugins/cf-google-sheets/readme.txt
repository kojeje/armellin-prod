=== Google Sheets Integration for Caldera Forms ===
Contributors: alexagr
Donate link: https://paypal.me/alexagr
Tags: Caldera Forms, Google Sheets, Google, Sheets
Requires at least: 3.6
Tested up to: 5.4.2
Stable tag: 2.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Send your Caldera Forms data directly to your Google Sheets spreadsheet.

== Description ==

This plugin provides integration between [Caldera Forms](https://wordpress.org/plugins/caldera-forms/) and [Google Sheets](https://www.google.com/sheets/).
It adds new processor to Caldera Forms that enables sending of submitted forms to Google Sheets.  

= Upgrade Instructions =  

> Version 2.x of the plugin introduced some non-backward compatible changes. Follow the below instructions if you are upgrading from plugin version 1.x to 2.x.  

Version 1.x of the plugin used [Google Sheets API v3](https://developers.google.com/sheets/api/v3) that is shut down by Google.
Version 2.x of the plugin switched to the latest [Google Sheets API v4](https://developers.google.com/sheets/api).

Due to this change you MUST do the following after upgrading from version 1.x to 2.x:

* generate your own OAuth2 credentials (if you didn't do that before) and enter them in plugin **Settings** screen
* re-connect plugin to Google Sheets by going to plugin **Settings** screen, clicking "Get Code", going through the Google authorization pages, copy/pasting the generated Access Code and clicking "Save"
* in all your Caldera Forms that use Google Sheets processor, update processor configuration to use Sheet ID (instead of Sheet Name); Sheet ID may be retrieved from your Sheet's URL - e.g. for URL https://docs.google.com/spreadsheets/d/abc123456/edit#gid=0 the Sheet ID is "abc123456"

= Connecting the Plugin to Google Sheets =

After installing the plugin you must connect it to Google Sheets as described below.

*Generating OAuth2 credentials*  

The simplest way to generate OAuth2 credentials is as follows:

* Open the [Google Sheets API PHP Quickstart](https://developers.google.com/sheets/api/quickstart/php) page
* Click **Enable the Google Sheets API** button in Step 1
* If asked, enter project name and confirm that your use of Google APIs is in compliance with Tems of Service
* On the page that appears, your OAuth2 "client ID" and "client secret" are displayed. Leave this page open, so that you can copy/paste values from it to the plugin configuration. Alternatively, copy the values to some clipboard. 

If the above method doesn't work for you, use the following procedure to generate OAuth2 credentials manually. Refer to [screencast](https://youtu.be/wUY8Owt5zwc) for visual assistance.

* Open the [Google API Library](https://console.developers.google.com/apis/library)
* Click **Select a project**, then **NEW PROJECT**, enter a name for the project - e.g. "CalderaFormsGoogleSheets" - and click **Create**.
* Make sure that created project is selected.
* Search for "sheets" and click on **Google Sheets API**. Click **ENABLE**.
* Open the [Google API Console Credentials page](https://console.developers.google.com/apis/credentials)
* On the **OAuth consent screen**:
  * For **User Type** select **External** and click **CREATE**
  * For **Application Name** enter "Google Sheets Integration for Caldera Forms"
  * For **Scopes for Google APIs** click **Add Scope**, select **../auth/spreadsheets** scope and click **ADD**
  * Click **Save**
* On the **Credentials** screen, select **Create credentials**, then **OAuth client ID**
  * For **Application type** select **Desktop app** 
  * For **Name** enter "Google Sheets Integration for Caldera Forms"
  * Click **Create**
* On the page that appears, your OAuth2 "client ID" and "client secret" are displayed. Leave this page open, so that you can copy/paste values from it to the plugin configuration. Alternatively, copy the values to some clipboard. 

*Authorizing plugin acess to Google Sheets*  

After generating OAuth2 credentials, use the following procedure to authorize plugin access to Google Sheets. Refer to [screencast](https://youtu.be/rixQf4rFgiY) for visual assistance.

* Open a new page and go to plugin **Settings** screen (or to **Admin Panel > Caldera Forms > Google Sheets** screen)
* For **Google OAuth2 Client ID** paste "client ID" from Google OAuth2 Credentials page 
* For **Google OAuth2 Secret** paste "client secret" from Google OAuth2 Credentials page
* Click **Get Code** button - you will be redirected to Google Sheets authorization page
* You will see **This app isn't verified** screen - this is OK, because you are authenticating your own site
  * Click **Advanced** and then click **Go to Google Sheets Integration for Caldera Forms (unsafe)**
* In the **Grant Google Sheets Integration for Caldera Forms permission** screen click **Allow**
* In the **Confirm your choices** screen click **Allow**
* Copy generated "access code" to the clipboard
* Paste "access code" into the **Google Access Code** in plugin **Settings** screen
* Click **Save**

= Using the Plugin =

After successfully connecting the plugin to Google Sheets, do the following to configure your Caldera Form to send data to Google Sheets on form submission. Refer to [screencast](https://youtu.be/HwfN-lfTqvs) for visual assistance.

*In Google Sheets*  

* Create a new Google Sheet
* Determine Sheet ID from the sheet's URL - for example, in URL https://docs.google.com/spreadsheets/d/abc123456/edit#gid=0 the Sheet ID is "abc123456"
* Name the tab where you want to capture the data with some simple name that doesn't include space and/or special characters - e.g. "Sheet1" or "InputData"

If you wish to record all of your Caldera Form fields, proceed to the next step and enable "Automatically generate header" option in processor settings.

If you wish to record only selected fields create custom spreadsheet header in the first row as follows:

* Enter "id" in the the first column
* Enter "date" in the the second column
* Enter slug names of your Caldera Form fields (that you want to record) in the following columns

*In Caldera Forms*  

* Add Google Sheets processor to your form
* Configure the Sheet ID and Tab name
* It is recommended to enable "Automatically generate header" checkbox, unless you created custom spreadsheet header in the previous step
* Click "Save Form" to save processor settings
* Submit a test form and verify that the data shows up in your Google Sheet

= Automatic Header Generation = 

When "automatic header generation" is enabled, the plugin verifies spreadsheet header on each new form submission and adds new fields to it if needed. Note that it never deletes fields from the header - as this would also delete some submission data - though you can do it manually. You may also manually reorder columns as you wish.

= Slug Names = 

* Your slug names should contain only the following characters:
  * english letters "[A-Za-z]"
  * digits "[0-9]"
  * dash "-"
  * underscore "_"
* If your slug names contain capital letters, replace them with lowercase letters in Google Sheet header - e.g. for "SURNAME" slug use "surname" header
* If your slug names contain underscores, replace them with dashes in Google Sheet header - e.g. for "name_english" slug use "name-english" header

= Acknowledgements =

The initial version of the plugin was based on [CF7 Google Sheets Connector](https://wordpress.org/plugins/cf7-google-sheets-connector/)

== Screenshots ==

1. Connecting plugin to Google Sheets
2. Adding Google Sheets processor in Caldera Forms

== Installation ==

1. Upload "cf-google-sheets" to the "/wp-content/plugins/" directory
2. Activate the plugin through the **Plugins** screen in WordPress  

== Frequently Asked Questions ==

= Why isn't the data sent to spreadsheet? Caldera Forms Submit is just Spinning. =

Sometimes it can take a while of spinning before it goes through. But if the entries never show up in your Google Sheet use the following checklist:

* Check that plugin is properly connected to Google Sheets (connection status in plugin **Settings** screen should be CONNECTED)
* In Google Sheets processor configuration screen for your form:
  * Check that you entered correct Sheet ID (obtained from the sheet's URL - and NOT the Sheet Name)
  * Check that you entered correct Tab Name
  * It is recommended to enable "Automatic header generation"; otherwise check that your sheet's 1st row contains header that matches form's slugs
* Check Debug Log in plugin **Settings** screen for detailed error trace 

== Changelog ==

= 2.5 =
* Fix shift in added rows that sometimes happened

= 2.4 =
* Update dependencies to prevent incompatibility with other plugins

= 2.3 =
* Fix format of non-string fields

= 2.2 =
* Fix submission into empty Sheet

= 2.1 =
* Switch to Google Sheets API v4
* Use "Sheet ID" in preprocessor configuration instead of "Sheet Name"

= 2.0 =
* Bad SVN checkin - don't use this version

= 1.8 =
* Bug fixes

= 1.7 =
* New plugin activation scheme using private OAuth2 credentials

= 1.6 =
* Update tested WordPress version

= 1.5 =
* Prevent fatal error when Caldera Forms is removed

= 1.4 =
* Added support for automatic spreadsheet header generation

= 1.3 =
* Added support for "id" column that records entry id

= 1.2 =
* Refactor Google PHP API lib to prevent "clash" with other plugins

= 1.1 =
* Bug fixes

= 1.0 =
* Initial version

