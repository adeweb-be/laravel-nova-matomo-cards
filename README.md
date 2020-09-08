
## Installation

You can install the package via composer:

```bash
composer require adeweb/laravel-nova-matomo-cards
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Adeweb\NovaMatomoCards\NovaMatomoCardsServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    'token' => env('MATOMO_API_TOKEN'),
    'url' => env('MATOMO_API_URL'),
    'site_id' => env('MATOMO_API_SITE_ID')
];
```

Note: It is better to use ENV variables than publishing and editing the config file.

## Usage
In NovaServiceProvider.php :

```php
use Adeweb\NovaMatomoCards\Cards\LastMonthDeviceTypePartition;
use Adeweb\NovaMatomoCards\Cards\LastMonthCitiesByVisitorCountList;
use Adeweb\NovaMatomoCards\Cards\LastMonthPageByVisitorList;
use Adeweb\NovaMatomoCards\Cards\LiveVisitorsCount;
use Adeweb\NovaMatomoCards\Cards\PageViewsCount;
use Adeweb\NovaMatomoCards\Cards\PageViewsPerDayTrend;
use Adeweb\NovaMatomoCards\Cards\LastMonthReferrersPartition;
use Adeweb\NovaMatomoCards\Cards\UniqueVisitorsCount;
use Adeweb\NovaMatomoCards\Cards\UniqueVisitorsPerDayTrend;

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            (new UniqueVisitorsPerDayTrend())->width('1/2')->defaultRange('30'),
            (new UniqueVisitorsCount())->width('1/4')->defaultRange('month'),
            (new LiveVisitorsCount())->width('1/4')->defaultRange('720'),
            (new PageViewsPerDayTrend())->width('1/2')->defaultRange('30'),
            (new PageViewsCount())->width('1/4')->defaultRange('month'),
            (new LastMonthReferrersPartition())->width('1/2'),
            (new LastMonthDeviceTypePartition())->width('1/2'),
            (new LastMonthCitiesByVisitorCountList())->width('1/2'),
            (new LastMonthPageByVisitorList())->width('1/2'),
        ];
    }

In your .env file : 

```
MATOMO_API_TOKEN="[Your Matomo API token]"
MATOMO_API_URL="[Your Matomo instance URL]"
MATOMO_API_SITE_ID="[Your Matomo Site ID]"
```

## Testing

NTBD

## Credits

- [Antoine Duchêne](https://github.com/duchenean)

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.
