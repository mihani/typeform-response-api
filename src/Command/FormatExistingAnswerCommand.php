<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Answer;
use App\Factory\FormatedAnswerFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FormatExistingAnswerCommand extends Command
{
    protected static $defaultName = 'jobcontact:one-shot:format-existing-answer';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $answers = $this->entityManager->getRepository(Answer::class)->findAllOrderByGroupByToken();

        $formatedAnswers = FormatedAnswerFactory::createFromAnswers($answers);

        if (!$formatedAnswers) {
            $output->writeln('No formated answer');

            return Command::SUCCESS;
        }

        foreach ($formatedAnswers as $formatedAnswer) {
            $this->entityManager->persist($formatedAnswer);
            $this->entityManager->flush();
        }

        return Command::SUCCESS;
    }
}
