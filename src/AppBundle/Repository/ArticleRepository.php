<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use AppBundle\Entity\BlogUserInterface;
use AppBundle\Entity\Article;
use AppBundle\Repository\ArticleRepositoryInterface;
use AppBundle\Entity\Taxonomy;

/**
 * ArticleRepository
 */
class ArticleRepository extends EntityRepository implements ArticleRepositoryInterface
{
    public function getNumberOfActiveBlogs(BlogUserInterface $user)
    {
        $articleClass = $this->_entityName;
        $query = "SELECT COUNT(a) FROM $articleClass a
                  INNER JOIN a.author au
                  WHERE a.status= :published AND a.publishedAt <= :cur
                  AND au= :user
                  ";
        $results = $this->getEntityManager()
            ->createQuery($query)
            ->setParameter("published", Article::STATUS_PUBLISHED)
            ->setParameter('cur',  new \DateTime())
            ->setParameter('user', $user);
        return $results->useQueryCache(true)->setQueryCacheLifetime(60)->getSingleScalarResult();
    }
    public function getActiveArticles($limit = null)
    {
        $articleClass = $this->_entityName;
        $query = "SELECT a FROM $articleClass a
                  WHERE a.status= :published AND a.publishedAt <= :cur
                  ORDER BY a.publishedAt DESC"
        ;
        $query = $this->getEntityManager()
            ->createQuery($query)
            ->setParameter("published", Article::STATUS_PUBLISHED)
            ->setParameter('cur',  new \DateTime());
        if($limit)
        {
            $query->setMaxResults($limit);
        }
        $articles = $query->useQueryCache(true)->setQueryCacheLifetime(60)->getResult();
        return $articles;
    }
    public function getActiveArticlesByTaxonomy($taxonomySlug, $type, $limit = null)
    {
        $articleClass = $this->_entityName;
        $query = "SELECT a FROM $articleClass a";
        if ($type == Taxonomy::TYPE_TAG)
        {
            $query.=" INNER JOIN a.tags tr";
        }else
        {
            $query.=" INNER JOIN a.categories tr";
        }
        $query.=" INNER JOIN tr.term t
                  WHERE a.status= :published AND a.publishedAt <= :cur
                  AND tr.type=:type AND t.slug=:taxonomySlug
                  ORDER BY a.publishedAt DESC"
        ;
        $query = $this->getEntityManager()
            ->createQuery($query)
            ->setParameter("published", Article::STATUS_PUBLISHED)
            ->setParameter('cur',  new \DateTime())
            ->setParameter("type",$type)
            ->setParameter('taxonomySlug',$taxonomySlug);
        if($limit)
        {
            $query->setMaxResults($limit);
        }
        $articles = $query->useQueryCache(true)->setQueryCacheLifetime(60)->getResult();
        return $articles;
    }
    public function getActiveArticlesByAuthor(BlogUserInterface $author, $limit = null)
    {
        $articleClass = $this->_entityName;
        $query = "SELECT a FROM $articleClass a
                  INNER JOIN a.author u
                  WHERE a.status= :published AND a.publishedAt <= :cur
                  AND a.author = :author_id
                  ORDER BY a.publishedAt DESC"
        ;
        $query = $this->getEntityManager()
            ->createQuery($query)
            ->setParameter("published", Article::STATUS_PUBLISHED)
            ->setParameter('cur',  new \DateTime())
            ->setParameter('author_id', $author->getId());
        if($limit)
        {
            $query->setMaxResults($limit);
        }
        $articles = $query->useQueryCache(true)->setQueryCacheLifetime(60)->getResult();
        return $articles;
    }
    public function removeAll()
    {
        $articleClass = $this->_entityName;
        $q = $this->getEntityManager()
            ->createQuery("delete from $articleClass");
        $numDeleted = $q->execute();
        return $numDeleted;
    }
    public function getArticlesInOneMonth($year, $month, $limit = null)
    {
        $articleClass = $this->_entityName;
        $query = "SELECT a FROM $articleClass a
                  INNER JOIN a.author u
                  WHERE a.status= :published AND a.publishedAt <= :cur
                  AND a.publishedAt >= :interval_start
                  AND a.publishedAt < :interval_end
                  ORDER BY a.publishedAt DESC"
        ;
        $intervalStart=$this->getDateTimeFromParams($year,$month);
        $query = $this->getEntityManager()
            ->createQuery($query)
            ->setParameter("published", Article::STATUS_PUBLISHED)
            ->setParameter('cur',  new \DateTime())
            ->setParameter('interval_start',$intervalStart->format('Y-m-d H:i:s'))
            ->setParameter('interval_end',$intervalStart->modify('+1 month')->format('Y-m-d H:i:s'));
        if($limit)
        {
            $query->setMaxResults($limit);
        }
        $articles = $query->useQueryCache(true)->setQueryCacheLifetime(60)->getResult();
        return $articles;
    }
    public function getYearsMonthsOfArticles()
    {
        $tableName = $this->getClassMetadata()->table['name'];
        $sql = "SELECT YEAR(published_at) as year, MONTH(published_at) as month, COUNT(*) as num
                FROM $tableName
                WHERE status = 'published'
                GROUP BY YEAR(published_at), MONTH(published_at)
                ORDER BY year DESC, month DESC";
        $query = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $query->execute();
        $articles = $query->fetchAll();
        return $articles;
    }
    private function getDateTimeFromParams($year, $month)
    {
        if(!((int)$year == $year && (int)$year > 0 && $month && (int)$month == $month && (int)$month > 0 && (int)$month <= 12))
        {
            throw new \Exception("Invalid value for year and month pair.");
        }
        return new \DateTime($year.'-'.$month.'-01');
    }
    public function getArticlesList()
    {
        $articleClass = $this->_entityName;
        $query = "SELECT a FROM $articleClass a
                  WHERE a.parent IS NULL
                  ORDER BY a.modifiedAt DESC";
        $query = $this->getEntityManager()
            ->createQuery($query);
        return $query->getResult();
    }
    public function getSortableQuery($orderBy=null, $order='desc')
    {
        $articleClass = $this->_entityName;
        $query = "SELECT a FROM $articleClass a
                  WHERE a.parent IS NULL";
        switch ($orderBy)
        {
            case 'title':
                $query.= ($order=='asc')? " ORDER BY a.title asc" : " ORDER BY a.title desc";
                break;
            case 'author':
                $articleClass = $this->_entityName;
                $query= "SELECT a FROM $articleClass a
                         INNER JOIN a.author u
                         INNER JOIN u.profile p
                         WHERE a.parent IS NULL";
                $query.= ($order=='asc')? " ORDER BY p.firstName asc, p.lastName asc" : " ORDER BY p.firstName desc, p.lastName desc";
                break;
            case 'status':
                $query .= " ORDER BY a.status $order";
                break;
            case 'date':
                $query.= ($order=='asc')? " ORDER BY a.modifiedAt asc" : " ORDER BY a.modifiedAt desc";
                break;
            default:
                $query.=" ORDER BY a.modifiedAt desc";
        }
        $query = $this->getEntityManager()
            ->createQuery($query);
        return $query->getResult();
    }
}
