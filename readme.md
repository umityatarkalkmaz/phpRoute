# Simpe Routing
This class is used to route and process incoming requests to specific URL addresses. In this way, it allows the application to perform different actions for different URL addresses.
```php
Route::get('/', function(){echo 'something'});
```
`get($path, $callback);` Adds GET routes.

```php
Route::post($path, $callback);
```
`post($path, $callback);` Adds POST routes.

```php
Route::prefix('/admin'); 
```
`prefix($prefix);` Adds prefix.

```php
prefix(...)->group(function{get('/',{echo 'something'})});
```
`group($closure);` Adds a prefix to the group.

```php
get(...)->where('username', '[a-z]+'); 
```
`where($key, $pattern);` Adds new pattern.

```php
Route::dispatch();
```
`dispatch();` Processes routes.

Usage Example
```php
require 'path/to/route.php';
use UmitYatarkalkmaz\Route;

Route::get('/', 'mainmenu@main');

Route::prefix('/admin')->group(function () {
    Route::get('/', function () {
        echo 'Admin dashboard';
    });
    Route::get('/apps', function () {
        echo 'Admin apps';
    });
});

Route::prefix('/user')->group(function () {
    Route::get('/', function () {
        echo 'User index';
    });
    Route::get('/:username', function ($user) {
        echo 'Wellcome ' . $user;
    })->where('username', '[a-z]+');
    Route::get('/apps/:username', function ($user) {
        echo $user . "'s apps";
    });
});
Route::prefix('mainPrefix');
Route::get('/','mainPrefix@main');

Route::dispatch();

```