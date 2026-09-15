<?php

return [
    \Piwik\View\SecurityPolicy::class => \Piwik\DI::decorate(function ($previous) {
        /** @var \Piwik\View\SecurityPolicy $previous */

        if (!\Piwik\SettingsPiwik::isMatomoInstalled()) {
            return $previous;
        }

        // The chatbot is embedded in an iframe
        $previous->addPolicy('frame-src', \Piwik\Plugins\AskYourDatabase\SessionClient::ORIGIN);
        return $previous;
    }),
];
