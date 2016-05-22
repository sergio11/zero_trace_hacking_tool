<?php

namespace AppBundle\Entity;

use AppBundle\Entity\BlogUserInterface;
use AppBundle\Entity\ArticleCommenterInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser implements BlogUserInterface, ArticleCommenterInterface
{

  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
   protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    /**
     * Required by BlogUserInterface
     *
     * @ORM\Column(name="blog_display_name", type="string")
     */
    protected $blogDisplayName;

    public function getBlogDisplayName()
    {
        return $this->blogDisplayName;
    }

    public function setBlogDisplayName($blogDisplayName)
    {
        $this->blogDisplayName = $blogDisplayName;

        return $this;
    }

    public function getCommenterDisplayName()
    {
        return $this->blogDisplayName;
    }
}
