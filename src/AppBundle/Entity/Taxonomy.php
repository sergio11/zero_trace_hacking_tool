<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\BlogTaxonomyInterface;
use AppBundle\Entity\BlogTermInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
* @ORM\Table(name="taxonomies")
* @ORM\Entity(repositoryClass="AppBundle\Repository\TaxonomyRepository")
*/
class Taxonomy implements BlogTaxonomyInterface
{
    const TYPE_CATEGORY = "category";
    const TYPE_TAG = "tag";
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\BlogTermInterface", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="term_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $term;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $type;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BlogTaxonomyInterface", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    protected $parent;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\BlogTaxonomyInterface", mappedBy="parent")
     */
    protected $children;
    /**
     * Articles in the taxonomy
     *
     * @ORM\Column(type="integer", nullable=true, options={"default" = 0})
     */
    protected $count;
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ArticleInterface", mappedBy="categories")
     *
     */
    protected $articles;
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ArticleInterface", mappedBy="tags")
     *
     */
    protected $tagged;
    function __construct()
    {
        $this->children = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->tagged = new ArrayCollection();
    }
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
    public function getTerm()
    {
        return $this->term;
    }
    /**
     * @param mixed $term
     */
    public function setTerm(BlogTermInterface $term)
    {
        $this->term = $term;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * @param mixed $parent
     */
    public function setParent(BlogTaxonomyInterface $parent=null)
    {
        $this->parent = $parent;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }
    /**
     * @param mixed $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }
    /**
     * @param mixed $count
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    public function __toString()
    {
        return $this->getTerm()->__toString();
    }
    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }
    /**
     * @param mixed $articles
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getTagged()
    {
        return $this->tagged;
    }
    /**
     * @param mixed $tagged
     */
    public function setTagged($tagged)
    {
        $this->tagged = $tagged;
        return $this;
    }
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        $parentTaxon = $this->getParent();
        while($parentTaxon)
        {
            if($parentTaxon == $this)
            {
                $context->buildViolation('Circular taxonomy reference detected. Please check your parent taxonomy.')
                    ->atPath('parent')
                    ->addViolation();
                break;
            }
            $parentTaxon = $parentTaxon->getParent();
        }
    }
}
