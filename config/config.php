<?php

return array(
    \Piwik\View\SecurityPolicy::class => \Piwik\DI::decorate(function ($previous) {
        /** @var \Piwik\View\SecurityPolicy $previous */

        if (!\Piwik\SettingsPiwik::isMatomoInstalled()) {
            return $previous;
        }

        $previous->addPolicy('frame-src', 'www.askyourdatabase.com');
        return $previous;
    }),
);
