<?php

namespace Adeweb\NovaMatomoCards\Cards;

use Adeweb\NovaMatomoCards\MatomoAPI;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class LiveVisitorsCount extends Value
{
    public function name()
    {
        return __('nova_matomo_cards.Live visitors count');
    }

    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $value = (new MatomoAPI())->getLiveVisitorsCounter($request->range);

        return $this->result($value)->allowZeroResult();
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            '30' => __('nova_matomo_cards.Last 30 minutes'),
            '60' => __('nova_matomo_cards.Last 1 hour'),
            '120' => __('nova_matomo_cards.Last 2 hours'),
            '360' => __('nova_matomo_cards.Last 6 hours'),
            '720' => __('nova_matomo_cards.Last 12 hours'),
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // No cache for this metric
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'live-visitors-count';
    }
}
