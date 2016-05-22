<?php

namespace AppBundle\Repository;

use AppBundle\Entity\BlogUserInterface;

interface BlogUserRepositoryInterface
{
    /**
     * Number of active users per author
     *
     * @param $user
     * @return mixed
     */
    public function getNumberOfActiveBlogs(BlogUserInterface $user);
    /**
     * Query for Blog administration list page
     *
     * @param $orderBy
     * @param $order
     * @return mixed
     */
    public function getSortableQuery($orderBy, $order);
}
