<?php

namespace Adeweb\NovaMatomoCards\Cards;

use Adeweb\NovaMatomoCards\MatomoAPI;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class LastMonthDeviceTypePartition extends Partition
{
    public function name() {
        return __('nova_matomo_cards.Last month visitor device types');
    }
    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $values = (new MatomoAPI())->getLastMonthDeviceTypePartition();

        return $this->result($values);
    }


    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        //return now()->addMinutes(15);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'last-month-device-type-partition';
    }
}
