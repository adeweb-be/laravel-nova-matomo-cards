<?php


namespace Adeweb\NovaMatomoCards;

use Illuminate\Support\Collection;

class MatomoAPI
{
    public $token;
    public $url;
    public $siteId;
    public $query;


    public function __construct()
    {
        $this->token = config('nova-matomo-cards.token');
        $this->url = config('nova-matomo-cards.url');
        $this->siteId = config('nova-matomo-cards.site_id');
    }

    public function request()
    {
        $this->query = $this->url;
        $this->query .= "?module=API";
        $this->query .= "&idSite=$this->siteId";
        $this->query .= "&format=JSON";
        $this->query .= "&token_auth=$this->token";

        return $this;
    }

    public function withMethod($method)
    {
        $this->query .= "&method=$method";

        return $this;
    }

    public function withDate($date)
    {
        $this->query .= "&date=$date";

        return $this;
    }

    public function withPeriod($period)
    {
        $this->query .= "&period=$period";

        return $this;
    }

    public function with($key, $value)
    {
        $this->query .= "&$key=$value";

        return $this;
    }

    public function fetch(): array
    {
        $fetched = file_get_contents($this->query);

        return json_decode($fetched, true);
    }

    public function getUniqueVisitorsCount($period): array
    {
        $result = $this->request()
            ->withMethod('VisitsSummary.get')
            ->withDate('previous2')
            ->withPeriod($period)
            ->fetch();
        $dateRanges = array_keys($result);
        $previous = $current = 0;
        if (array_key_exists('nb_uniq_visitors', $result[$dateRanges[0]])) {
            $previous = $result[$dateRanges[0]]['nb_uniq_visitors'];
        }
        if (array_key_exists('nb_uniq_visitors', $result[$dateRanges[1]])) {
            $current = $result[$dateRanges[1]]['nb_uniq_visitors'];
        }

        return [
            'previous' => $previous,
            'current' => $current,
        ];
    }

    public function getPageViewCount($period): array
    {
        $result = $this->request()
            ->withMethod('VisitsSummary.get')
            ->withDate('previous2')
            ->withPeriod($period)
            ->fetch();
        $dateRanges = array_keys($result);
        $previous = $current = 0;
        if (array_key_exists('nb_actions', $result[$dateRanges[0]])) {
            $previous = $result[$dateRanges[0]]['nb_actions'];
        }
        if (array_key_exists('nb_actions', $result[$dateRanges[1]])) {
            $current = $result[$dateRanges[1]]['nb_actions'];
        }

        return [
            'previous' => $previous,
            'current' => $current,
        ];
    }

    public function getUniqueVisitorsPerDayTrend($days): array
    {
        $date = "previous" . $days;
        $result = $this->request()
            ->withMethod('VisitsSummary.get')
            ->withDate($date)
            ->withPeriod('day')
            ->fetch();
        $trend = collect($result)->map(function ($item) {
            if (array_key_exists('nb_uniq_visitors', $item)) {
                return $item["nb_uniq_visitors"];
            } else {
                return 0;
            }
        })->all();

        return $trend;
    }

    public function getPageViewsPerDayTrend($days): array
    {
        $date = "previous" . $days;
        $result = $this->request()
            ->withMethod('VisitsSummary.get')
            ->withDate($date)
            ->withPeriod('day')
            ->fetch();
        $trend = collect($result)->map(function ($item) {
            if (array_key_exists('nb_actions', $item)) {
                return $item["nb_actions"];
            } else {
                return 0;
            }
        })->all();

        return $trend;
    }

    public function getLastMonthReferrersPartition(): array
    {
        $result = $this->request()
            ->withMethod('API.get')
            ->withPeriod('month')
            ->withDate('previous1')
            ->fetch();
        $result = reset($result);

        return [
            __("nova_matomo_cards::messages.From search engines") => $result["Referrers_visitorsFromSearchEngines"],
            __("nova_matomo_cards::messages.From social networks") => $result["Referrers_visitorsFromSocialNetworks"],
            __("nova_matomo_cards::messages.From direct entry") => $result["Referrers_visitorsFromDirectEntry"],
            __("nova_matomo_cards::messages.From websites") => $result["Referrers_visitorsFromWebsites"],
            __("nova_matomo_cards::messages.From campaigns") => $result["Referrers_visitorsFromCampaigns"],
        ];
    }

    public function getLiveVisitorsCounter($minutes): int
    {
        $result = $this->request()
            ->withMethod('Live.getCounters')
            ->with('lastMinutes', $minutes)
            ->fetch();
        if (! array_key_exists('visitors', $result[0])) {
            return 0;
        }

        return $result[0]['visitors'];
    }


    public function getLastMonthDeviceTypePartition(): array
    {
        $result = $this->request()
            ->withMethod('DevicesDetection.getType')
            ->withPeriod('month')
            ->withDate('previous1')
            ->fetch();

        $devices = collect(reset($result))->pluck('nb_visits', 'label')->all();

        return $devices;
    }

    public function getLastMonthVisitorsByCitiesList($count): Collection
    {
        $result = $this->request()
            ->withMethod('UserCountry.getCity')
            ->withPeriod('month')
            ->withDate('previous1')
            ->fetch();

        $cities = collect(reset($result))->map(function ($item) {
            return [
                "city_name" => $item["city_name"],
                "nb_visits" => $item["nb_visits"],
            ];
        })->take($count);

        return $cities;
    }

    public function getLastMonthPageByVisitorList($count): Collection
    {
        $result = $this->request()
            ->withMethod('Actions.getPageUrls')
            ->withPeriod('month')
            ->withDate('previous1')
            ->fetch();

        $pages = collect(reset($result))->map(function ($item) {
            return [
                "label" => $item["label"],
                "nb_visits" => $item["nb_visits"],
            ];
        })->take($count);

        return $pages;
    }
}
