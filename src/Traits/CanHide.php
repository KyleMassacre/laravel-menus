<?php

namespace KyleMassacre\Menus\Traits;

use Closure;

trait CanHide
{
    /**
     * @var Closure
     */
    protected Closure $hideWhen;

    /**
     * Set hide condition for current menu item.
     *
     * @param  Closure
     * @return self
     */
    public function hideWhen(Closure $callback): self
    {
        $this->hideWhen = $callback;

        return $this;
    }

    /**
     * Determine whether the menu item is hidden.
     *
     * @return boolean
     */
    public function hidden(): bool
    {
        if (is_null($this->hideWhen)) {
            return false;
        }

        return call_user_func($this->hideWhen) == true;
    }
}
