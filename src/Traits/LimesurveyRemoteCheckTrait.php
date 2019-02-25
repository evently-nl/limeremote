<?php

namespace Evently\LimeRemote\Traits;


use Carbon\Carbon;

trait LimesurveyRemoteCheckTrait
{
    protected function isLimesurveyIdSet()
    {
        return (!isset($this->limesurveyId)) ? false : true;
    }

}
