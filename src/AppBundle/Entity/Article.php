<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ArticleInterface;
use AppBundle\Entity\BlogUserInterface;
use AppBundle\Entity\CommentInterface;
use AppBundle\Entity\ArticleMetaInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* @ORM\Table(name="articles")
* @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
*/
class Article implements ArticleInterface
{
    const EXCERPT_LENGTH = 140;
    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFTED = 'draft';
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "Article title should be at least {{ limit }} characters long",
     *      maxMessage = "Article title should not be longer than {{ limit }} characters"
     * )
     */
    protected $title;
    /**
     * @ORM\Column(type="string", length=140, nullable=true)
     * @Assert\Length(
     *      max = 140,
     *      maxMessage = "Article excerpt should not be longer than {{ limit }} characters"
     * )
     */
    protected $excerpt;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank(
        message = "Please enter some article content"
     * )
     */
    protected $content;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArticleInterface")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $parent;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $status;
    /**
     * @ORM\Column(name="published_at", type="datetime", nullable=true)
     */
    protected $publishedAt;
    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;
    /**
     * @ORM\Column(name="modified_at", type="datetime", nullable=false)
     */
    protected $modifiedAt;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BlogUserInterface")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * @var BlogUserInterface
     */
    protected $author;
    /**
     * @Gedmo\Slug(fields={"title"}, unique=true, updatable=false)
     * @ORM\Column(type="string")
     */
    protected $slug;
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\BlogTaxonomyInterface", inversedBy="articles")
     * @ORM\JoinTable(name="article_category_relation",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")})
     *
     */
    protected $categories;
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\BlogTaxonomyInterface", inversedBy="tagged")
     * @ORM\JoinTable(name="article_tags_relation",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")})
     *
     */
    protected $tags;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CommentInterface", mappedBy="article")
     */
    protected $comments;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ArticleMetaInterface", mappedBy="article", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $metaData;
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setModifiedAt(new \DateTime(date('Y-m-d H:i:s')));
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        }
    }
    function __construct(){
        $this->categories = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->metaData = new ArrayCollection();
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set status
     *
     * @param string $status
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
    /**
     * Get status
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Article
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function __toString()
    {
        return $this->content;
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
    public function getExcerpt()
    {
        return $this->excerpt;
    }
    /**
     * Use this over getExcept in frontend display
     * @return mixed
     */
    public function getExcerptText()
    {
        if($this->excerpt)
        {
            return $this->excerpt;
        }
        else
        {
            $rowExcerpt = strip_tags($this->content);
            if( strlen($rowExcerpt) > self::EXCERPT_LENGTH)
            {
                $break = strpos($rowExcerpt, ' ', self::EXCERPT_LENGTH - 10);
                $rowExcerpt = substr($rowExcerpt, 0, $break) . '...';
            }
            return $rowExcerpt;
        }
    }
    /**
     * @param mixed $excerpt
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
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
    public function setParent(ArticleInterface $parent=null)
    {
        $this->parent = $parent;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }
    /**
     * @param mixed $publishedAt
     */
    public function setPublishedAt(\DateTime $publishedAt)
    {
        $this->publishedAt = $publishedAt;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }
    /**
     * @param mixed $modifiedAt
     */
    public function setModifiedAt(\DateTime $modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }
    /**
     * @param mixed $author
     */
    public function setAuthor(BlogUserInterface $author)
    {
        $this->author = $author;
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
    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }
    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getExcerptPhoto()
    {
        return $this->excerptPhoto;
    }
    /**
     * @param mixed $excerptPhoto
     */
    public function setExcerptPhoto($excerptPhoto)
    {
        $this->excerptPhoto = $excerptPhoto;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }
    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }
    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }
    public function addComment(CommentInterface $comment)
    {
        if(!$this->comments->contains($comment))
        {
            $comment->setArticle($this);
            $this->comments->add($comment);
        }
    }
    public function removeComment(CommentInterface $comment)
    {
        if($this->comments->contains($comment))
        {
            $comment->setArticle(null);
            $this->comments->removeElement($comment);
        }
    }
    /**
     * This method returns feed item title
     *
     *
     * @return string
     */
    public function getFeedItemTitle()
    {
        return $this->getTitle();
    }
    /**
     * This method returns feed item description (or content)
     *
     *
     * @return string
     */
    public function getFeedItemDescription()
    {
        return $this->getExcerpt();
    }
    /**
     * This method returns the anchor to be appended on this item's url
     *
     *
     * @return string The anchor, without the "#"
     */
    public function getFeedItemUrlAnchor()
    {
        return "";
    }
    /**
     * This method returns item publication date
     *
     *
     * @return \DateTime
     */
    public function getFeedItemPubDate()
    {
        return $this->getPublishedAt();
    }
    /**
     * This method returns the name of the route
     *
     *
     * @return string
     */
    public function getFeedItemRouteName()
    {
        return "ed_blog_admin_article_show";
    }
    /**
     * This method returns the parameters for the route.
     *
     *
     * @return array
     */
    public function getFeedItemRouteParameters()
    {
        return array( "slug" => $this->getSlug() );
    }
    /**
     * @return mixed
     */
    public function getMetaData()
    {
        return $this->metaData;
    }
    /**
     * @param mixed $metaData
     */
    public function setMetaData($metaData)
    {
        foreach($metaData as $meta)
        {
            $meta->setArticle($this);
            $this->addMetaData($meta);
        }
        return $this;
    }
    /**
     * @param ArticleMetaInterface $metaData
     * @return $this
     */
    public function addMetaData(ArticleMetaInterface $metaData)
    {
        if(!$this->metaData->contains($metaData))
        {
            $metaData->setArticle($this);
            $this->metaData->add($metaData);
        }
        return $this;
    }
    /**
     * @param ArticleMetaInterface $metaData
     * @return $this
     */
    public function removeMetaData(ArticleMetaInterface $metaData)
    {
        if($this->metaData->contains($metaData))
        {
            $metaData->setArticle(null);
            $this->metaData->removeElement($metaData);
        }
        return $this;
    }
    /**
     * Checks by key and value fields
     * For full object comparison use $this->metaData->contains($metaData)
     *
     * @param ArticleMetaInterface $metaData
     * @return bool
     */
    public function hasMetaData(ArticleMetaInterface $metaData)
    {
        $result = false;
        foreach($this->metaData as $meta)
        {
            if($meta->getKey() == $metaData->getKey() && $meta->getValue() == $metaData->getValue())
            {
                $result = true;
                break;
            }
        }
        return $result;
    }
    public function getMetaByKey($key)
    {
        $result = false;
        foreach($this->metaData as $meta)
        {
            if($meta->getKey() == $key)
            {
                $result = $meta;
                break;
            }
        }
        return $result;
    }
}
