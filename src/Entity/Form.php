<?php

namespace App\Entity;

use App\Traits\Entity\TypeformIdEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @author Maud Remoriquet <maud.remoriquet@gmail.com>
 *
 * @ORM\Entity
 */
class Form
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use TypeformIdEntityTrait;

    /**
     * @ORM\Column(type="string", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private string $id;

    /**
     * @ORM\Column(type="string", name="name")
     */
    private string $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Question", mappedBy="form")
     */
    private $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Form
    {
        $this->name = $name;

        return $this;
    }

    public function getQuestions(): ArrayCollection
    {
        return $this->questions;
    }

    public function setQuestions(ArrayCollection $questions): Form
    {
        $this->questions = $questions;

        return $this;
    }

    public function addQuestion(Question $question): ArrayCollection
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this->questions;
    }

    public function removeQuestion(Question $question): ArrayCollection
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
        }

        return $this->questions;
    }
}
