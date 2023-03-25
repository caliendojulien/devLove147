<?php

namespace App\Repository;

use App\Entity\Developpeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method Developpeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Developpeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Developpeur[]    findAll()
 * @method Developpeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeveloppeurRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Developpeur::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Developpeur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findByLangage($langage)
    {
        return $this->createQueryBuilder('d')
            ->andWhere(':langage MEMBER OF d.langages')
            ->setParameter('langage', $langage)
            ->orderBy('d.pseudo', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Developpeur[] Returns an array of Developpeur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Developpeur
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
