<?php

namespace KyleMassacre\Menus;

use Closure;
use Countable;
use Illuminate\Contracts\Config\Repository;
use Illuminate\View\Factory;

class Menu implements Countable
{
    /**
     * The menus collections.
     *
     * @var array
     */
    protected array $menus = array();
    /**
     * @var Repository
     */
    private Repository $config;
    /**
     * @var Factory
     */
    private Factory $views;

    /**
     * The constructor.
     *
     * @param Factory    $views
     * @param Repository $config
     */
    public function __construct(Factory $views, Repository $config)
    {
        $this->views = $views;
        $this->config = $config;
    }

    /**
     * Make new menu.
     *
     * @param string $name
     * @param Closure $callback
     *
     * @return \KyleMassacre\Menus\MenuBuilder
     */
    public function make(string $name, \Closure $callback): MenuBuilder|null
    {
        return $this->create($name, $callback);
    }

    /**
     * Create new menu.
     *
     * @param string   $name
     * @param Callable $resolver
     *
     * @return \KyleMassacre\Menus\MenuBuilder
     */
    public function create(string $name, Closure $resolver): MenuBuilder|null
    {
        $builder = new MenuBuilder($name, $this->config);

        $builder->setViewFactory($this->views);

        $this->menus[$name] = $builder;

        return $resolver($builder);
    }

    /**
     * Check if the menu exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->menus);
    }

    /**
     * Get instance of the given menu if exists.
     *
     * @param string $name
     *
     * @return string|null
     */
    public function instance(string $name): MenuBuilder|null
    {
        return $this->has($name) ? $this->menus[$name] : null;
    }

    /**
     * Modify a specific menu.
     *
     * @param  string   $name
     * @param  Closure  $callback
     * @return void
     */
    public function modify(string $name, Closure $callback): void
    {
        $menu = collect($this->menus)->filter(function ($menu) use ($name) {
            return $menu->getName() == $name;
        })->first();

        $callback($menu);
    }

    /**
     * Render the menu tag by given name.
     *
     * @param string $name
     * @param string|null $presenter
     * @param array $bindings
     * @return string|null
     */
    public function get(string $name, string $presenter = null, array $bindings = array()): ?string
    {
        return $this->has($name) ?
            $this->menus[$name]->setBindings($bindings)->render($presenter) : null;
    }

    /**
     * Render the menu tag by given name.
     *
     * @param string $name
     * @param null|string $presenter
     * @param array $bindings
     * @return string|null
     */
    public function render(string $name, string $presenter = null, array $bindings = array()): ?string
    {
        return $this->get($name, $presenter, $bindings);
    }

    /**
     * Get a stylesheet for enable multilevel menu.
     *
     * @return mixed
     */
    public function style(): mixed
    {
        return $this->views->make('menus::style')->render();
    }

    /**
     * Get all menus.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->menus;
    }

    /**
     * Get count from all menus.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->menus);
    }

    /**
     * Empty the current menus.
     */
    public function destroy(): void
    {
        $this->menus = array();
    }
}
