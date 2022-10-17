<?php

namespace Evently\LimeRemote\Traits;

trait LimesurveyRemoteTrait
{
    public function getSessionKey()
    {
        $request = ['get_session_key', [$this->username, $this->password]];
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    public function releaseSessionKey()
    {
        $request = ['release_session_key', [$this->sessionKey]];
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int|null $surveyId
     * @return mixed
     */
    public function activateSurvey(int $surveyId = null)
    {
        $surveyId = (! $surveyId) ? $this->limesurveyId : $surveyId;
        $request = $this->createDefaultRequest('activate_survey', [$surveyId]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int|null $surveyId
     * @param array|null $attributes
     * @return mixed
     */
    public function activateTokens(array $attributes = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $attributes = ($attributes) ? $attributes : [];
        $request = $this->createDefaultRequest('activate_tokens', [$this->limesurveyId, $attributes]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int|null $surveyId
     * @param string $groupTitle
     * @param string|null $groupDescription
     * @return mixed
     */
    public function addGroup(string $groupTitle, string $groupDescription = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('add_group', [$this->limesurveyId, $groupTitle, $groupDescription]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param string $language
     * @return mixed
     */
    public function addLanguage(string $language)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('add_language', [$this->limesurveyId, $language]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * $participantData example: [ {"email":"me@example.com","lastname":"Bond","firstname":"James"},{"email":"me2@example.com","attribute_1":"example"} ].
     *
     * @param array $participantData
     * @param bool $createToken
     * @return mixed
     */
    public function addParticipants(array $participantData, bool $createToken = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('add_participants', [$this->limesurveyId, $participantData, $createToken]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param array $responseData
     * @return array The values added
     */
    public function addResponse(array $responseData)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('add_response', [$this->limesurveyId, $responseData]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int|null $surveyId
     * @param string $surveyTitle
     * @param string $surveyLanguage
     * @param string $format
     * @return mixed int|array The response ID or array with error message
     */
    public function addSurvey(int $surveyId = null, string $surveyTitle, string $surveyLanguage, string $format)
    {
        $request = $this->createDefaultRequest('add_survey', [$surveyId, $surveyTitle, $surveyLanguage, $format]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param string $newName
     * @return mixed
     */
    public function copySurvey(string $newName)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('copy_survey', [$this->limesurveyId, $newName]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param array $particiants ["email"=>"dummy-02222@limesurvey.com","firstname"=>"max","lastname"=>"mustermann"]]
     * @return mixed
     */
    public function cpd_importParticipants(array $particiants)
    {
        $request = $this->createDefaultRequest('cpd_importParticipants', [$particiants]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    public function deleteGroup(int $groupID)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('delete_group', [$this->limesurveyId, $groupID]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param string $language
     * @return mixed
     */
    public function deleteLanguage(string $language)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('delete_language', [$this->limesurveyId, $language]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param array $tokenIds
     * @return mixed
     */
    public function deleteParticipants(array $tokenIds)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('delete_participants', [$this->limesurveyId, $tokenIds]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int $questionId
     * @return mixed
     */
    public function deleteQuestion(int $questionId)
    {
        $request = $this->createDefaultRequest('delete_question', [$questionId]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @return mixed
     */
    public function deleteSurvey()
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('delete_survey', [$this->limesurveyId]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param string $documentType
     * @param string|null $languageCode
     * @param string|null $completionStatus
     * @param string|null $headingType
     * @param string|null $responseType
     * @param int|null $fromResponseId
     * @param int|null $toResponseId
     * @param array|null $fields
     * @return mixed
     */
    public function exportResponses(string $documentType, string $languageCode = null, string $completionStatus = null, string $headingType = null, string $responseType = null, int $fromResponseId = null, int $toResponseId = null, array $fields = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('export_responses', [$this->limesurveyId, $documentType, $languageCode, $completionStatus, $headingType, $responseType, $fromResponseId, $toResponseId, $fields]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param string|null $documentType
     * @param string $token
     * @param string|null $languageCode
     * @param string|null $completionStatus
     * @param string|null $headingType
     * @param string|null $responseType
     * @param int|null $fromResponseId
     * @param int|null $toResponseId
     * @param array|null $fields
     * @return mixed
     */
    public function exportResponsesByToken(string $documentType, string $token, string $languageCode = null, string $completionStatus = null, string $headingType = null, string $responseType = null, int $fromResponseId = null, int $toResponseId = null, array $fields = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('export_responses_by_token', [$this->limesurveyId, $documentType, $token, $languageCode, $completionStatus, $headingType, $responseType, $fromResponseId, $toResponseId, $fields]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param string|null $docType
     * @param string|null $language
     * @param string|null $graph
     * @param null $groupIds
     * @return mixed
     */
    public function exportStatistics(string $docType = null, string $language = null, string $graph = null, $groupIds = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('export_statistics', [$this->limesurveyId, $docType, $language, $graph, $groupIds]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param string $type day|hour
     * @param string $start datetime string
     * @param string $end datetime string (eg Carbon ->toDateTimeString()
     * @return mixed
     */
    public function exportTimeline(string $type, string $start, string $end)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('export_timeline', [$this->limesurveyId, $type, $start, $end]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int $groupId
     * @param array $groupSettings
     * @return mixed
     */
    public function getGroupProperties(int $groupId, array $groupSettings)
    {
        $request = $this->createDefaultRequest('get_group_properties', [$groupId, $groupSettings]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param array|null $surveyLocaleSettings   Properties to get, default to all attributes
     * @param string|null $lang  Language to use, default to Survey->language
     * @return mixed
     */
    public function getLanguageProperties(array $surveyLocaleSettings = null, string $lang = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('get_language_properties', [$this->limesurveyId, $surveyLocaleSettings, $lang]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param array|int $tokenQueryProperties Properties of participant properties used to query the participant, or the token id as an integer
     * @param array $tokenProperties The properties to get
     * @return mixed
     */
    public function getParticipantProperties(array $tokenQueryProperties, array $tokenProperties)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('get_participant_properties', [$this->limesurveyId, $tokenQueryProperties, $tokenProperties]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int $questionID
     * @param array $questionSettings (optional) properties to get, default to all
     * @param string $language
     * @return mixed
     */
    public function getQuestionProperties(int $questionID, array $questionSettings = null, string $language = null)
    {
        $request = $this->createDefaultRequest('get_question_properties', [$questionID, $questionSettings, $language]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int $surveyID
     * @param string $token
     * @return mixed
     */
    public function getResponseIds(int $surveyID, string $token)
    {
        $request = $this->createDefaultRequest('get_response_ids', [$surveyID, $token]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    //get session key -> see top

    /**
     * @param string $setttingName
     * @return mixed
     */
    public function getSiteSettings(string $setttingName)
    {
        $request = $this->createDefaultRequest('get_site_settings', [$setttingName]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param string|null $statName defaults to all stats
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
    public function getSummary(string $statName = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('get_summary', [$this->limesurveyId, $statName]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param array|null $surveySettings
     * @return mixed
     */
    public function getSurveyProperties(array $surveySettings = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('get_survey_properties', [$this->limesurveyId, $surveySettings]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function getUploadedFiles(string $token)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('get_uploaded_files', [$this->limesurveyId, $token]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param string $importData string containing the BASE 64 encoded data of a lsg,csv
     * @param string $importDataType lsg,csv
     * @param string|null $newGroupName
     * @param string|null $newGroupDescription
     * @return mixed
     */
    public function importGroup($importData, string $importDataType, string $newGroupName = null, string $newGroupDescription = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('import_group', [$this->limesurveyId, $importData, $importDataType, $newGroupName, $newGroupDescription]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int $groupId
     * @param string $importData
     * @param string|null $mandatory
     * @param string|null $newQuestionTitle
     * @param string|null $newqQuestion
     * @param string|null $newQuestionHelp
     * @return mixed
     */
    public function importQuestion(int $groupId, string $importData, string $sImportDataType, string $mandatory = null, string $newQuestionTitle = null, string $newqQuestion = null, string $newQuestionHelp = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('import_question', [$this->limesurveyId, $groupId, $importData, 'lsq', $mandatory, $newQuestionTitle, $newqQuestion, $newQuestionHelp]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param string $importData    String containing the BASE 64 encoded data of a lss, csv, txt or survey lsa archive
     * @param string $importDataType    lss, csv, txt or lsa
     * @param string|null $newSurveyName
     * @param int|null $destSurveyID
     * @return mixed
     */
    public function importSurvey(string $importData, string $importDataType, string $newSurveyName = null, int $destSurveyID = null)
    {
        $request = $this->createDefaultRequest('import_survey', [$importData, $importDataType, $newSurveyName, $destSurveyID]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param array|null $tokenIds
     * @param bool|null $email
     * @return mixed
     */
    public function inviteParticipants(array $tokenIds = null, bool $email = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('invite_participants', [$this->limesurveyId, $tokenIds, $email]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @return mixed
     */
    public function listGroups()
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('list_groups', [$this->limesurveyId]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int $start
     * @param int $limit
     * @param bool|null $unused
     * @param array|null $attributes
     * @param array $conditions
     * @return mixed
     */
    public function listParticipants(int $start, int $limit, bool $unused = null, array $attributes = null, array $conditions = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('list_participants', [$this->limesurveyId, $start, $limit, $unused, $attributes, $conditions]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int $groupId
     * @param string $language
     * @return mixed
     */
    public function listQuestions(int $groupId = null, string $language = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('list_questions', [$this->limesurveyId, $groupId, $language]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param string|null $username
     * @return mixed
     */
    public function listSurveys(string $username = null)
    {
        $request = $this->createDefaultRequest('list_surveys', [$username]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int|null $uid
     * @return mixed
     */
    public function listUsers(int $uid = null)
    {
        $request = $this->createDefaultRequest('list_users', [$uid]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param array|null $overrideAllConditions
     * @return mixed
     */
    public function mailRegisteredParticipants(array $overrideAllConditions = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('mail_registered_participants', [$this->limesurveyId, $overrideAllConditions]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

//    releaseSessionKey -> see top

    /**
     * @param int|null $minDaysBetween
     * @param int|null $maxReminders
     * @param array|null $tokenIds
     * @return mixed
     */
    public function remindParticipants(int $minDaysBetween = null, int $maxReminders = null, array $tokenIds = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('remind_participants', [$this->limesurveyId, $minDaysBetween, $maxReminders, $tokenIds]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int $groupID
     * @param array $groupData
     * @return mixed
     */
    public function setGroupProperties(int $groupID, array $groupData)
    {
        $request = $this->createDefaultRequest('set_group_properties', [$groupID, $groupData]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param array $surveyLocaleData
     * @param string|null $language
     * @return mixed
     */
    public function setLanguageProperties(array $surveyLocaleData, string $language = null)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('set_language_properties', [$this->limesurveyId, $surveyLocaleData, $language]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    public function setParticipantProperties($tokenQueryProperties, array $tokenData)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('set_participant_properties', [$this->limesurveyId, $tokenQueryProperties, $tokenData]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int $questionID
     * @param array $questionData
     * @param string|null $language
     * @return mixed
     */
    public function setQuestionProperties(int $questionID, array $questionData, string $language = null)
    {
        $request = $this->createDefaultRequest('set_question_properties', [$questionID, $questionData, $language]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param int $quotaId
     * @param array $quotaData
     * @return mixed
     */
    public function setQuotaProperties(int $quotaId, array $quotaData)
    {
        $request = $this->createDefaultRequest('set_quota_properties', [$quotaId, $quotaData]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param array $surveyData
     * @return mixed
     */
    public function setSurveyProperties(array $surveyData)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('set_survey_properties', [$this->limesurveyId, $surveyData]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param array $responseData
     * @return mixed
     */
    public function updateResponse(array $responseData)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('update_response', [$this->limesurveyId, $responseData]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    /**
     * @param string $fieldName
     * @param string $fileName
     * @param string $fileContent Base64 encoded
     * @return mixed
     */
    public function uploadFile(string $fieldName, string $fileName, string $fileContent)
    {
        if (! $this->isLimesurveyIdSet()) {
            return ['error'=>'Limesurvey Id not set'];
        }
        $request = $this->createDefaultRequest('upload_file', [$this->limesurveyId, $fieldName, $fileName, $fileContent]);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    public function genericRemoteQuery(string $query, array $queryAttributes)
    {
        $request = $this->createDefaultRequest($query, $queryAttributes);
        $result = $this->client->call($request[0], $request[1]);

        return $result;
    }

    protected function createDefaultRequest($type, array $variables)
    {
        array_unshift($variables, $this->sessionKey);

        return [$type, $variables];
    }
}
