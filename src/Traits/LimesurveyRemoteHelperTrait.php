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

    public function getAllSGQACodes()
    {
        $sgqaCodes = array();
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }

        $questionList =collect( $this->listQuestions() )->sortBy('question_order');
        $groupList = collect($this->listGroups());
        $sortedGroups = array();
        foreach($groupList as $groupKey => $group)
        {
            $sortedGroups[$group['gid']] = $group;
            foreach($questionList as $key => $question)
            {
                if(($question['gid'] == $group['gid'])&& ($question['parent_qid']== 0))
                {
                    $sortedGroups[$group['gid']]['questions'][$question['qid']] = $question;
                }
            }
        }

        $subQuestions = $questionList->filter(function ($value, $key) {
            return $value['parent_qid'] != "0";
        });
        $parentQids = $subQuestions->pluck('parent_qid')->unique()->toArray();

        foreach ($sortedGroups as $groupKey => $group)
        {
            foreach($group['questions'] as $questionKey => $question)
            {
                if(in_array($question['qid'],$parentQids))
                {
                    foreach ($subQuestions as $subQuestionKey => $subQuestion)
                    {
                        if($subQuestion['parent_qid'] == $question['qid'])
                        {
                            $sortedGroups[$groupKey]['questions'][$questionKey]['subquestions'][$subQuestion['scale_id']][$subQuestion['title']] = $subQuestion;
                        }
                    }
                }
            }
        }


        //go through different options of sgqa code generation

        //default without subquestions
        //question types: S N T U 5 G I ! L O Y X D |
        $defaultQuestionTypes = array("S","N","T","U","5","G","I","!","L","O","Y","X","D","|");
        $subquestionQuestionTypes = array("1","F","H","B","A","E","C","F","K","M","P","Q");
        $dualSubquestionsQuestionTypes = array(":" , ";");
        $exceptionQuestionTypes = array("R", "*");
        foreach($sortedGroups as $groupKey => $group)
        {

            foreach($group['questions'] as $questionKey => $question)

            {
                $sgqaCodes[$group['group_order']. '-' .$group['group_name']][$question['title']]['main_question_text'] = strip_tags($question['question']);
                if(in_array($question['type'],$defaultQuestionTypes, true))
                {
                    $baseSGQACode = "{$question['sid']}X{$question['gid']}X{$question['qid']}";
                    $sgqaCodes[$group['group_order']. '-' .$group['group_name']][$question['title']]['question_codes'][$question['title']]= array('sgqa' => $baseSGQACode,
                                                          'question' =>  strip_tags($question['question']) );
                    //check for other
                    if($question['other']=='Y')
                    {
                        $sgqaCodes[$group['group_order']. '-' .$group['group_name']][$question['title']]['question_codes'][$question['title']."other"]= array('sgqa' => $baseSGQACode.'other',
                                                                    'question' =>  strip_tags($question['question'] . '- other' ));
                    }
                    // comments
                    if($question['type']=='O')
                    {
                        $sgqaCodes[$group['group_order']. '-' .$group['group_name']][$question['title']]['question_codes'][$question['title']."comment"]= array('sgqa' => $baseSGQACode.'coment',
                                                                         'question' =>  strip_tags($question['question'] . '- comment' ));
                    }
                    //add filecount for upload questions
                    if($question['type'] == '|')
                    {
                        $sgqaCodes[$group['group_order']. '-' .$group['group_name']][$question['title']]['question_codes'][$question['title']."_filecount"]= array('sgqa' => $baseSGQACode.'_filecount',
                                                                             'question' =>  strip_tags($question['question'] . '- filecount' ));
                    }

                }

                if(in_array($question['type'],$subquestionQuestionTypes, true))
                {
                    foreach($question['subquestions'][0] as $subQuestionKey => $subQuestion)
                    {
                        $baseSubQuestionCode = "{$question['sid']}X{$question['gid']}X{$question['qid']}{$subQuestion['title']}";


                        if($question['type'] == '1')
                        {
                            foreach($question['subquestions'][0] as $subQuestionKey => $subQuestion)
                            {
                                $sgqaCodes[$group['group_order']. '-' .$group['group_name']][$question['title']]['question_codes'][$question['title'].$subQuestion['title'].'#0'] = array('sgqa' => "{$question['sid']}X{$question['gid']}X{$question['qid']}{$subQuestion['title']}#0",
                                                                                                    'question' =>  strip_tags("{$subQuestion['question']} #0 "));

                                $sgqaCodes[$group['group_order']. '-' .$group['group_name']][$question['title']]['question_codes'][$question['title'].$subQuestion['title'].'#1'] =  array('sgqa' => "{$question['sid']}X{$question['gid']}X{$question['qid']}{$subQuestion['title']}#1",
                                                                                                'question' =>  strip_tags("{$subQuestion['question']} #1 "));
                            }

                        }
                        else
                        {
                            $sgqaCodes[$group['group_order']. '-' .$group['group_name']][$question['title']]['question_codes'][$question['title'].$subQuestion['title']] = array('sgqa' => $baseSubQuestionCode,
                                                                        'question' =>  strip_tags("{$subQuestion['question']}" ));


                            if($question['type'] == 'P')
                            {
                                $sgqaCodes[$group['group_order']. '-' .$group['group_name']][$question['title']]['question_codes'][$question['title'].$subQuestion['title'].'comment'] =array('sgqa' => $baseSubQuestionCode.'comment',
                                                                                                'question' => strip_tags("{$subQuestion['question']} comment"));
                            }

                        }



                    }

                    if($question['other']=='Y')
                    {
                        $sgqaCodes[$group['group_order']. '-' .$group['group_name']][$question['title']]['question_codes'][$question['title'].'other']= array('sgqa' => "{$question['sid']}X{$question['gid']}X{$question['qid']}other",
                                                                 'question' =>  strip_tags($question['question'] . '- other' ));


                        if($question['type'] == 'P')
                        {
                            $sgqaCodes[$group['group_order']. '-' .$group['group_name']][$question['title']]['question_codes'][$question['title'].'othercomment']= array('sgqa' => "{$question['sid']}X{$question['gid']}X{$question['qid']}othercomment",
                                'question' =>  strip_tags($question['question'] . '- other-comment' ));
                        }
                    }
                }

                if(in_array($question['type'],$dualSubquestionsQuestionTypes, true))
                {
                    foreach($question['subquestions'][0] as $subQuestionScaleOneKey => $subQuestionScaleOne)
                    {

                        foreach($question['subquestions'][1] as $subQuestionScaleTwoKey => $subQuestionScaleTwo)
                        {
                            $sgqaCodes[$group['group_order']. '-' .$group['group_name']][$question['title']]['question_codes'][$question['title'].$subQuestionScaleOne['title'].'_'.$subQuestionScaleTwo['title']] = array('sgqa' => "{$question['sid']}X{$question['gid']}X{$question['qid']}{$subQuestionScaleOne['title']}_{$subQuestionScaleTwo['title']}",
                                                                                                                            'question' =>  strip_tags("{$subQuestionScaleOne['question']} | {$subQuestionScaleTwo['question']}"));
                        }
                    }
                }

                if(in_array($question['type'],$exceptionQuestionTypes, true))
                {
                    if($question['type'] == 'R')
                    {
                        //ranking question, get correct codes
                        $answerOptions = $this->getQuestionProperties($question['qid'], array('answeroptions'));

                        foreach ($answerOptions['answeroptions'] as $answer)
                        {
                            $sgqaCodes[$group['group_order']. '-' .$group['group_name']][$question['title']]['question_codes'][$question['title'].$answer['order']] = array('sgqa' => "{$question['sid']}X{$question['gid']}X{$question['qid']}{$answer['order']}",
                                                                                    'question' => strip_tags("{$answer['answer']}"));

                        }
                    }
                    if($question['type'] == '*')
                    {
                        $baseSGQACode = "{$question['sid']}X{$question['gid']}X{$question['qid']}";
                        $sgqaCodes[$group['group_order']. '-' .$group['group_name']][$question['title']]['question_codes'][$question['title']]= array('sgqa' => $baseSGQACode,
                            'question' =>  strip_tags($question['question']) );
                    }
                }


            }

        }
        ksort($sgqaCodes);
//        dd($sortedGroups,$sgqaCodes);
        return $sgqaCodes;





    }

}
