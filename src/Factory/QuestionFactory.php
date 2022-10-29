<?php

namespace App\Factory;

use App\Dto\DefinitionFieldDto;
use App\Entity\Form;
use App\Entity\Question;

class QuestionFactory
{
    private const MAPPING_QUESTION_ROLE_TYPEFORM_ID = [
        'JDk1FY0zCI4o' => Question::FORMATED_ANSWER_ROLE_NAME,
        'YuQWcD3jGyeJ' => Question::FORMATED_ANSWER_ROLE_EMAIL,
        'ODpPXJJGAwO8' => Question::FORMATED_ANSWER_ROLE_COMPANY,
        'qA8u4ITWsLTG' => Question::FORMATED_ANSWER_ROLE_REASON,
        'd5WIrYXBpzLv' => Question::FORMATED_ANSWER_ROLE_COOPTATION,
    ];

    public static function create(DefinitionFieldDto $definitionFieldDto, Form $form): Question
    {
        $question = (new Question())
            ->setLabel($definitionFieldDto->title)
            ->setForm($form)
            ->setType($definitionFieldDto->type)
            ->setTypeformId($definitionFieldDto->id)
            ->setTypeformRef($definitionFieldDto->ref)
            ->setFormatedAnswerRole(self::MAPPING_QUESTION_ROLE_TYPEFORM_ID[$definitionFieldDto->id])
        ;

        if (Question::MULTIPLE_CHOICE_TYPE === $definitionFieldDto->type) {
            $question->setAllowOtherChoice((bool) $definitionFieldDto->allowOtherChoice);

            foreach ($definitionFieldDto->choices as $choice) {
                $questionChoice = QuestionChoiceFactory::create($choice, $question);
                $question->addQuestionChoice($questionChoice);
            }
        }

        return $question;
    }

    public static function updateFormatedAnwserRole(Question $question): Question
    {
        $question->setFormatedAnswerRole(self::MAPPING_QUESTION_ROLE_TYPEFORM_ID[$question->getTypeformId()]);

        return $question;
    }
}
