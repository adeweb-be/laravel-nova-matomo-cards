<?php

namespace Adeweb\NovaMatomoCards\Cards;

use Adeweb\NovaMatomoCards\MatomoAPI;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\TrendResult;

class UniqueVisitorsPerDayTrend extends Trend
{
    public function name()
    {
        return __('nova_matomo_cards::messages.Unique visitors per day');
    }

    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $values = (new MatomoAPI())->getUniqueVisitorsPerDayTrend($request->range);

        return (new TrendResult)->trend($values);
    }

    /**
     * Get the ranges available for the metric.
     * @return array
     *
     */
    public function ranges()
    {
        return [
            '7' => __('nova_matomo_cards::messages.Last 7 Days'),
            '14' => __('nova_matomo_cards::messages.Last 14 Days'),
            '30' => __('nova_matomo_cards::messages.Last 30 Days'),
            '60' => __('nova_matomo_cards::messages.Last 60 Days'),
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        return now()->addMinutes(15);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'visitors-per-day';
    }
}
