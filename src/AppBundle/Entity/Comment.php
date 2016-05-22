<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ArticleCommenterInterface;
use AppBundle\Entity\ArticleInterface;
use AppBundle\Entity\CommentInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Table(name="comments")
* @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
*/
class Comment implements CommentInterface
{
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 0;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "Comment name and surname should be at least {{ limit }} characters long",
     *      maxMessage = "Comment name and surname should not be longer than {{ limit }} characters"
     * )
     */
    protected $name;
    /**
     * @ORM\Column(type="string", length=3000, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 3000,
     *      minMessage = "Comment should be at least {{ limit }} characters long",
     *      maxMessage = "Comment should not be longer than {{ limit }} characters"
     * )
     */
    protected $comment;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CommentInterface")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $parent;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArticleInterface", inversedBy="comments")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $article;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $status;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $email;
    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;
    /**
     * @ORM\Column(name="modified_at", type="datetime", nullable=false)
     */
    protected $modifiedAt;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArticleCommenterInterface")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     * @var ArticleCommenterInterface
     */
    protected $author;
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
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }
    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
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
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function setParent(CommentInterface $parent)
    {
        $this->parent = $parent;
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
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function setAuthor(ArticleCommenterInterface $author=null)
    {
        $this->author = $author;
        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }
}
