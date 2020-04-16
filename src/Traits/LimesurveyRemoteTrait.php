<?php

namespace Evently\LimeRemote\Traits;


trait LimesurveyRemoteTrait
{
    public function getSessionKey()
    {
        $request = $this->client->request(1, 'get_session_key', [$this->username, $this->password]);
        $result =  $this->client->send($request);
        return $result->getRpcResult();
    }

    public function releaseSessionKey()
    {
        $request = $this->client->request(1, 'release_session_key', [$this->sessionKey]);
        $result =  $this->client->send($request);
        return $result->getRpcResult();
    }

    

    /**
     * @param int|NULL $surveyId
     * @return mixed
     */
    public function activateSurvey(int $surveyId = NULL)
    {
        $surveyId = (!$surveyId) ? $this->limesurveyId : $surveyId;
        $request = $this->createDefaultRequest('activate_survey',[$surveyId]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param int|NULL $surveyId
     * @param array|NULL $attributes
     * @return mixed
     */
    public function activateTokens(array $attributes = NULL)
    {

        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('activate_tokens',[$this->limesurveyId, $attributes]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param int|NULL $surveyId
     * @param string $groupTitle
     * @param string|NULL $groupDescription
     * @return mixed
     */
    public function addGroup( string $groupTitle, string $groupDescription = NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('add_group',[$this->limesurveyId, $groupTitle, $groupDescription]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param string $language
     * @return mixed
     */
    public function addLanguage(string $language)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('add_language',[$this->limesurveyId, $language]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * $participantData example: [ {"email":"me@example.com","lastname":"Bond","firstname":"James"},{"email":"me2@example.com","attribute_1":"example"} ]
     *
     * @param array $participantData
     * @param boolean $createToken
     * @return mixed
     */
    public function addParticipants(array $participantData, bool $createToken=NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('add_participants',[$this->limesurveyId, $participantData, $createToken]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }


    /**
     * @param array $responseData
     * @return array The values added
     */
    public function addResponse(array $responseData)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('add_response',[$this->limesurveyId, $responseData]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param int|NULL $surveyId
     * @param string $surveyTitle
     * @param string $surveyLanguage
     * @param string $format
     * @return mixed int|array The response ID or array with error message
     */
    public function addSurvey(int $surveyId = NULL, string $surveyTitle, string  $surveyLanguage, string $format )
    {
        $request = $this->createDefaultRequest('add_survey',[$surveyId, $surveyTitle, $surveyLanguage, $format]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param string $newName
     * @return mixed
     */
    public function copySurvey(string $newName)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('copy_survey',[$this->limesurveyId, $newName]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param array $particiants ["email"=>"dummy-02222@limesurvey.com","firstname"=>"max","lastname"=>"mustermann"]]
     * @return mixed
     */
    public function cpd_importParticipants(array $particiants)
    {
        $request = $this->createDefaultRequest('cpd_importParticipants',[$particiants]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }
    public function deleteGroup(int $groupID)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('delete_group',[$this->limesurveyId, $groupID]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param string $language
     * @return mixed
     */
    public function deleteLanguage(string $language)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('delete_language',[$this->limesurveyId, $language]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param array $tokenIds
     * @return mixed
     */
    public function deleteParticipants(array $tokenIds)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('delete_participants',[$this->limesurveyId, $tokenIds]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param int $questionId
     * @return mixed
     */
    public function deleteQuestion(int $questionId)
    {
        $request = $this->createDefaultRequest('delete_question',[$questionId]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @return mixed
     */
    public function deleteSurvey()
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('delete_survey',[$this->limesurveyId]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param string $documentType
     * @param string|NULL $languageCode
     * @param string|NULL $completionStatus
     * @param string|NULL $headingType
     * @param string|NULL $responseType
     * @param int|NULL $fromResponseId
     * @param int|NULL $toResponseId
     * @param array|NULL $fields
     * @return mixed
     */
    public function exportResponses(string $documentType, string $languageCode = NULL, string $completionStatus = NULL, string $headingType = NULL, string $responseType = NULL, int $fromResponseId = NULL, int $toResponseId = NULL, array $fields = NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('export_responses',[$this->limesurveyId, $documentType, $languageCode, $completionStatus, $headingType, $responseType, $fromResponseId, $toResponseId, $fields]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param string|NULL $documentType
     * @param string $token
     * @param string|NULL $languageCode
     * @param string|NULL $completionStatus
     * @param string|NULL $headingType
     * @param string|NULL $responseType
     * @param int|NULL $fromResponseId
     * @param int|NULL $toResponseId
     * @param array|NULL $fields
     * @return mixed
     */
    public function exportResponsesByToken( string $documentType, string $token, string $languageCode = NULL, string $completionStatus = NULL, string $headingType = NULL, string $responseType = NULL, int $fromResponseId = NULL, int $toResponseId = NULL, array $fields = NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('export_responses_by_token',[$this->limesurveyId, $documentType, $token, $languageCode, $completionStatus, $headingType, $responseType, $fromResponseId, $toResponseId, $fields]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param string|NULL $docType
     * @param string|NULL $language
     * @param string|NULL $graph
     * @param NULL $groupIds
     * @return mixed
     */
    public function exportStatistics(string $docType = NULL, string $language = NULL, string $graph = NULL, $groupIds = NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('export_statistics',[$this->limesurveyId, $docType, $language, $graph, $groupIds]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param string $type day|hour
     * @param string $start datetime string
     * @param string $end datetime string (eg Carbon ->toDateTimeString()
     * @return mixed
     */
    public function exportTimeline(string $type, string $start, string $end)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('export_timeline',[$this->limesurveyId, $type, $start, $end]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param int $groupId
     * @param array $groupSettings
     * @return mixed
     */
    public function getGroupProperties(int $groupId, array $groupSettings)
    {
        $request = $this->createDefaultRequest('get_group_properties', [$groupId, $groupSettings]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param array|NULL $surveyLocaleSettings   Properties to get, default to all attributes
     * @param string|NULL $lang  Language to use, default to Survey->language
     * @return mixed
     */
    public function getLanguageProperties(array $surveyLocaleSettings = NULL, string $lang = NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('get_language_properties',[$this->limesurveyId, $surveyLocaleSettings, $lang]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param array|int $tokenQueryProperties Properties of participant properties used to query the participant, or the token id as an integer
     * @param array $tokenProperties The properties to get
     * @return mixed
     */
    public function getParticipantProperties(array $tokenQueryProperties, array $tokenProperties)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('get_participant_properties',[$this->limesurveyId, $tokenQueryProperties, $tokenProperties]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param int $questionID
     * @param array $questionSettings (optional) properties to get, default to all
     * @param string $language
     * @return mixed
     */
    public function getQuestionProperties(int $questionID, array $questionSettings, string $language)
    {
        $request = $this->createDefaultRequest('get_question_properties',[$questionID, $questionSettings, $language]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param int $surveyID
     * @param string $token
     * @return mixed
     */
    public function getResponseIds(int $surveyID, string $token)
    {
        $request = $this->createDefaultRequest('get_response_ids',[$surveyID, $token]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    //get session key -> see top

    /**
     * @param string $setttingName
     * @return mixed
     */
    public function getSiteSettings(string $setttingName)
    {
        $request = $this->createDefaultRequest('get_site_settings',[$setttingName]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param string|NULL $statName defaults to all stats
     * Available stats:
     * For Survey stats
     *     completed_responses
     *     incomplete_responses
     *     full_responses
     * For token part
     *     token_count
     *     token_invalid
     *     token_sent
     *     token_opted_out
     *     token_completed
     * @return mixed
     */
    public function getSummary(string $statName = NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('get_summary',[$this->limesurveyId, $statName]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param array|NULL $surveySettings
     * @return mixed
     */
    public function getSurveyProperties(array $surveySettings = NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('get_survey_properties',[$this->limesurveyId, $surveySettings]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function getUploadedFiles(string $token)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('get_uploaded_files',[$this->limesurveyId, $token]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param string $importData string containing the BASE 64 encoded data of a lsg,csv
     * @param string $importDataType lsg,csv
     * @param string|NULL $newGroupName
     * @param string|NULL $newGroupDescription
     * @return mixed
     */
    public function importGroup($importData , string $importDataType, string $newGroupName = NULL, string $newGroupDescription = NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('import_group',[$this->limesurveyId,$importData, $importDataType, $newGroupName, $newGroupDescription ]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param int $groupId
     * @param string $importData
     * @param string|NULL $mandatory
     * @param string|NULL $newQuestionTitle
     * @param string|NULL $newqQuestion
     * @param string|NULL $newQuestionHelp
     * @return mixed
     */
    public function importQuestion(int $groupId, string $importData, string $sImportDataType, string $mandatory = NULL, string $newQuestionTitle = NULL, string $newqQuestion = NULL, string $newQuestionHelp = NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('import_question',[$this->limesurveyId, $groupId, $importData, 'lsq', $mandatory, $newQuestionTitle, $newqQuestion, $newQuestionHelp  ]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param string $importData    String containing the BASE 64 encoded data of a lss, csv, txt or survey lsa archive
     * @param string $importDataType    lss, csv, txt or lsa
     * @param string|NULL $newSurveyName
     * @param int|NULL $destSurveyID
     * @return mixed
     */
    public function importSurvey(string $importData, string $importDataType, string $newSurveyName = NULL, int $destSurveyID = NULL)
    {
        $request = $this->createDefaultRequest('import_survey',[$importData, $importDataType, $newSurveyName, $destSurveyID]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param array|NULL $tokenIds
     * @param boolean|NULL $email
     * @return mixed
     */
    public function inviteParticipants(array $tokenIds = NULL,bool $email = NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('invite_participants',[$this->limesurveyId,$tokenIds, $email]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @return mixed
     */
    public function listGroups()
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('list_groups',[$this->limesurveyId]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param int $start
     * @param int $limit
     * @param boolean|NULL $unused
     * @param array|NULL $attributes
     * @param array $conditions
     * @return mixed
     */
    public function listParticipants(int $start, int $limit, bool $unused = NULL, array $attributes = NULL, array $conditions = NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('list_participants',[$this->limesurveyId, $start, $limit, $unused, $attributes, $conditions]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }


    /**
     * @param integer $groupId
     * @param string $language
     * @return mixed
     */
    public function listQuestions(int $groupId=NULL, string $language=NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('list_questions', [$this->limesurveyId,$groupId,$language]);
        $result =  $this->client->send($request);
        return $result->getRpcResult();
    }


    /**
     * @param string|NULL $username
     * @return mixed
     */
    public function listSurveys(string $username = NULL)
    {
        $request = $this->createDefaultRequest('list_surveys',[$username]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param int|NULL $uid
     * @return mixed
     */
    public function listUsers(int $uid = NULL)
    {
        $request = $this->createDefaultRequest('list_users',[$uid]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param array|NULL $overrideAllConditions
     * @return mixed
     */
    public function mailRegisteredParticipants(array $overrideAllConditions = NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('mail_registered_participants',[$this->limesurveyId, $overrideAllConditions]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

//    releaseSessionKey -> see top


    /**
     * @param int|NULL $minDaysBetween
     * @param int|NULL $maxReminders
     * @param array|NULL $tokenIds
     * @return mixed
     */
    public function remindParticipants(int $minDaysBetween = NULL, int $maxReminders = NULL, array $tokenIds = NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('remind_participants',[$this->limesurveyId, $minDaysBetween, $maxReminders, $tokenIds]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param int $groupID
     * @param array $groupData
     * @return mixed
     */
    public function setGroupProperties(int $groupID, array $groupData)
    {
        $request = $this->createDefaultRequest('set_group_properties',[$groupID, $groupData]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param array $surveyLocaleData
     * @param string|NULL $language
     * @return mixed
     */
    public function setLanguageProperties(array $surveyLocaleData, string $language = NULL)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('set_language_properties',[$this->limesurveyId, $surveyLocaleData, $language]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }
    public function setParticipantProperties($tokenQueryProperties, array $tokenData)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('set_participant_properties',[$this->limesurveyId, $tokenQueryProperties, $tokenData]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param int $questionID
     * @param array $questionData
     * @param string|NULL $language
     * @return mixed
     */
    public function setQuestionProperties(int $questionID, array $questionData, string $language = NULL)
    {
        $request = $this->createDefaultRequest('set_question_properties',[$questionID, $questionData, $language]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param int $quotaId
     * @param array $quotaData
     * @return mixed
     */
    public function setQuotaProperties(int $quotaId, array $quotaData)
    {
        $request = $this->createDefaultRequest('set_quota_properties',[$quotaId, $quotaData]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param array $surveyData
     * @return mixed
     */
    public function setSurveyProperties(array $surveyData)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('set_survey_properties',[$this->limesurveyId, $surveyData]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param array $responseData
     * @return mixed
     */
    public function updateResponse(array $responseData)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('update_response',[$this->limesurveyId, $responseData]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    /**
     * @param string $fieldName
     * @param string $fileName
     * @param string $fileContent Base64 encoded
     * @return mixed
     */
    public function uploadFile(string $fieldName, string $fileName, string $fileContent)
    {
        if(!$this->isLimesurveyIdSet())
        {
            return array('error'=>'Limesurvey Id not set');
        }
        $request = $this->createDefaultRequest('upload_file',[$this->limesurveyId, $fieldName, $fileName, $fileContent]);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }


    public function genericRemoteQuery(string $query, array $queryAttributes)
    {
        $request = $this->createDefaultRequest($query,$queryAttributes);
        $result = $this->client->send($request);
        return $result->getRpcResult();
    }

    protected function createDefaultRequest($type, array $variables)
    {
        array_unshift($variables, $this->sessionKey);
        return $this->client->request(1, $type, $variables);
    }

}
