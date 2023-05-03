<?php

namespace App\Entity;

use App\Repository\PessoaRepository,
    Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: PessoaRepository::class)]
class Pessoa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 14)]
    private ?string $cpf = null;

    #[ORM\OneToMany(mappedBy: 'pessoa', targetEntity: Contato::class)]
    private Collection $contatos;

    public function __construct()
    {
        $this->contatos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * @return Collection<int, Contato>
     */
    public function getContatos(): Collection
    {
        return $this->contatos;
    }

    public function addContato(Contato $contato): self
    {
        if (!$this->contatos->contains($contato)) {
            $this->contatos->add($contato);
            $contato->setPessoa($this);
        }

        return $this;
    }

    public function removeContato(Contato $contato): self
    {
        if ($this->contatos->removeElement($contato)) {
            if ($contato->getPessoa() === $this) {
                $contato->setPessoa(null);
            }
        }

        return $this;
    }
}
