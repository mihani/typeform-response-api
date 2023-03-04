<?php

namespace App\Entity;

use App\Traits\Entity\TypeformIdEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * @author Maud Remoriquet <maud.remoriquet@gmail.com>
 *
 * @ORM\Entity
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class QuestionChoice
{
    use TypeformIdEntityTrait;
    use SoftDeleteableEntity;

    /**
     * @ORM\Column(type="uuid", unique=true)
     *
     * @ORM\Id
     *
     * @ORM\GeneratedValue(strategy="CUSTOM")
     *
     * @ORM\CustomIdGenerator("doctrine.uuid_generator")
     */
    private string $id;

    /**
     * @ORM\Column(type="string", name="label")
     */
    private string $label;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="questionChoices")
     *
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private Question $question;

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): QuestionChoice
    {
        $this->label = $label;

        return $this;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): QuestionChoice
    {
        $this->question = $question;

        return $this;
    }
}
