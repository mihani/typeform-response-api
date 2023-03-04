<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @author mihani <maud.remoriquet@gmail.com>
 *
 * @ORM\Entity
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class FormatedAnswer
{
    use TimestampableEntity;
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
     * This uuid is the groupByToken answer property.
     *
     * @ORM\Column(type="string", name="uuid", unique=true)
     */
    private string $uuid;

    /**
     * @ORM\Column(type="string", name="name")
     */
    private string $name;

    /**
     * @ORM\Column(type="string", name="email")
     */
    private string $email;

    /**
     * @ORM\Column(type="string", name="company_description")
     */
    private string $companyDescription;

    /**
     * @ORM\Column(type="string", name="contact_reason")
     */
    private string $contactReason;

    /**
     * @ORM\Column(type="boolean", name="cooptation", options={"default": false})
     */
    private bool $cooptation;

    /**
     * @ORM\Column(type="boolean", name="outdated", options={"default": false})
     */
    private bool $outdated;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $receivedAt;

    public function __construct()
    {
        $this->cooptation = false;
        $this->outdated = false;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): FormatedAnswer
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): FormatedAnswer
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): FormatedAnswer
    {
        $this->email = $email;

        return $this;
    }

    public function getCompanyDescription(): string
    {
        return $this->companyDescription;
    }

    public function setCompanyDescription(string $companyDescription): FormatedAnswer
    {
        $this->companyDescription = $companyDescription;

        return $this;
    }

    public function getContactReason(): ?string
    {
        return $this->contactReason;
    }

    public function setContactReason(?string $contactReason): FormatedAnswer
    {
        $this->contactReason = is_null($contactReason) ? '' : $contactReason;

        return $this;
    }

    public function isCooptation(): bool
    {
        return $this->cooptation;
    }

    public function setCooptation(bool $cooptation): FormatedAnswer
    {
        $this->cooptation = $cooptation;

        return $this;
    }

    public function isOutdated(): bool
    {
        return $this->outdated;
    }

    public function setOutdated(bool $outdated): FormatedAnswer
    {
        $this->outdated = $outdated;

        return $this;
    }

    public function getReceivedAt(): \DateTime
    {
        return $this->receivedAt;
    }

    public function setReceivedAt(\DateTime $receivedAt): FormatedAnswer
    {
        $this->receivedAt = $receivedAt;

        return $this;
    }
}
