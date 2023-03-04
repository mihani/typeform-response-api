<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Answer;
use App\Entity\FormatedAnswer;
use App\Entity\Question;

class FormatedAnswerFactory
{
    public static function create(string $groupByToken, string $name, string $email, string $companyDescription, ?string $contactReason, bool $cooptation, \DateTime $receivedAt): FormatedAnswer
    {
        return (new FormatedAnswer())
            ->setUuid($groupByToken)
            ->setName($name)
            ->setCompanyDescription($companyDescription)
            ->setEmail($email)
            ->setContactReason($contactReason)
            ->setCooptation($cooptation)
            ->setReceivedAt($receivedAt)
        ;
    }

    public static function createFromAnswers(array $answers): ?array
    {
        $formatedAnswers = [];
        foreach ($answers as $answer) {
            if (!$answer instanceof Answer) {
                continue;
            }

            if (!is_null($answer->getQuestion()->getFormatedAnswerRole())) {
                $groupByToken = $answer->getGroupByToken();

                $formatedAnswers[$groupByToken]['receivedAt'] = $answer->getCreatedAt();

                switch ($answer->getQuestion()->getFormatedAnswerRole()) {
                    case Question::FORMATED_ANSWER_ROLE_COMPANY:
                        $formatedAnswers[$groupByToken][Question::FORMATED_ANSWER_ROLE_COMPANY] = $answer->getContent();

                        break;

                    case Question::FORMATED_ANSWER_ROLE_COOPTATION:
                        $formatedAnswers[$groupByToken][Question::FORMATED_ANSWER_ROLE_COOPTATION] = (bool) $answer->getContent();

                        break;

                    case Question::FORMATED_ANSWER_ROLE_EMAIL:
                        $formatedAnswers[$groupByToken][Question::FORMATED_ANSWER_ROLE_EMAIL] = $answer->getContent();

                        break;

                    case Question::FORMATED_ANSWER_ROLE_NAME:
                        $formatedAnswers[$groupByToken][Question::FORMATED_ANSWER_ROLE_NAME] = $answer->getContent();

                        break;

                    case Question::FORMATED_ANSWER_ROLE_REASON:
                        $formatedAnswers[$groupByToken][Question::FORMATED_ANSWER_ROLE_REASON] = $answer->getContent();

                        break;
                }
            }
        }

        if (empty($formatedAnswers)) {
            return null;
        }

        foreach ($formatedAnswers as $key => $formatedAnswer) {
            $formatedAnswerEntities[] = FormatedAnswerFactory::create(
                $key,
                $formatedAnswer[Question::FORMATED_ANSWER_ROLE_NAME],
                $formatedAnswer[Question::FORMATED_ANSWER_ROLE_EMAIL],
                $formatedAnswer[Question::FORMATED_ANSWER_ROLE_COMPANY],
                $formatedAnswer[Question::FORMATED_ANSWER_ROLE_REASON] ?? null,
                $formatedAnswer[Question::FORMATED_ANSWER_ROLE_COOPTATION],
                $formatedAnswer['receivedAt'],
            );
        }

        return $formatedAnswerEntities;
    }
}
