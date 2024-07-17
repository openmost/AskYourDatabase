<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\AskYourDatabase;

use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;
use Piwik\Validators\NotEmpty;

/**
 * Defines Settings for AskYourDatabase.
 *
 * Usage like this:
 * $settings = new SystemSettings();
 * $settings->metric->getValue();
 * $settings->description->getValue();
 */
class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    /** @var Setting */
    public $secretKey;

    /** @var Setting */
    public $name;

    /** @var Setting */
    public $email;

    protected function init()
    {
        $this->secretKey = $this->createSecretKeySetting();
        $this->name = $this->createBrowsersSetting();
        $this->email = $this->createDescriptionSetting();
    }

    private function createSecretKeySetting()
    {
        return $this->makeSetting('secretKey', $default = '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Secret key';
            $field->uiControl = FieldConfig::UI_CONTROL_PASSWORD;
            $field->description = '';
            $field->validators[] = new NotEmpty();
        });
    }

    private function createBrowsersSetting()
    {
        return $this->makeSetting('name', $default = '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Name';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = '';
            $field->validators[] = new NotEmpty();
        });
    }

    private function createDescriptionSetting()
    {
        return $this->makeSetting('email', $default = '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Email';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = '';
            $field->validators[] = new NotEmpty();
        });
    }
}
