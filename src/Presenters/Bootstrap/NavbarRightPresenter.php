<?php

namespace KyleMassacre\Menus\Presenters\Bootstrap;

use KyleMassacre\Menus\Contracts\MenuItemContract;

class NavbarRightPresenter extends NavbarPresenter
{
    /**
     * {@inheritdoc}
     */
    public function getOpenTagWrapper(): ?string
    {
        return PHP_EOL . '<ul class="nav navbar-nav navbar-right">' . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuWithDropDownWrapper(MenuItemContract $item): ?string
    {
        return '<li class="dropdown pull-right">
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
}
