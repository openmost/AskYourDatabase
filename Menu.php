<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\AskYourDatabase;

use Piwik\Menu\MenuTop;
use Piwik\Piwik;

class Menu extends \Piwik\Plugin\Menu
{
    public function configureTopMenu(MenuTop $menu)
    {
        // The chatbot can read the connected database: super users only.
        // Displayed even when not configured, the page explains how to configure it.
        if (Piwik::hasUserSuperUserAccess()) {
            $menu->addItem('AskYourDatabase', null, $this->urlForDefaultAction(), 30);
        }
    }
}
