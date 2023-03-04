<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\Answer;
use App\Event\FormatedAnswerCreateEvent;
use App\Factory\FormatedAnswerFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FormatedAnswerSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormatedAnswerCreateEvent::NAME => 'createFormatedAnswer',
        ];
    }

    public function createFormatedAnswer(FormatedAnswerCreateEvent $formatedAnswerCreateEvent): void
    {
        $answers = $this->entityManager->getRepository(Answer::class)->findBy(
            [
                'groupByToken' => $formatedAnswerCreateEvent->getGroupByToken(),
            ]
        );

        $formatedAnswers = FormatedAnswerFactory::createFromAnswers($answers);
        foreach ($formatedAnswers as $formatedAnswer) {
            $this->entityManager->persist($formatedAnswer);
            $this->entityManager->flush();
        }
    }
}
