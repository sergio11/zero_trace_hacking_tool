<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* @ORM\Table(name="terms")
* @ORM\Entity
*/
class Term implements BlogTermInterface
{
    const CATEGORY = "category";
    const TAG = "tag";
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=300, nullable=false)
     */
    protected $title;
    /**
     * @Gedmo\Slug(fields={"title"}, unique=true, updatable=false)
     * @ORM\Column(type="string")
     */
    protected $slug;
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
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }
    function __toString()
    {
        return $this->getTitle();
    }
}
