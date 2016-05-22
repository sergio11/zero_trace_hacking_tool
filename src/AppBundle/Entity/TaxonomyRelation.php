<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ArticleInterface;
use AppBundle\Entity\BlogTaxonomyInterface;
use AppBundle\Entity\TaxonomyRelationInterface;

/**
* @ORM\Table(name="taxonomy_relations")
* @ORM\Entity
*/
class TaxonomyRelation implements TaxonomyRelationInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArticleInterface", inversedBy="taxonomyRelations")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $article;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BlogTaxonomyInterface")
     * @ORM\JoinColumn(name="taxonomy_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $taxonomy;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }
    /**
     * @param mixed $article
     */
    public function setArticle(ArticleInterface $article)
    {
        $this->article = $article;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getTaxonomy()
    {
        return $this->taxonomy;
    }
    /**
     * @param mixed $taxonomy
     */
    public function setTaxonomy(BlogTaxonomyInterface $taxonomy)
    {
        $this->taxonomy = $taxonomy;
        return $this;
    }
}
