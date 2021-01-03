<?php

if (!defined('ABSPATH'))
   exit;

include_once ( plugin_dir_path(__FILE__) . 'vendor/autoload.php' );

class cfgooglesheet {
    private $client;

    public function __construct() {
        $this->client = new Google_Client();
        $this->client->setApplicationName('Google Sheets Integration for Caldera Forms');
        $this->client->setClientId(get_option('gs2_client_id', ''));
        $this->client->setClientSecret(get_option('gs2_client_secret', ''));
        $this->client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
        $this->client->setScopes(Google_Service_Sheets::SPREADSHEETS);
        $this->client->setAccessType('offline');
    }

    public function authUrl() {
        return $this->client->createAuthUrl();        
    }

    public function auth($accessCode) {
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($accessCode);
        if (array_key_exists('error', $accessToken)) {
            update_option('gs2_token_v4', '');
            throw new Exception(join(', ', $accessToken));
        }
        if (!array_key_exists('access_token', $accessToken)) {
            update_option('gs2_token_v4', '');
            throw new Exception("Can't get access token");
        }
        $this->client->setAccessToken($accessToken);
        update_option('gs2_token_v4', json_encode($accessToken));
        delete_option('gs2_token');
        delete_option('gs_token');
    }

    public function refreshToken() {
        if (get_option('gs2_token_v4', '') != '') {
            $accessToken = json_decode(get_option('gs2_token_v4'), true);
        } else {
            throw new Exception("Plugin is not connected to Google Sheets"); 
        }

        $this->client->setAccessToken($accessToken);
        if ($this->client->isAccessTokenExpired()) {
            $refresh_token = $this->client->getRefreshToken();
            if ($refresh_token) {
                $accessToken = $this->client->fetchAccessTokenWithRefreshToken($refresh_token);
                if (!array_key_exists('refresh_token', $accessToken)) {
                    $accessToken['refresh_token'] = $refresh_token;
                }
                $this->client->setAccessToken($accessToken);
                update_option('gs2_token_v4', json_encode($accessToken));
            } else {
                update_option('gs2_token_v4', '');
                throw new Exception("Can't get refresh token"); 
            }
        }
    }

    public function add_row($data, $spreadsheetId, $tab, $auto = true) {
        $this->refreshToken();
        $service = new Google_Service_Sheets($this->client);

        $response = $service->spreadsheets_values->get($spreadsheetId, $tab . "!1:1");
        $range = $response->getValues();
        if (isset($range[0])) {
            $header = $range[0];
        } else {
            $header = [];
        }

        if ($auto) {
            $headerUpdate = false;
			foreach ($data as $name => $value) {
                if (!in_array($name, $header)) {
                    $header[] = $name;
                    $headerUpdate = true;
                } 
            }

            if ($headerUpdate) {
                $headerRange = new Google_Service_Sheets_ValueRange();
                $headerRange->setValues(["values" => $header]);
                $conf = ["valueInputOption" => "RAW"];
                $service->spreadsheets_values->update($spreadsheetId, $tab . "!1:1", $headerRange, $conf);
            }            
        }
        
        $values = array();
        foreach ($header as $name) {
            if (isset($data[$name]) && $data[$name] != '') {
                if (is_string($data[$name]) && (substr($data[$name], 0, 1) === "=")) {
                    $values[] = "'" . $data[$name];
                } else {
                    $values[] = $data[$name];
                }
            } else {
                $values[] = '';
            }
        }

        $valueRange = new Google_Service_Sheets_ValueRange();
        $valueRange->setValues(["values" => $values]);
        $conf = ["valueInputOption" => "USER_ENTERED", "insertDataOption" => "INSERT_ROWS"];

        $response = $service->spreadsheets_values->get($spreadsheetId, $tab . "!A1:D10000");
        if (!empty($response["values"])) {
            $range = "A" . strval(count($response["values"]) + 1);
        } else {
            $range = "A1";
        }

        $service->spreadsheets_values->append($spreadsheetId, $tab . "!" . $range, $valueRange, $conf);
    }
}
?>
