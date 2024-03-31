<?php

namespace KyleMassacre\Menus\Presenters\Bootstrap;

use Illuminate\Support\Str;
use KyleMassacre\Menus\Contracts\MenuItemContract;
use KyleMassacre\Menus\Presenters\Presenter;

class SidebarMenuPresenter extends Presenter
{
    /**
     * Get open tag wrapper.
     *
     * @return string
     */
    public function getOpenTagWrapper(): ?string
    {
        return '<ul class="nav navbar-nav">';
    }

    /**
     * Get close tag wrapper.
     *
     * @return string
     */
    public function getCloseTagWrapper(): ?string
    {
        return '</ul>';
    }

    /**
     * Get menu tag without dropdown wrapper.
     *
     * @param MenuItemContract $item
     *
     * @return string
     */
    public function getMenuWithoutDropdownWrapper(MenuItemContract $item): ?string
    {
        return '<li' . $this->getActiveState($item) . '>
			<a href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>'
        . $item->getIcon() . ' ' . $item->title . '</a></li>' . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveState(MenuItemContract $item, string $state = ' class="active"'): mixed
    {
        return $item->isActive() ? $state : null;
    }

    /**
     * Get active state on child items.
     *
     * @param MenuItemContract $item
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
        $id = Str::random();

        return '
		<li class="' . $this->getActiveStateOnChild($item) . ' panel panel-default" id="dropdown">
			<a data-toggle="collapse" href="#' . $id . '">
				' . $item->getIcon() . ' ' . $item->title . ' <span class="caret"></span>
			</a>
			<div id="' . $id . '" class="panel-collapse collapse ' . $this->getActiveStateOnChild($item, 'in') . '">
				<div class="panel-body">
					<ul class="nav navbar-nav">
						' . $this->getChildMenuItems($item) . '
					</ul>
				</div>
			</div>
		</li>
		' . PHP_EOL;
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
        return $this->getMenuWithDropDownWrapper($item);
    }
}
