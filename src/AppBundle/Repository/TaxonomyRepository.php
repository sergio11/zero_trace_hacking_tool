<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use AppBundle\Entity\BlogTaxonomyInterface;
use AppBundle\Repository\BlogTaxonomyRepositoryInterface;
use AppBundle\Entity\Article;
use AppBundle\Entity\Taxonomy;


class TaxonomyRepository extends EntityRepository implements BlogTaxonomyRepositoryInterface
{
    public function getSortableQuery($orderBy, $order, $type = Taxonomy::TYPE_CATEGORY)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.type = :taxonomy')
            ->setParameter("taxonomy", $type);
        if($orderBy)
        {
            switch ($orderBy)
            {
                case 'title':
                    $query
                        ->innerJoin('c.term', 'term')
                        ->orderBy('term.title', $order);
                    break;
                case 'slug':
                    $query
                        ->innerJoin('c.term', 'term')
                        ->orderBy('term.slug', $order);
                    break;
                case 'parent':
                    $query
                        ->addSelect('(CASE WHEN (parent IS NULL) THEN \' \' ELSE term.title END) AS sorter')
                        ->leftJoin('c.parent', 'parent')
                        ->leftJoin('parent.term', 'term')
                        ->orderBy('sorter', $order);
                    break;
                default:
                    $query->orderBy('c.' . $orderBy, $order);
                    break;
            }
        }
        return $query;
    }
    public function findBySlug($slug)
    {
        $taxonomyClass = $this->_entityName;
        $query = "SELECT tax FROM $taxonomyClass tax
                  INNER JOIN tax.term term
                  WHERE term.slug = :slug
                  ";
        $results = $this->getEntityManager()
            ->createQuery($query)
            ->setParameter("slug", $slug);
        return $results->getOneOrNullResult();
    }
    public function getAllCategories()
    {
        $taxonomyClass = $this->_entityName;
        $query = "SELECT tax FROM $taxonomyClass tax
                  WHERE tax.type = :category
                  ORDER BY tax.id DESC
                  ";
        $results = $this->getEntityManager()
            ->createQuery($query)
            ->setParameter("category", Taxonomy::TYPE_CATEGORY);
        return $results->getResult();
    }
    public function getAllParentCategories()
    {
        $taxonomyClass = $this->_entityName;
        $query = "SELECT tax FROM $taxonomyClass tax
                  WHERE tax.type = :category
                  AND tax.parent IS NULL
                  ORDER BY tax.id DESC
                  ";
        $results = $this->getEntityManager()
            ->createQuery($query)
            ->setParameter("category", Taxonomy::TYPE_CATEGORY);
        return $results->getResult();
    }
    public function removeAll()
    {
        $taxonomyClass = $this->_entityName;
        $q = $this->getEntityManager()
            ->createQuery("delete from $taxonomyClass");
        $numDeleted = $q->execute();
        return $numDeleted;
    }
    public function getArticleCategoryCount($categoryIds = array())
    {
        $taxonomyClass = $this->_entityName;
        $query = "SELECT c, COUNT(a)
                  FROM $taxonomyClass c
                  LEFT JOIN c.articles a
                  WHERE a.status= :published AND a.publishedAt <= :cur
                    AND c.type= :category
                  ";
        if(count($categoryIds))
        {
            $query .= "
                    AND c.id IN (:ids)";
        }
        $query .= "
                    GROUP BY c.id";
        $query = $this->getEntityManager()
            ->createQuery($query)
            ->setParameter("published", Article::STATUS_PUBLISHED)
            ->setParameter('category', Taxonomy::TYPE_CATEGORY)
            ->setParameter('cur', new \DateTime());
        if(count($categoryIds))
        {
            $query = $query->setParameter('ids', is_array($categoryIds) ? $categoryIds : $categoryIds->toArray());
        }
        $result = $query->getResult();
        return $result;
    }
    public function getArticleTagCount($tagIds = array())
    {
        $taxonomyClass = $this->_entityName;
        $query = "SELECT c, COUNT(a)
                  FROM $taxonomyClass c
                  LEFT JOIN c.tagged a
                  WHERE a.status= :published AND a.publishedAt <= :cur
                    AND c.type= :tag
                  ";
        if(count($tagIds))
        {
            $query .= "
                    AND c IN (:ids)";
        }
        $query .= "
                    GROUP BY c.id";
        $query = $this->getEntityManager()
            ->createQuery($query)
            ->setParameter("published", Article::STATUS_PUBLISHED)
            ->setParameter('tag', Taxonomy::TYPE_TAG)
            ->setParameter('cur', new \DateTime());
        if(count($tagIds))
        {
            $query = $query->setParameter('ids', is_array($tagIds) ? $tagIds : $tagIds->toArray());
        }
        $result = $query->getResult();
        return $result;
    }
    public function getTagByTitles($tagTitles)
    {
        $small = array();
        foreach($tagTitles as $tag)
        {
            $small[] = strtolower($tag);
        }
        if(!count($tagTitles))
            return array();
        $taxonomyClass = $this->_entityName;
        $query = "
            SELECT t
            FROM $taxonomyClass t
            INNER JOIN t.term term
            WHERE  LOWER(term.title) IN (:titles) AND t.type = :tagType
                    ";
        $results = $this->getEntityManager()
            ->createQuery($query)
            ->setParameter("titles", $small)
            ->setParameter('tagType', Taxonomy::TYPE_TAG);
        return $results->getResult();
    }
    public function getAllTags()
    {
        $taxonomyClass = $this->_entityName;
        $query = "SELECT tax FROM $taxonomyClass tax
                  WHERE tax.type = :tag
                  ORDER BY tax.id DESC
                  ";
        $results = $this->getEntityManager()
            ->createQuery($query)
            ->setParameter('tag', Taxonomy::TYPE_TAG);
        return $results->getResult();
    }
    public function getTopNTags($number)
    {
        $taxonomyClass = $this->_entityName;
        $query = "SELECT tax FROM $taxonomyClass tax
                  WHERE tax.type = :tag
                    AND tax.count > 0
                  ORDER BY tax.count DESC
                  ";
        $results = $this->getEntityManager()
            ->createQuery($query)
            ->setMaxResults($number)
            ->setParameter('tag', Taxonomy::TYPE_TAG);
        return $results->getResult();
    }
    public function updateTaxonomyCount(BlogTaxonomyInterface $taxonomy, $count)
    {
        $taxonomyClass = $this->_entityName;
        $query = "UPDATE $taxonomyClass tax
                  SET tax.count = :cnt
                  WHERE tax = :tax";
        $query = $this->getEntityManager()
            ->createQuery($query)
            ->setParameters(array(
                "cnt" => $count,
                "tax" => $taxonomy
            ))->execute();
        return $query;
    }
}
