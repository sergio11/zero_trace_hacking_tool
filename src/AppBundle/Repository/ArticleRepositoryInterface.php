<?php

namespace AppBundle\Repository;

use AppBundle\Entity\BlogUserInterface;

interface ArticleRepositoryInterface
{
    public function getArticlesList();
    public function getSortableQuery();
    public function getNumberOfActiveBlogs(BlogUserInterface $user);
    public function getActiveArticles($limit = null);
    public function getActiveArticlesByTaxonomy($taxonomySlug, $type, $limit = null);
    public function getActiveArticlesByAuthor(BlogUserInterface $author, $limit = null);
    public function removeAll();
    public function getArticlesInOneMonth($year, $month, $limit = null);
    public function getYearsMonthsOfArticles();
}
