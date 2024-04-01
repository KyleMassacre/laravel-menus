<?php

namespace KyleMassacre\Menus;

use AllowDynamicProperties;
use Collective\Html\HtmlFacade as HTML;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use KyleMassacre\Menus\Contracts\MenuItemContract;
use KyleMassacre\Menus\Traits\CanHide;

/**
 * @property string url
 * @property string route
 * @property string title
 * @property string name
 * @property string icon
 * @property int parent
 * @property array attributes
 * @property bool active
 * @property int order
 * @property array badge
 */
#[AllowDynamicProperties] class MenuItem extends MenuItemContract
{
    use CanHide;

    /**
     * Constructor.
     *
     * @param array $properties
     */
    public function __construct(array $properties = array())
    {
        $this->properties = $properties;
        $this->fill($properties);
    }

    /**
     * Fill the attributes.
     *
     * @param array $attributes
     */
    public function fill(array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Create new menu child item using array.
     *
     * @param array $attributes
     *
     * @return self
     */
    public function child(array $attributes): self
    {
        $this->childs[] = static::make($attributes);

        return $this;
    }

    /**
     * Register new child menu with dropdown.
     *
     * @param $title
     * @param \Closure $callback
     * @param int $order
     * @param array $attributes
     * @return $this
     */
    public function dropdown(string $title, \Closure $callback, int $order = 0, array $attributes = array()): static
    {
        $properties = compact('title', 'order', 'attributes');

        if (func_num_args() === 3) {
            $arguments = func_get_args();

            $title = Arr::get($arguments, 0);
            $attributes = Arr::get($arguments, 2);

            $properties = compact('title', 'attributes');
        }

        $child = static::make($properties);

        call_user_func($callback, $child);

        $this->childs[] = $child;

        return $child;
    }

    /**
     * Create new menu item and set the action to route.
     *
     * @param $route
     * @param $title
     * @param array $parameters
     * @param array $attributes
     *
     * @return MenuItemContract
     */
    public function route($route, $title, array $parameters = array(), $order = 0, array $attributes = array()): static
    {
        if (func_num_args() === 4) {
            $arguments = func_get_args();

            return $this->add([
                'route' => [Arr::get($arguments, 0), Arr::get($arguments, 2)],
                'title' => Arr::get($arguments, 1),
                'attributes' => Arr::get($arguments, 3),
            ]);
        }

        $route = array($route, $parameters);

        return $this->add(compact('route', 'title', 'order', 'attributes'));
    }

    /**
     * Create new menu item  and set the action to url.
     *
     * @param $url
     * @param $title
     * @param array $attributes
     *
     * @return static
     */
    public function url($url, $title, $order = 0, array $attributes = array()): static
    {
        if (func_num_args() === 3) {
            $arguments = func_get_args();

            return $this->add([
                'url' => Arr::get($arguments, 0),
                'title' => Arr::get($arguments, 1),
                'attributes' => Arr::get($arguments, 2),
            ]);
        }

        return $this->add(compact('url', 'title', 'order', 'attributes'));
    }

    /**
     * Add new divider.
     *
     * @param int $order
     *
     * @return self
     */
    public function addDivider($order = null): static
    {
        $item = static::make(array('name' => 'divider', 'order' => $order));

        $this->childs[] = $item;

        return $item;
    }

    /**
     * Alias method instead "addDivider".
     *
     * @param int $order
     *
     * @return MenuItem
     */
    public function divider($order = null): static
    {
        return $this->addDivider($order);
    }

    /**
     * Add dropdown header.
     *
     * @param $title
     *
     * @return $this
     */
    public function addHeader($title): static
    {
        $item = static::make(array(
            'name' => 'header',
            'title' => $title,
        ));

        $this->childs[] = $item;

        return $item;
    }

    /**
     * Same with "addHeader" method.
     *
     * @param $title
     *
     * @return $this
     */
    public function header($title): static
    {
        return $this->addHeader($title);
    }

    public function addBadge(string $type, $text): static
    {
        $properties = array(
            'type' => $type,
            'text' => $text,
            'name' => 'badge',
        );
        $item = static::make($properties);
        $this->badge = $properties;

        return $item;
    }

    /**
     * @deprecated See `getChildren`
     * @return array
     */
    public function getChilds(): array
    {
        return $this->getChildren();
    }

    /**
     * Get childs.
     *
     * @return array
     */
    public function getChildren(): array
    {
        if (config('menus.ordering')) {
            return collect($this->childs)->sortBy('order')->all();
        }

        return $this->childs;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl(): string
    {
        if ($this->route !== null) {
            return route($this->route[0], $this->route[1]);
        }

        if (empty($this->url)) {
            return url('/#');
        }

        return url($this->url);
    }

    /**
     * Get request url.
     *
     * @return string
     */
    public function getRequest(): string
    {
        return ltrim(str_replace(url('/'), '', $this->getUrl()), '/');
    }

    /**
     * @return string
     */
    public function getBadge(): string
    {
        if($this->hasBadge()) {
            extract($this->badge);

            return '<span class="' . $type . '">' . $text . '</span>';
        }
    }

    /**
     * Get icon.
     *
     * @param string|null $default
     *
     * @return string|null
     */
    public function getIcon(string $default = null): ?string
    {
        if ($this->icon !== null && $this->icon !== '') {
            return '<i class="' . $this->icon . '"></i>';
        }
        if ($default === null) {
            return $default;
        }

        return '<i class="' . $default . '"></i>';
    }

    /**
     * Get properties.
     *
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Get HTML attribute data.
     *
     * @return mixed
     */
    public function getAttributes(): mixed
    {
        $attributes = $this->attributes ?: [];

        Arr::forget($attributes, ['active', 'icon']);

        return HTML::attributes($attributes);
    }

    /**
     * Check is the current item divider.
     *
     * @return bool
     */
    public function isDivider(): bool
    {
        return $this->is('divider');
    }

    /**
     * Check is the current item divider.
     *
     * @return bool
     */
    public function isHeader(): bool
    {
        return $this->is('header');
    }

    /**
     * Check is the current item divider.
     *
     * @param $name
     *
     * @return bool
     */
    public function is($name): bool
    {
        return $this->name == $name;
    }

    /**
     * Check is the current item has sub menu .
     *
     * @return bool
     */
    public function hasSubMenu(): bool
    {
        return !empty($this->childs);
    }

    /**
     * @deprecated Same with hasSubMenu.
     *
     * @return bool
     */
    public function hasChilds(): bool
    {
        return $this->hasSubMenu();
    }

    /**
     * Check the active state for current menu.
     *
     * @return mixed
     */
    public function hasActiveOnChild(): mixed
    {
        if ($this->inactive()) {
            return false;
        }

        return $this->hasSubMenu() && $this->getActiveStateFromChildren();
    }

    public function getActiveStateFromChildren(): bool
    {
        foreach ($this->getChildren() as $child) {
            if ($child->inactive()) {
                continue;
            }
            if ($child->hasChilds()) {
                if ($child->getActiveStateFromChilds()) {
                    return true;
                }
            } elseif ($child->isActive()) {
                return true;
            } elseif ($child->hasRoute() && $child->getActiveStateFromRoute()) {
                return true;
            } elseif ($child->getActiveStateFromUrl()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @deprecated See `getActiveStateFromChildren()`
     * Get active state from child menu items.
     *
     * @return bool
     */
    public function getActiveStateFromChilds(): bool
    {
        return $this->getActiveStateFromChildren();
    }

    /**
     * Get inactive state.
     *
     * @return bool
     */
    public function inactive(): bool
    {
        $inactive = $this->getInactiveAttribute();

        if (is_bool($inactive)) {
            return $inactive;
        }

        if ($inactive instanceof \Closure) {
            return call_user_func($inactive);
        }

        return false;
    }

    /**
     * Get active attribute.
     *
     * @return string
     */
    public function getActiveAttribute(): string
    {
        return Arr::get($this->attributes, 'active');
    }

    /**
     * Get inactive attribute.
     *
     * @return string
     */
    public function getInactiveAttribute(): string
    {
        return Arr::get($this->attributes, 'inactive');
    }

    /**
     * Get active state for current item.
     *
     * @return mixed
     */
    public function isActive(): mixed
    {
        if ($this->inactive()) {
            return false;
        }

        $active = $this->getActiveAttribute();

        if (is_bool($active)) {
            return $active;
        }

        if ($active instanceof \Closure) {
            return call_user_func($active);
        }

        if ($this->hasRoute()) {
            return $this->getActiveStateFromRoute();
        }

        return $this->getActiveStateFromUrl();
    }

    /**
     * Determine the current item using route.
     *
     * @return bool
     */
    protected function hasRoute(): bool
    {
        return !empty($this->route);
    }

    /**
     * Get active status using route.
     *
     * @return bool
     */
    protected function getActiveStateFromRoute(): bool
    {
        return Request::is(str_replace(url('/') . '/', '', $this->getUrl()));
    }

    /**
     * Get active status using request url.
     *
     * @return bool
     */
    protected function getActiveStateFromUrl(): bool
    {
        return Request::is($this->url);
    }

    /**
     * Set order value.
     *
     * @param  int $order
     * @return self
     */
    public function order(int $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function hasBadge(): bool
    {
        return !empty($this->badge);
    }
}
