<?php

namespace Adeweb\NovaMatomoCards\Cards;

use Adeweb\NovaMatomoCards\MatomoAPI;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class UniqueVisitorsCount extends Value
{

    public function name() {
        return __('nova_matomo_cards.Unique visitors count');
    }

    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $values = (new MatomoAPI())->getUniqueVisitorsCount($request->range);

        return $this->result($values['current'])->previous($values['previous']);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            'day' => __('nova_matomo_cards.Last day'),
            'week' => __('nova_matomo_cards.Last week'),
            'month' => __('nova_matomo_cards.Last month'),
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
        return 'unique-visitors';
    }
}
