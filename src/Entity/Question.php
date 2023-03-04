<?php

namespace App\Entity;

use App\Traits\Entity\TypeformIdEntityTrait;
use App\Traits\Entity\TypeformRefEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
class Question
{
    use SoftDeleteableEntity;
    use TypeformIdEntityTrait;
    use TypeformRefEntityTrait;

    public const MULTIPLE_CHOICE_TYPE = 'multiple_choice';
    public const SHORT_TEXT_CHOICE_TYPE = 'short_text';
    public const EMAIL_CHOICE_TYPE = 'email';
    public const LONG_TEXT_CHOICE_TYPE = 'long_text';
    public const BOOL_CHOICE_TYPE = 'yes_no';

    public const FORMATED_ANSWER_ROLE_EMAIL = 'email';
    public const FORMATED_ANSWER_ROLE_NAME = 'name';
    public const FORMATED_ANSWER_ROLE_COMPANY = 'company';
    public const FORMATED_ANSWER_ROLE_REASON = 'reason';
    public const FORMATED_ANSWER_ROLE_COOPTATION = 'cooptation';

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
     * @ORM\ManyToOne(targetEntity="Form", inversedBy="questions")
     *
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id")
     */
    private Form $form;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question")
     */
    private $anwsers;

    /**
     * @ORM\Column(type="boolean", name="allow_other_choice")
     */
    private bool $allowOtherChoice = false;

    /**
     * @ORM\Column(type="string", name="type")
     */
    private string $type;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="QuestionChoice", mappedBy="question", cascade={"persist", "remove"})
     */
    private $questionChoices;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $formatedAnswerRole;

    public function __construct()
    {
        $this->anwsers = new ArrayCollection();
        $this->questionChoices = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): Question
    {
        $this->label = $label;

        return $this;
    }

    public function getForm(): Form
    {
        return $this->form;
    }

    public function setForm(Form $form): Question
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAnwsers(): Collection
    {
        return $this->anwsers;
    }

    public function setAnwsers(ArrayCollection $anwsers): Question
    {
        $this->anwsers = $anwsers;

        return $this;
    }

    public function addAnwser(Answer $answer): ArrayCollection
    {
        if (!$this->anwsers->contains($answer)) {
            $this->anwsers->add($answer);
        }

        return $this->anwsers;
    }

    public function removeAnswer(Answer $answer): ArrayCollection
    {
        if ($this->anwsers->contains($answer)) {
            $this->anwsers->removeElement($answer);
        }

        return $this->anwsers;
    }

    public function isAllowOtherChoice(): bool
    {
        return $this->allowOtherChoice;
    }

    public function setAllowOtherChoice(bool $allowOtherChoice): Question
    {
        $this->allowOtherChoice = $allowOtherChoice;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Question
    {
        $this->type = $type;

        return $this;
    }

    public function getFormatedAnswerRole(): ?string
    {
        return $this->formatedAnswerRole;
    }

    public function setFormatedAnswerRole($formatedAnswerRole): self
    {
        $this->formatedAnswerRole = $formatedAnswerRole;

        return $this;
    }

    public function getQuestionChoices(): Collection
    {
        return $this->questionChoices;
    }

    public function setQuestionChoices(ArrayCollection $questionChoices): Question
    {
        $this->questionChoices = $questionChoices;

        return $this;
    }

    public function addQuestionChoice(QuestionChoice $questionChoice): ArrayCollection
    {
        if (!$this->questionChoices->contains($questionChoice)) {
            $this->questionChoices->add($questionChoice);
        }

        return $this->questionChoices;
    }

    public function removeQuestionChoice(QuestionChoice $questionChoice): ArrayCollection
    {
        if ($this->questionChoices->contains($questionChoice)) {
            $this->questionChoices->removeElement($questionChoice);
        }

        return $this->questionChoices;
    }
}
