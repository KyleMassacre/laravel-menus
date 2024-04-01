<?php

namespace KyleMassacre\Menus\Contracts;

use Illuminate\Contracts\Support\Arrayable as ArrayableContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class MenuItemContract implements ArrayableContract
{
    /**
     * Array properties.
     *
     * @var array
     */
    protected array $properties = [];

    /**
     * The child collections for current menu item.
     *
     * @var array
     */
    protected array $childs = [];

    /**
     * The fillable attribute.
     *
     * @var array
     */
    protected array $fillable = [
        'url',
        'route',
        'title',
        'name',
        'icon',
        'parent',
        'attributes',
        'active',
        'order',
        'hideWhen',
        'badge',
        'class',
    ];

    abstract public function __construct(array $properties = []);

    /**
     * Set the icon property when the icon is defined in the link attributes.
     *
     * @param array $properties
     *
     * @return array
     */
    protected static function setIconAttribute(array $properties): array
    {
        $icon = Arr::get($properties, 'attributes.icon');
        if (!is_null($icon)) {
            $properties['icon'] = $icon;

            Arr::forget($properties, 'attributes.icon');

            return $properties;
        }

        return $properties;
    }

    /**
     * Get random name.
     *
     * @param array $attributes
     *
     * @return string
     */
    protected static function getRandomName(array $attributes): string
    {
        return substr(md5(Arr::get($attributes, 'title', Str::random(6))), 0, 5);
    }

    /**
     * Create new static instance.
     *
     * @param array $properties
     *
     * @return static
     */
    public static function make(array $properties): static
    {
        $properties = self::setIconAttribute($properties);

        return new static($properties);
    }

    abstract public function fill(array $attributes): void;

    abstract public function child(array $attributes): self;

    abstract public function dropdown(string $title, \Closure $callback, int $order = 0, array $attributes = []): static;

    abstract public function route(string $route, string $title, array $parameters = [], int $order = 0, array $attributes = []): static;

    abstract public function url(string $url, string $title, int $order = 0, array $attributes = []): static;

    /**
     * Add new child item.
     *
     * @param array $properties
     *
     * @return $this
     */
    public function add(array $properties): static
    {
        $item = static::make($properties);

        $this->childs[] = $item;

        return $item;
    }

    abstract public function addDivider($order = null): static;

    abstract public function divider($order = null): static;

    abstract public function addHeader(string $title): static;

    abstract public function header(string $title): static;

    abstract public function addBadge(string $type, string $text): static;

    abstract public function getChildren(): array;

    abstract public function getUrl(): string;

    abstract public function getRequest(): string;

    abstract public function getBadge(): string;

    abstract public function getIcon(null|string $default): ?string;

    abstract public function getProperties(): array;

    abstract public function getAttributes(): mixed;

    abstract public function is(string $name): bool;

    abstract public function hasSubMenu(): bool;

    abstract public function hasActiveOnChild(): mixed;

    abstract public function getActiveStateFromChildren(): bool;

    abstract public function inactive(): bool;

    abstract public function getActiveAttribute(): string;

    abstract public function getInactiveAttribute(): string;

    abstract public function isActive(): mixed;

    abstract protected function hasRoute(): mixed;

    abstract protected function getActiveStateFromRoute(): bool;

    abstract protected function getActiveStateFromUrl(): bool;

    abstract public function order(int $order): self;

    abstract public function hasBadge(): bool;

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->getProperties();
    }

    /**
     * Get property.
     *
     * @param string $key
     *
     * @return string|null
     */
    public function __get(string $key): ?string
    {
        $return = null;
        if(property_exists($this, $key)) {
            $return = $this->$key ?? null;
        }

        return $return;
    }

    public function __call($name, $arguments)
    {
        if(str($name)->is('is*')) {
            $slice = str($name)->after('is')->lower();

            return $this->is($slice);
        }
    }
}
