<?php

namespace KyleMassacre\Menus\Tests;

use KyleMassacre\Menus\MenusServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class BaseTestCase extends OrchestraTestCase
{
    public function setUp() : void
    {
        parent::setUp();

        // $this->setUpDatabase();
    }

    protected function getPackageProviders($app): array
    {
        return [
            MenusServiceProvider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('menus', [
            'styles' => [
                'navbar' => \KyleMassacre\Menus\Presenters\Bootstrap\NavbarPresenter::class,
                'navbar-right' => \KyleMassacre\Menus\Presenters\Bootstrap\NavbarRightPresenter::class,
                'nav-pills' => \KyleMassacre\Menus\Presenters\Bootstrap\NavPillsPresenter::class,
                'nav-tab' => \KyleMassacre\Menus\Presenters\Bootstrap\NavTabPresenter::class,
                'sidebar' => \KyleMassacre\Menus\Presenters\Bootstrap\SidebarMenuPresenter::class,
                'navmenu' => \KyleMassacre\Menus\Presenters\Bootstrap\NavMenuPresenter::class,
            ],

            'ordering' => false,
        ]);
    }
}
