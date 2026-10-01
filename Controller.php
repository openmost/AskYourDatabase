<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\AskYourDatabase;

use Piwik\Piwik;
use Piwik\Url;

class Controller extends \Piwik\Plugin\Controller
{
    public function index()
    {
        Piwik::checkUserHasSuperUserAccess();

        $settings = new SystemSettings();

        return $this->renderTemplate('index', [
            'isConfigured' => $settings->isConfigured(),
            'settingsUrl' => 'index.php' . Url::getCurrentQueryStringWithParametersModified([
                'module' => 'CoreAdminHome',
                'action' => 'generalSettings',
            ]) . '#/AskYourDatabase',
        ]);
    }
}
