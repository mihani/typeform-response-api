<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Dto\TypeformAnswerPayload;
use App\Manager\AnswerManager;
use App\Manager\FormManager;
use App\Manager\QuestionManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @author Maud Remoriquet <maud.remoriquet@gmail.com>
 */
class TypeformSubscriber implements EventSubscriberInterface
{
    /** @var FormManager */
    private $formManager;

    /** @var QuestionManager */
    private $questionManager;

    /** @var AnswerManager */
    private $answerManager;

    /**
     * @param FormManager     $formManager
     * @param QuestionManager $questionManager
     * @param AnswerManager   $answerManager
     */
    public function __construct(
        FormManager $formManager,
        QuestionManager $questionManager,
        AnswerManager $answerManager
    ) {
        $this->formManager     = $formManager;
        $this->questionManager = $questionManager;
        $this->answerManager   = $answerManager;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['newAnswers', EventPriorities::POST_VALIDATE],
        ];
    }

    /**
     * @param ViewEvent $event
     *
     * @throws \Exception
     */
    public function newAnswers(ViewEvent $event)
    {
        if (!$event->getControllerResult() instanceof TypeformAnswerPayload){
            return;
        }

        $typeform = array_intersect_key(
            $event->getControllerResult()->form_response,
            TypeformAnswerPayload::PAYLOAD_PATTERN
        );

        $form = $this->formManager->createForm($typeform['definition']);
        $this->questionManager->createQuestions($typeform['definition']['fields'], $form);
        $this->answerManager->createAnwser($typeform['answers']);

        $event->setResponse(new JsonResponse(null, Response::HTTP_NO_CONTENT));
    }
}