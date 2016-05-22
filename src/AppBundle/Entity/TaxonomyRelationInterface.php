<?php

namespace AppBundle\Entity;

interface TaxonomyRelationInterface
{
    public function setArticle(ArticleInterface $article);
    public function getArticle();
    public function setTaxonomy(BlogTaxonomyInterface $taxonomy);
    public function getTaxonomy();
}
