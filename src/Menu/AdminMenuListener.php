<?php

declare(strict_types = 1);

namespace BeHappy\SyliusMailPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();

        $menu->getChild('configuration')
            ->addChild('mail_plugin.menu', [
                'route' => 'behappy_mail_plugin_mail_configuration_index'
            ])
            ->setLabel('behappy_mail_plugin.ui.mails')
            ->setLabelAttribute('icon', 'mail');
    }
}