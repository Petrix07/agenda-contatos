<?php

namespace App\Entity;

use App\Repository\ContatoRepository,
    Doctrine\DBAL\Types\Types,
    Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContatoRepository::class)]
class Contato
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private $tipo = null;

    #[ORM\Column(length: 255)]
    private ?string $descricao = null;

    #[ORM\ManyToOne(inversedBy: "contatos")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pessoa $pessoa = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?int
    {
        return $this->tipo;
    }

    /**
     * @param $tipo
     */
    public function setTipo($tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getPessoa(): ?Pessoa
    {
        return $this->pessoa;
    }

    public function setPessoa(?Pessoa $pessoa): self
    {
        $this->pessoa = $pessoa;

        return $this;
    }
}
