<?php

namespace Adeweb\NovaMatomoCards\Cards;

use Adeweb\NovaMatomoCards\MatomoAPI;
use Laravel\Nova\Nova;
use ThijsSimonis\NovaListCard\NovaListCard;

class LastMonthCitiesByVisitorCountList extends NovaListCard
{
    public $width = 'full';


    public function __construct()
    {
        parent::__construct();
        $this->withMeta([
            'title' => __("Top 5 visitor cities"),
        ]);
        $values = (new MatomoAPI())->getLastMonthVisitorsByCitiesList(5);
        $this->rows($values);
    }

    public function uriKey(): string
    {
        return 'latest-users';
    }
}
