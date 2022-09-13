<?php

namespace App\Entity;

use App\Repository\CommandeProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeProduitRepository::class)]
class CommandeProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandeProduits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?commande $idCommande = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?produit $idProduit = null;

    #[ORM\Column]
    private ?float $quantity = null;

    #[ORM\Column]
    private ?float $total = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCommande(): ?commande
    {
        return $this->idCommande;
    }

    public function setIdCommande(?commande $idCommande): self
    {
        $this->idCommande = $idCommande;

        return $this;
    }

    public function getIdProduit(): ?produit
    {
        return $this->idProduit;
    }

    public function setIdProduit(?produit $idProduit): self
    {
        $this->idProduit = $idProduit;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }
}
