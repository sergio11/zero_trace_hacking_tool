<?php

namespace AppBundle\Repository;

use AppBundle\Entity\ArticleInterface;

interface CommentRepositoryInterface
{
    /**
     * Get approved comments per article
     *
     * @param ArticleInterface $article
     * @param $order
     * @return mixed
     */
    public function findByArticle(ArticleInterface $article, $order);
    /**
     * Get number of approved comments per article
     *
     * @param ArticleInterface $article
     * @return mixed
     */
    public function findCountByArticle(ArticleInterface $article);
    /**
     * Will be used to display comments on Blog Administration list page
     *
     * @param $orderBy
     * @param $order
     * @return array
     */
    public function  getSortableQuery($orderBy, $order);
}
