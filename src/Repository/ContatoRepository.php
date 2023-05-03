<?php

namespace App\Repository;

use App\Entity\Contato,
    Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository,
    Doctrine\Persistence\ManagerRegistry;

/**
 * Model de "Contato"
 * @author - Luiz Fernando Petris 
 * @since - 02/05/2023
 * @extends ServiceEntityRepository<Contato>
 *
 * @method Contato|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contato|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contato[]    findAll()
 * @method Contato[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContatoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contato::class);
    }

    public function save(Contato $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Contato $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
