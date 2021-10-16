<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractRepository", repositoryClass=ContractRepository::class)
 */
class Contract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contracts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $salesman;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $num_contrat;

    /**
     * @ORM\Column(type="json")
     */
    private $info_client = [];


    /**
     * @ORM\Column(type="integer")
     */
    private $numero_verif;

    /**
     * @ORM\Column(type="json")
     */
    private $info_prelevement = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="boolean")
     */
    private $duplicate;

    /**
     * @ORM\Column(type="smallint")
     */
    private $contractType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $audioFileName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalesman(): ?user
    {
        return $this->salesman;
    }

    public function setSalesman(?user $salesman): self
    {
        $this->salesman = $salesman;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getNumContrat(): ?string
    {
        return $this->num_contrat;
    }

    public function setNumContrat(string $num_contrat): self
    {
        $this->num_contrat = $num_contrat;

        return $this;
    }

    public function getInfoClient(): ?array
    {
        return $this->info_client;
    }

    public function setInfoClient(array $info_client): self
    {
        $this->info_client = $info_client;

        return $this;
    }

    public function getNumeroVerif(): ?int
    {
        return $this->numero_verif;
    }

    public function setNumeroVerif(int $numero_verif): self
    {
        $this->numero_verif = $numero_verif;

        return $this;
    }

    public function getInfoPrelevement(): ?array
    {
        return $this->info_prelevement;
    }

    public function setInfoPrelevement(array $info_prelevement): self
    {
        $this->info_prelevement = $info_prelevement;

        return $this;
    }

    public function getCreated(): string
    {
        return $this->created->format('d/m/Y');
    }

    public function getCreatedTimestamp()
    {
        return $this->created->getTimestamp();
    }

    public function setCreated(DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getDuplicate(): ?bool
    {
        return $this->duplicate;
    }

    public function setDuplicate(bool $duplicate): self
    {
        $this->duplicate = $duplicate;

        return $this;
    }

    public function getContractType(): ?int
    {
        return $this->contractType;
    }

    public function setContractType(int $contractType): self
    {
        $this->contractType = $contractType;

        return $this;
    }

    public function getAudioFileName(): ?string
    {
        return $this->audioFileName;
    }

    public function setAudioFileName(?string $audioFileName): self
    {
        $this->audioFileName = $audioFileName;

        return $this;
    }
}
