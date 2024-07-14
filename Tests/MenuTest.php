<?php

namespace KyleMassacre\Menus\Tests;

use KyleMassacre\Menus\Menu;
use KyleMassacre\Menus\MenuBuilder;
use PHPUnit\Framework\Attributes\Test;

class MenuTest extends BaseTestCase
{
    /**
     * @var Menu
     */
    private $menu;

    public function setUp() : void
    {
        parent::setUp();
        $this->menu = app(Menu::class);
    }

    #[Test]
    public function it_generates_an_empty_menu(): void
    {
        $this->menu->create('test', function (MenuBuilder $menu) {
        });

        $expected = <<<TEXT

<ul class="nav navbar-nav">

</ul>

TEXT;

        self::assertEquals($expected, $this->menu->get('test'));
    }

    #[Test]
    public function it_makes_is_an_alias_for_create(): void
    {
        $this->menu->make('test', function (MenuBuilder $menu) {
        });

        $expected = <<<TEXT

<ul class="nav navbar-nav">

</ul>

TEXT;

        self::assertEquals($expected, $this->menu->get('test'));
    }

    #[Test]
    public function it_render_is_an_alias_of_get(): void
    {
        $this->menu->make('test', function (MenuBuilder $menu) {
        });

        $expected = <<<TEXT

<ul class="nav navbar-nav">

</ul>

TEXT;

        self::assertEquals($expected, $this->menu->render('test'));
    }

    #[Test]
    public function it_can_get_the_instance_of_a_menu(): void
    {
        $this->menu->create('test', function (MenuBuilder $menu) {
        });

        $this->assertInstanceOf(MenuBuilder::class, $this->menu->instance('test'));
    }

    #[Test]
    public function it_can_modify_a_menu_instance(): void
    {
        $this->menu->create('test', function (MenuBuilder $menu) {
        });

        $this->menu->modify('test', function (MenuBuilder $builder) {
            $builder->url('hello', 'world');
        });

        $this->assertCount(1, $this->menu->instance('test'));
    }

    #[Test]
    public function it_gets_a_partial_for_dropdown_styles(): void
    {
        $this->menu->create('test', function (MenuBuilder $menu) {
        });

        $this->assertStringContainsString('.dropdown-submenu', $this->menu->style());
    }

    #[Test]
    public function it_can_get_all_menus(): void
    {
        $this->menu->create('main', function (MenuBuilder $menu) {
        });
        $this->menu->create('footer', function (MenuBuilder $menu) {
        });

        $this->assertCount(2, $this->menu->all());
    }

    #[Test]
    public function it_can_count_menus(): void
    {
        $this->menu->create('main', function (MenuBuilder $menu) {
        });
        $this->menu->create('footer', function (MenuBuilder $menu) {
        });

        $this->assertEquals(2, $this->menu->count());
    }

    #[Test]
    public function it_can_destroy_all_menus(): void
    {
        $this->menu->create('main', function (MenuBuilder $menu) {
        });
        $this->menu->create('footer', function (MenuBuilder $menu) {
        });

        $this->assertCount(2, $this->menu->all());
        $this->menu->destroy();
        $this->assertCount(0, $this->menu->all());
    }

    #[Test]
    public function it_still_generates_empty_menu_after_adding_dropdown(): void
    {
        $this->menu->create('test', function (MenuBuilder $menu) {
            $menu->dropdown('Test', function ($sub) {

            })->hideWhen(function () {
                return true;
            });
        });

        $expected = <<<TEXT

<ul class="nav navbar-nav">

</ul>

TEXT;

        self::assertEquals($expected, $this->menu->get('test'));
    }

    #[Test]
    public function it_still_generates_empty_menu_after_adding_item(): void
    {
        $this->menu->create('test', function (MenuBuilder $menu) {
            $menu->url('/', 'Test')
                ->hideWhen(function () {
                    return true;
                });
        });

        $expected = <<<TEXT

<ul class="nav navbar-nav">

</ul>

TEXT;

        self::assertEquals($expected, $this->menu->get('test'));
    }
}
