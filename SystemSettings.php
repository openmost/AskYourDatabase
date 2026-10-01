<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\AskYourDatabase;

use Piwik\Piwik;
use Piwik\Settings\FieldConfig;
use Piwik\Settings\Setting;
use Piwik\Validators\Email;
use Piwik\Validators\NotEmpty;

class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    /** @var Setting */
    public $apiKey;

    /** @var Setting */
    public $chatbotId;

    /** @var Setting */
    public $name;

    /** @var Setting */
    public $email;

    protected function init()
    {
        $this->apiKey = $this->makeSetting('apiKey', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('AskYourDatabase_ApiKey');
            $field->uiControl = FieldConfig::UI_CONTROL_PASSWORD;
            $field->description = Piwik::translate('AskYourDatabase_ApiKeyDescription');
            $field->validators[] = new NotEmpty();
            $field->transform = function ($value) {
                return trim((string) $value);
            };
        });

        $this->chatbotId = $this->makeSetting('chatbotId', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('AskYourDatabase_ChatbotId');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = Piwik::translate('AskYourDatabase_ChatbotIdDescription');
            $field->validators[] = new NotEmpty();
            $field->validate = function ($value) {
                if (!preg_match('/^[A-Za-z0-9_-]+$/', self::extractChatbotId((string) $value))) {
                    throw new \Exception(Piwik::translate('AskYourDatabase_ChatbotIdInvalid'));
                }
            };
            $field->transform = function ($value) {
                return self::extractChatbotId((string) $value);
            };
        });

        $this->name = $this->makeSetting('name', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('AskYourDatabase_UserName');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = Piwik::translate('AskYourDatabase_UserNameDescription');
        });

        $this->email = $this->makeSetting('email', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('AskYourDatabase_UserEmail');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = Piwik::translate('AskYourDatabase_UserEmailDescription');
            $field->validators[] = new Email();
        });
    }

    public function isConfigured(): bool
    {
        return trim((string) $this->apiKey->getValue()) !== '' && $this->getChatbotId() !== '';
    }

    public function getChatbotId(): string
    {
        return self::extractChatbotId((string) $this->chatbotId->getValue());
    }

    /**
     * Accepts the chatbot ID or the chatbot URL copied from the AskYourDatabase dashboard
     */
    public static function extractChatbotId(string $value): string
    {
        $value = trim($value);

        if (preg_match('~/chatbot/([A-Za-z0-9_-]+)~', $value, $matches)) {
            return $matches[1];
        }

        return $value;
    }
}
