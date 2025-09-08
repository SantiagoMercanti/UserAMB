<?php
namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /** Guardar/actualizar */
    public function save(User $user, bool $flush = true): void
    {
        $em = $this->getEntityManager();
        $em->persist($user);
        if ($flush) {
            $em->flush();
        }
    }

    /** Buscar por DNI (único) */
    public function findByDni(string $dni): ?User
    {
        return $this->findOneBy(['dni' => $dni]);
    }

    /** Listar solo activos (baja lógica) */
    public function findActivos(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.activo = :a')
            ->setParameter('a', true)
            ->orderBy('u.apellido', 'ASC')
            ->addOrderBy('u.nombre', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
