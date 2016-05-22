<?php

namespace ED\BlogBundle\Model\Repository;
use Doctrine\ORM\EntityRepository;
use ED\BlogBundle\Interfaces\Model\BlogUserInterface;
use ED\BlogBundle\Interfaces\Repository\BlogUserRepositoryInterface;
use Doctrine\ORM\Mapping;
use ED\BlogBundle\Model\Entity\Article;
class UserRepository extends EntityRepository implements BlogUserRepositoryInterface
{
    public function getNumberOfActiveBlogs(BlogUserInterface $user)
    {
        $query = "SELECT COUNT(a) FROM AppBundle:Article a
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

    public function getSortableQuery($orderBy, $order, $articleClass='YourAppBundle:User')
    {
        $query = $this
            ->createQueryBuilder('u')
            ->where('u.roles like :type');
        if($orderBy && $order)
        {
            switch ($orderBy) {
                case 'role':
                    $query
                        ->addSelect('
                        (CASE
                            WHEN (u.roles LIKE :roleAdmin) THEN \'administrator\'
                            ELSE
                            (CASE
                                WHEN (u.roles LIKE :roleEditor) THEN \'editor\'
                                ELSE
                                (CASE
                                    WHEN (u.roles LIKE :roleAuthor) THEN \'author\'
                                    ELSE
                                    (CASE
                                        WHEN (u.roles LIKE :roleContributor) THEN \'contributor\'
                                        ELSE
                                            \'contributor\'
                                     END)
                                END)
                            END)
                        END) AS sorter')
                        ->orderBy('sorter', $order)
                        ->setParameters(array(
                            'roleAdmin' => '%ROLE_BLOG_ADMIN%',
                            'roleEditor' => '%ROLE_BLOG_EDITOR%',
                            'roleAuthor' => '%ROLE_BLOG_AUTHOR%',
                            'roleContributor' => '%ROLE_BLOG_CONTRIBUTOR%'
                        ));
                    break;
                case 'posts':
                    $userClass = $this->_entityName;
                    $sql = "SELECT author,
                              ( SELECT COUNT(article)
                                FROM $articleClass article
                                WHERE article.status =:published
                                  AND article.publishedAt <= :cur
                                  AND article.author = author
                              )  AS sorter
                            FROM $userClass author
                            WHERE author.roles LIKE :type
                            ORDER BY sorter $order";
                    $query = $this->getEntityManager()
                        ->createQuery($sql)
                        ->setParameters(array(
                            'published' => Article::STATUS_PUBLISHED,
                            'cur' => new \DateTime(),
                            'type' => '%ROLE_BLOG_USER%'
                        ));
                    break;
                default:
                    $query->orderBy("u.$orderBy", $order);
                    break;
            }
        }
        $query
            ->setParameter('type', '%ROLE_BLOG_USER%' );
        return $query;
    }
}
