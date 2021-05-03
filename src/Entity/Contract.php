<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContractRepository::class)
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
     * @ORM\Column(type="integer")
     */
    private $num_contrat;

    /**
     * @ORM\Column(type="array")
     */
    private $info_client = [];

    /**
     * @ORM\Column(type="array")
     */
    private $info_declaration = [];

    /**
     * @ORM\Column(type="smallint")
     */
    private $numero_verif;

    /**
     * @ORM\Column(type="array")
     */
    private $info_prelevement = [];

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

    public function getNumContrat(): ?int
    {
        return $this->num_contrat;
    }

    public function setNumContrat(int $num_contrat): self
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

    public function getInfoDeclaration(): ?array
    {
        return $this->info_declaration;
    }

    public function setInfoDeclaration(array $info_declaration): self
    {
        $this->info_declaration = $info_declaration;

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
}
