<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use AppBundle\Entity\ArticleInterface;
use AppBundle\Entity\Comment;

class CommentRepository extends EntityRepository
{
    public function findByArticle(ArticleInterface $article, $order)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.article = :article')
            ->addOrderBy('c.id', $order)
            ->setParameter('article', $article)
            ->getQuery();
        return $query->getResult();
    }
    public function findCountByArticle(ArticleInterface $article)
    {
        $query = $this->createQueryBuilder('c')
            ->select('COUNT(c)')
            ->andWhere('c.article = :article')
            ->andWhere('c.status = :status')
            ->setParameters(array(
                'article' => $article,
                'status' => Comment::STATUS_ACTIVE
            ))
            ->getQuery();
        $result = $query->getSingleScalarResult();
        return  $result ? $result : 0;
    }
    public function  getSortableQuery($orderBy, $order)
    {
        $query = $this->createQueryBuilder('c');
        if($orderBy)
        {
            switch($orderBy)
            {
                case 'displayname':
                    $query
                        ->addSelect('(CASE WHEN (c.name IS NULL) THEN CONCAT(profile.firstName, \' \', profile.lastName) ELSE c.name END) AS sorter')
                        ->leftJoin('c.author', 'author')
                        ->leftJoin('author.profile', 'profile')
                        ->orderBy('sorter', $order);
                    break;
                case 'email':
                    $query
                        ->addSelect('(CASE WHEN (c.email IS NULL) THEN author.email  ELSE c.email END) AS sorter')
                        ->leftJoin('c.author', 'author')
                        ->orderBy('sorter', $order);
                    break;
                case 'author_status':
                    $query
                        ->addSelect('(CASE WHEN (c.author IS NULL) THEN \'Public user\'  ELSE \'Registered user\' END) AS sorter')
                        ->leftJoin('c.author', 'author')
                        ->orderBy('sorter', $order);
                    break;
                case 'article':
                    $query
                        ->leftJoin('c.article', 'article')
                        ->orderBy('article.title', $order);
                    break;
                case 'status':
                    $query
                        ->addSelect('(CASE WHEN (c.status= :statusActive) THEN \'Approved\'  ELSE \'Waiting for approval\' END) AS sorter')
                        ->orderBy('sorter', $order)
                        ->setParameter('statusActive', Comment::STATUS_ACTIVE);
                    break;
                default:
                    $query->addOrderBy("c.$orderBy", $order);
                    break;
            }
        }
        return $query;
    }
    public function removeAll()
    {
        $commentClass = $this->_entityName;
        $q = $this->getEntityManager()
            ->createQuery("delete from $commentClass");
        $numDeleted = $q->execute();
        return $numDeleted;
    }
}
