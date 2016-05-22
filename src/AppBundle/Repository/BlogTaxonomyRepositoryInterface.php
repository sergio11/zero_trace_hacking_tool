<?php

namespace AppBundle\Repository;

use AppBundle\Entity\BlogTaxonomyInterface;

interface BlogTaxonomyRepositoryInterface
{
    /**
     * Finds Taxonomy by Term slug
     * @param $slug
     * @return mixed
     */
    public function findBySlug($slug);
    public function getAllCategories();
    public function getAllParentCategories();
    public function getArticleCategoryCount($categoryIds);
    public function getAllTags();
    public function getArticleTagCount($tagIds);
    public function updateTaxonomyCount(BlogTaxonomyInterface $taxonomy, $count);
    public function getSortableQuery($orderBy, $order);
    public function removeAll();
    public function getTagByTitles($tagTitles);
    public function getTopNTags($number);
}
