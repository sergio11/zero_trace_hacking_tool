<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ArticleInterface;

/**
* @ORM\Table(name="articles_meta")
* @ORM\Entity
*/
class ArticleMeta implements ArticleMetaInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArticleInterface", inversedBy="metaData")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $article;
    /**
     * @ORM\Column(name="meta_key", type="string")
     */
    protected $key;
    /**
     * @ORM\Column(name="meta_value", type="string")
     */
    protected $value;
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
    public function setArticle(ArticleInterface $article=null)
    {
        $this->article = $article;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }
    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
