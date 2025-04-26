<?php

use Illuminate\Support\Facades\Route;
use KyleMassacre\Menus\Facades\Menu;
use KyleMassacre\Menus\MenuBuilder;
use App\Http\Presenters\MainMenuPresenter;

// Define routes first to ensure they exist before menu creation
// These should typically be in your routes file, but for demonstration:
if (!Route::has('login')) {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
}

// Create menu after routes are defined
Menu::create('main-guest', function (MenuBuilder $menu) {
    $menu->setPresenter(MainMenuPresenter::class);
    $menu->add([
        'route' => 'login',
        'title' => 'Login',
        'icon' => 'fa fa-sign-in fa-fw me-2',
    ]);
});

// You can also create additional menus
Menu::create('main-auth', function (MenuBuilder $menu) {
    $menu->setPresenter(MainMenuPresenter::class);
    $menu->add([
        'url' => '/dashboard',
        'title' => 'Dashboard',
        'icon' => 'fa fa-dashboard fa-fw me-2',
    ]);
    
    $menu->add([
        'route' => ['profile.show', []],
        'title' => 'Profile',
        'icon' => 'fa fa-user fa-fw me-2',
    ]);
});

