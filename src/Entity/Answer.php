<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @author mihani <maud.remoriquet@gmail.com>
 *
 * @ORM\Entity(repositoryClass="App\Repository\AnswerRespository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class Answer
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator("doctrine.uuid_generator")
     */
    private string $id;

    /**
     * @ORM\Column(type="string", name="content")
     */
    private string $content;

    /**
     * This token allow to group answer arrived by the same payload.
     *
     * @ORM\Column(type="string", name="group_by_token")
     */
    private string $groupByToken;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="anwsers")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private Question $question;

    public function getId(): string
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Answer
    {
        $this->content = $content;

        return $this;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): Answer
    {
        $this->question = $question;

        return $this;
    }

    public function getGroupByToken(): string
    {
        return $this->groupByToken;
    }

    public function setGroupByToken(string $groupByToken): Answer
    {
        $this->groupByToken = $groupByToken;

        return $this;
    }
}
