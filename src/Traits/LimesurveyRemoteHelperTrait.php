<?php

namespace Evently\LimeRemote\Traits;


use Carbon\Carbon;

trait LimesurveyRemoteHelperTrait
{
    /**
     * @param int $numberOfDays
     * @return mixed
     */
    public function getLastNumDaysTimeline(int $numberOfDays)
    {
        $start = Carbon::now()->subDays($numberOfDays)->toDateTimeString();
        $end = Carbon::now()->toDateTimeString();
        return $this->exportTimeline('day', $start, $end);
    }

}
