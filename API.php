<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\AskYourDatabase;

use Piwik\Piwik;

/**
 * API for plugin AskYourDatabase
 *
 * @method static \Piwik\Plugins\AskYourDatabase\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    /**
     * Creates an AskYourDatabase chatbot session for the current user.
     *
     * The chatbot can read the connected database, only super users can open it.
     *
     * @return array{url: string} one-time URL to open in the chatbot iframe
     */
    public function createSession(): array
    {
        Piwik::checkUserHasSuperUserAccess();

        $settings = new SystemSettings();
        if (!$settings->isConfigured()) {
            throw new \Exception(Piwik::translate('AskYourDatabase_NotConfigured'));
        }

        $name = trim((string) $settings->name->getValue());
        $email = trim((string) $settings->email->getValue());

        try {
            $url = (new SessionClient())->createSession(
                trim((string) $settings->apiKey->getValue()),
                $settings->getChatbotId(),
                $name !== '' ? $name : Piwik::getCurrentUserLogin(),
                $email !== '' ? $email : (string) Piwik::getCurrentUserEmail()
            );
        } catch (\Exception $e) {
            // not chained: the message already contains the cause, and the chain would be displayed to the user
            throw new \Exception(Piwik::translate('AskYourDatabase_SessionError', [$e->getMessage()]));
        }

        return ['url' => $url];
    }
}
