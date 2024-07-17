<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\AskYourDatabase;

use Piwik\Archive;
use Piwik\DataTable;
use Piwik\Piwik;
use Piwik\Segment;

/**
 * API for plugin AskYourDatabase
 *
 * @method static \Piwik\Plugins\AskYourDatabase\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    public function getIframeUrl(bool $truth = true)
    {
        Piwik::checkUserHasSuperUserAccess();

        $url = "https://www.askyourdatabase.com/api/chatbot/session";

        $systemSettings = new SystemSettings();
        $data = [
            "secretKey" => $systemSettings->secretKey->getValue(),
            "name" => $systemSettings->name->getValue(),
            "email" => $systemSettings->email->getValue(),
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Accept-Language' => 'en',
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Send data as JSON
        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, true);
    }
}
