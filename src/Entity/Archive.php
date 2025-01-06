<?php

namespace App\Entity;

use App\Repository\ArchiveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArchiveRepository::class)]
class Archive
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $filename = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $upload_date = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $upload_by = null;

    #[ORM\ManyToOne(inversedBy: 'archives')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $related_to = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getUploadDate(): ?\DateTimeInterface
    {
        return $this->upload_date;
    }

    public function setUploadDate(\DateTimeInterface $upload_date): static
    {
        $this->upload_date = $upload_date;

        return $this;
    }

    public function getUploadBy(): ?User
    {
        return $this->upload_by;
    }

    public function setUploadBy(?User $upload_by): static
    {
        $this->upload_by = $upload_by;

        return $this;
    }

    public function getRelatedTo(): ?User
    {
        return $this->related_to;
    }

    public function setRelatedTo(?User $related_to): static
    {
        $this->related_to = $related_to;

        return $this;
    }
}
