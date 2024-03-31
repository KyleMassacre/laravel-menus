<?php

namespace KyleMassacre\Menus\Presenters\Bootstrap;

use KyleMassacre\Menus\Contracts\MenuItemContract;
use KyleMassacre\Menus\Presenters\Presenter;

class NavbarPresenter extends Presenter
{
    /**
     * {@inheritdoc}
     */
    public function getOpenTagWrapper(): ?string
    {
        return PHP_EOL . '<ul class="nav navbar-nav">' . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function getCloseTagWrapper(): ?string
    {
        return PHP_EOL . '</ul>' . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuWithoutDropdownWrapper(MenuItemContract $item): ?string
    {
        return '<li' . $this->getActiveState($item) . '><a href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>' . $item->getIcon() . ' ' . $item->title . '</a></li>' . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveState(MenuItemContract $item, string $state = ' class="active"'): ?string
    {
        return $item->isActive() ? $state : null;
    }

    /**
     * Get active state on child items.
     *
     * @param $item
     * @param string $state
     *
     * @return null|string
     */
    public function getActiveStateOnChild(MenuItemContract $item, string $state = 'active'): ?string
    {
        return $item->hasActiveOnChild() ? $state : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getDividerWrapper(): ?string
    {
        return '<li class="divider"></li>';
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderWrapper(MenuItemContract $item): ?string
    {
        return '<li class="dropdown-header">' . $item->title . '</li>';
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuWithDropDownWrapper(MenuItemContract $item): ?string
    {
        return '<li class="dropdown' . $this->getActiveStateOnChild($item, ' active') . '">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					' . $item->getIcon() . ' ' . $item->title . '
			      	<b class="caret"></b>
			      </a>
			      <ul class="dropdown-menu">
			      	' . $this->getChildMenuItems($item) . '
			      </ul>
		      	</li>'
        . PHP_EOL;
    }

    /**
     * Get multilevel menu wrapper.
     *
     * @param MenuItemContract $item
     *
     * @return string
     */
    public function getMultiLevelDropdownWrapper(MenuItemContract $item): string
    {
        return '<li class="dropdown' . $this->getActiveStateOnChild($item, ' active') . '">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					' . $item->getIcon() . ' ' . $item->title . '
			      	<b class="caret pull-right caret-right"></b>
			      </a>
			      <ul class="dropdown-menu">
			      	' . $this->getChildMenuItems($item) . '
			      </ul>
		      	</li>'
        . PHP_EOL;
    }
}
