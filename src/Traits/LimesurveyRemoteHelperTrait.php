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


    public function getInternalQuestionCode($questionCodeStringOrArray)
    {
        //if string create array, else just set array
        $returnArray = [];
        $questions = (is_string($questionCodeStringOrArray)) ? array($questionCodeStringOrArray) : $questionCodeStringOrArray;
        //get questionList from survey
        $questionList = $this->listQuestions();
        //go over the questionlist and create the subquestions
        foreach ($questionList as $question) 
        {
            if(in_array($question['title'], $questions))
            {
                $returnArray[$question['title']] = "{$question['sid']}X{$question['gid']}X{$question['qid']}";
            }
        }
        asort($returnArray);
        return ($returnArray);


    }

}
