<?php

namespace App\Repository;

use App\Entity\Pessoa,
    Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository,
    Doctrine\Persistence\ManagerRegistry;

/**
 * Model de "Pessoa"
 * @author - Luiz Fernando Petris 
 * @since - 02/05/2023
 * @extends ServiceEntityRepository<Pessoa>
 *
 * @method Pessoa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pessoa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pessoa[]    findAll()
 * @method Pessoa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PessoaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pessoa::class);
    }

    public function save(Pessoa $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Pessoa $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
