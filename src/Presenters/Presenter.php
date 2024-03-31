<?php

namespace KyleMassacre\Menus\Presenters;

use KyleMassacre\Menus\Contracts\MenuItemContract;

abstract class Presenter implements PresenterInterface
{
    /**
     * Get open tag wrapper.
     *
     * @return string
     */
    public function getOpenTagWrapper(): ?string
    {
    }

    /**
     * Get close tag wrapper.
     *
     * @return string
     */
    public function getCloseTagWrapper(): ?string
    {
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
    }

    /**
     * Get divider tag wrapper.
     *
     * @return string
     */
    public function getDividerWrapper(): ?string
    {
    }

    /**
     * Get header dropdown tag wrapper.
     *
     * @param MenuItemContract $item
     *
     * @return null|string
     */
    public function getHeaderWrapper(MenuItemContract $item): ?string
    {
    }

    /**
     * Get menu tag with dropdown wrapper.
     *
     * @param \KyleMassacre\Menus\MenuItem $item
     *
     * @return string
     */
    public function getMenuWithDropDownWrapper(MenuItemContract $item): ?string
    {
    }

    /**
     * Get multi level dropdown menu wrapper.
     *
     * @param \KyleMassacre\Menus\MenuItem $item
     *
     * @return string
     */
    public function getMultiLevelDropdownWrapper(MenuItemContract $item): string
    {
    }

    /**
     * Get child menu items.
     *
     * @param \KyleMassacre\Menus\MenuItem $item
     *
     * @return string
     */
    public function getChildMenuItems(MenuItemContract $item): string
    {
        $results = '';
        foreach ($item->getChildren() as $child) {
            if ($child->hidden()) {
                continue;
            }

            if ($child->hasSubMenu()) {
                $results .= $this->getMultiLevelDropdownWrapper($child);
            } elseif ($child->isHeader()) {
                $results .= $this->getHeaderWrapper($child);
            } elseif ($child->isDivider()) {
                $results .= $this->getDividerWrapper();
            } else {
                $results .= $this->getMenuWithoutDropdownWrapper($child);
            }
        }

        return $results;
    }
}
