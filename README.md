
## Installation

You can install the package via composer:

```bash
composer require /nova-matomo-cards
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Adeweb\NovaMatomoCards\NovaMatomoCardsServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Adeweb\NovaMatomoCards\NovaMatomoCardsServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage


## Testing


## Changelog

## Credits

- [Antoine Duchêne](https://github.com/duchenean)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
