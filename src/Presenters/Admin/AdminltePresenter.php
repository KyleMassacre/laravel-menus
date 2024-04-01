<?php

namespace KyleMassacre\Menus\Presenters\Admin;

use KyleMassacre\Menus\Contracts\MenuItemContract;
use KyleMassacre\Menus\Presenters\Presenter;

class AdminltePresenter extends Presenter
{
    /**
     * {@inheritdoc}
     */
    public function getOpenTagWrapper(): ?string
    {
        return PHP_EOL . '<ul class="sidebar-menu tree" data-widget="tree">' . PHP_EOL;
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
        return '<li' . $this->getActiveState($item) . '><a href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>' . $item->getIcon() . ' <span>' . $item->title . '</span></a></li>' . PHP_EOL;
    }

    /**
     * {@inheritdoc}.
     */
    public function getActiveState(MenuItemContract $item, $state = ' class="active"'): mixed
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
        return '<li class="header">' . $item->title . '</li>';
    }

    /**
     * {@inheritdoc}.
     */
    public function getMenuWithDropDownWrapper(MenuItemContract $item): ?string
    {
        return '<li class="treeview' . $this->getActiveStateOnChild($item, ' active') . '">
		          <a href="#">
					' . $item->getIcon() . ' <span>' . $item->title . '</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
			      </a>
			      <ul class="treeview-menu">
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
        return '<li class="treeview' . $this->getActiveStateOnChild($item, ' active') . '">
		          <a href="#">
					' . $item->getIcon() . ' <span>' . $item->title . '</span>
			      	<span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
			      </a>
			      <ul class="treeview-menu">
			      	' . $this->getChildMenuItems($item) . '
			      </ul>
		      	</li>'
        . PHP_EOL;
    }
}
