<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


/**
 * PurchaseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PurchaseRepository extends EntityRepository
{
    public function findLastFifteen()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s FROM AppBundle:Purchase s ORDER BY s.id DESC'
            )
            ->setMaxResults(15)
            ->getResult();
    }

    public function findByDate($form){


        $cr = $form->get('cash')->getData();
        $cl = $form->get('person')->getData();

        $creditoLinea = ' ';
        $clienteLinea = ' ';

            $creditoLinea = ' AND p.cash = :cash  ';

        if($cl !== null){
            $clienteLinea = ' AND p.person = :person ' ;
        }

        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p'
                . ' FROM AppBundle:Purchase p '
                . ' WHERE  p.createdAt BETWEEN :initDate and :endDate  '
                . $creditoLinea
                . $clienteLinea
                . ' ORDER BY p.createdAt DESC'
            );

        $query->setParameter('initDate', $form->get('initDate')->getData());
        $query->setParameter('endDate', $form->get('endDate')->getData());

            $query->setParameter('cash', $form->get('cash')->getData());

        if($cl !== null) {
            $query->setParameter('person', $form->get('person')->getData());
        }
        return $query->getResult();

    }

}