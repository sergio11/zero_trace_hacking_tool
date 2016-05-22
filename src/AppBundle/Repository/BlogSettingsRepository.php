<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use AppBundle\Repository\BlogSettingsRepositoryInterface;

class BlogSettingsRepository extends EntityRepository implements BlogSettingsRepositoryInterface
{
    public function getSettingsArray()
    {
        $settings = $this->createQueryBuilder('s')
            ->select('s.property')
            ->addSelect('s.value')
            ->getQuery();
        return $settings->getResult('SettingsHydrator');
    }
    public function removeAll()
    {
        $blogSettings = $this->_entityName;
        $q = $this->getEntityManager()
            ->createQuery("delete from $blogSettings");
        $numDeleted = $q->execute();
        return $numDeleted;
    }
}
