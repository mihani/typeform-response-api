<?php

namespace App\Controller;

use App\Dto\AnswerDto;
use App\Dto\DefinitionFieldDto;
use App\Dto\TypeformAnswerPayload;
use App\Entity\Form;
use App\Entity\Question;
use App\Event\FormatedAnswerCreateEvent;
use App\Factory\AnswerFactory;
use App\Factory\FormFactory;
use App\Factory\QuestionFactory;
use App\Traits\EntityManagerInterfaceTrait;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class NewAnswer
{
    use EntityManagerInterfaceTrait;

    private EventDispatcherInterface $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(TypeformAnswerPayload $data)
    {
        $formResponse = $data->formResponse;

        if (!$form = $this->em->getRepository(Form::class)->findOneBy(['typeformId' => $formResponse->formId])) {
            $form = FormFactory::create($formResponse);
            $this->em->persist($form);
        }

        $definition = $formResponse->definition;
        $formQuestions = [];

        /** @var DefinitionFieldDto $field */
        foreach ($definition->fields as $field) {
            $question = $this->em->getRepository(Question::class)->findOneBy([
                'typeformId' => $field->id,
                'typeformRef' => $field->ref,
            ]);

            if (!$question) {
                $question = QuestionFactory::create($field, $form);
                $this->em->persist($question);
            }

            if (!$question->getFormatedAnswerRole()) {
                $question = QuestionFactory::updateFormatedAnwserRole($question);
            }

            $formQuestions[$field->id] = $question;
        }

        $token = Uuid::uuid4();

        /** @var AnswerDto $formAnswer */
        foreach ($formResponse->answers as $formAnswer) {
            $answer = AnswerFactory::create(
                $formAnswer,
                $formQuestions[$formAnswer->field->id],
                $token
            );
            $this->em->persist($answer);
        }

        $this->em->flush();

        $event = new FormatedAnswerCreateEvent($token->toString());
        $this->dispatcher->dispatch($event, FormatedAnswerCreateEvent::NAME);

        return $formResponse->answers;
    }
}
