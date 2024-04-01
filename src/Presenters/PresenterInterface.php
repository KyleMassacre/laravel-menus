<?php

namespace KyleMassacre\Menus\Presenters;

use KyleMassacre\Menus\Contracts\MenuItemContract;

interface PresenterInterface
{
    /**
     * Get open tag wrapper.
     *
     * @return string|null
     */
    public function getOpenTagWrapper(): ?string;

    /**
     * Get close tag wrapper.
     *
     * @return string|null
     */
    public function getCloseTagWrapper(): ?string;

    /**
     * Get menu tag without dropdown wrapper.
     *
     * @param MenuItemContract $item
     *
     * @return string|null
     */
    public function getMenuWithoutDropdownWrapper(MenuItemContract $item): ?string;

    /**
     * Get divider tag wrapper.
     *
     * @return string|null
     */
    public function getDividerWrapper(): ?string;

    /**
     * Get divider tag wrapper.
     *
     * @param MenuItemContract $item
     *
     * @return string|null
     */
    public function getHeaderWrapper(MenuItemContract $item): ?string;

    /**
     * Get menu tag with dropdown wrapper.
     *
     * @param MenuItemContract $item
     *
     * @return string|null
     */
    public function getMenuWithDropDownWrapper(MenuItemContract $item): ?string;

    /**
     * Get child menu items.
     *
     * @param MenuItemContract $item
     *
     * @return string|null
     */
    public function getChildMenuItems(MenuItemContract $item): ?string;
}
