<?php

namespace App\Tests\Factory;

use App\Dto\DefinitionFieldDto;
use App\Entity\Form;
use App\Entity\Question;
use App\Entity\QuestionChoice;
use App\Factory\QuestionFactory;
use PHPUnit\Framework\TestCase;

class QuestionFactoryTest extends TestCase
{
    public function testCreateSimpleQuestionSuccess(): void
    {
        $definitionFieldDto = new DefinitionFieldDto('JDk1FY0zCI4o', 'Quel est votre nom complet ?', 'short_text', '62887e4e6983de5a');

        $form = new Form();

        $question = QuestionFactory::create($definitionFieldDto, $form);

        $this->assertEquals($definitionFieldDto->title, $question->getLabel());
        $this->assertInstanceOf(Question::class, $question);
        $this->assertFalse($question->isAllowOtherChoice());
        $this->assertEmpty($question->getQuestionChoices());
    }

    public function testCreateMultipleChoiceQuestionSuccess(): void
    {
        $choices = [
            [
                'id' => 'fhizCwkjNr8g',
                'label' => 'Linkedin',
            ],
            [
                'id' => 'NFY8WCLcqv8m',
                'label' => 'Site Web',
            ],
            [
                'id' => 'q5amzugV8fFH',
                'label' => 'Twitter',
            ],
        ];

        $definitionFieldDto = new DefinitionFieldDto('qA8u4ITWsLTG', "Comment m'avez vous trouvé ?", 'multiple_choice', 'e43cf3f75acfbd8d', true, $choices);

        $form = new Form();

        $question = QuestionFactory::create($definitionFieldDto, $form);

        $this->assertInstanceOf(Question::class, $question);
        $this->assertNotEmpty($question->getQuestionChoices());
        $this->assertInstanceOf(QuestionChoice::class, $question->getQuestionChoices()->first());
    }
}
