<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @author Maud Remoriquet <maud.remoriquet@gmail.com>
 *
 * @ORM\Entity
 */
class Answer
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Column(type="string", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
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
