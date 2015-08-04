## Laravel 5.1 Bootstrap Form Builder

### Installation

Add to your composer.json file the package.

```
"socieboy/forms" : "dev-master"
```

Update your dependencies

```
composer update
```

After install this package you have to set the service provider on your config/app.php file

```
Socieboy\Forms\FormsServiceProvider::class
```

Copy the config file to your config directory.

```
php artisan vendor:publish
```

### Usage