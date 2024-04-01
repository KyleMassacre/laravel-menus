<?php

return [

    'styles' => [
        'navbar' => \KyleMassacre\Menus\Presenters\Bootstrap\NavbarPresenter::class,
        'navbar-right' => \KyleMassacre\Menus\Presenters\Bootstrap\NavbarRightPresenter::class,
        'nav-pills' => \KyleMassacre\Menus\Presenters\Bootstrap\NavPillsPresenter::class,
        'nav-tab' => \KyleMassacre\Menus\Presenters\Bootstrap\NavTabPresenter::class,
        'sidebar' => \KyleMassacre\Menus\Presenters\Bootstrap\SidebarMenuPresenter::class,
        'navmenu' => \KyleMassacre\Menus\Presenters\Bootstrap\NavMenuPresenter::class,
        'adminlte' => \KyleMassacre\Menus\Presenters\Admin\AdminltePresenter::class,
        'zurbmenu' => \KyleMassacre\Menus\Presenters\Foundation\ZurbMenuPresenter::class,
        'metronic' => \KyleMassacre\Menus\Presenters\Metronic\MetronicHorizontalMenuPresenter::class,
    ],

    'ordering' => false,

];
