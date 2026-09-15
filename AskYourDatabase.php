<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\AskYourDatabase;

class AskYourDatabase extends \Piwik\Plugin
{
    public function registerEvents()
    {
        return [
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
        ];
    }

    public function getClientSideTranslationKeys(&$translationKeys)
    {
        $translationKeys[] = 'AskYourDatabase_NotConfigured';
        $translationKeys[] = 'AskYourDatabase_NotConfiguredDescription';
        $translationKeys[] = 'AskYourDatabase_NotConfiguredNoAccount';
        $translationKeys[] = 'AskYourDatabase_GoToSettings';
        $translationKeys[] = 'AskYourDatabase_Retry';
        $translationKeys[] = 'AskYourDatabase_Loading';
        $translationKeys[] = 'AskYourDatabase_ChatbotFrameTitle';
    }
}
