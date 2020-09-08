<?php

namespace Adeweb\NovaMatomoCards\Cards;

use Adeweb\NovaMatomoCards\MatomoAPI;
use ThijsSimonis\NovaListCard\NovaListCard;

class LastMonthCitiesByVisitorCountList extends NovaListCard
{
    public $width = 'full';


    public function __construct()
    {
        parent::__construct();
        $this->withMeta([
            'title' => __("nova_matomo_cards::messages.Top 5 cities by visitor"),
        ]);
        $values = (new MatomoAPI())->getLastMonthVisitorsByCitiesList(5);
        $this->rows($values);
    }

    public function uriKey(): string
    {
        return 'latest-users';
    }
}
