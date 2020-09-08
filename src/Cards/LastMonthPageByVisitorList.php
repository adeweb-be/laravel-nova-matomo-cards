<?php

namespace Adeweb\NovaMatomoCards\Cards;

use Adeweb\NovaMatomoCards\MatomoAPI;
use ThijsSimonis\NovaListCard\NovaListCard;

class LastMonthPageByVisitorList extends NovaListCard
{
    public $width = 'full';


    public function __construct()
    {
        parent::__construct();
        $this->withMeta([
            'title' => __("nova_matomo_cards::messages.Top 5 pages by visitor"),
        ]);
        $values = (new MatomoAPI())->getLastMonthPageByVisitorList(5);
        $this->rows($values);
    }

    public function uriKey(): string
    {
        return 'latest-users';
    }
}
