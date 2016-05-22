<?php

namespace AppBundle\Entity;

interface BlogTaxonomyInterface
{
    public function getTerm();
    public function setTerm(BlogTermInterface $term);
    public function getType();
    public function setType($type);
    public function getParent();
    public function setParent(BlogTaxonomyInterface $parent=null);
    public function getCount();
    public function setCount($value);
    public function getDescription();
    public function setDescription($description);
    public function getChildren();
    public function setChildren($children);
    public function getArticles();
    public function setArticles($articles);
    public function getTagged();
    public function setTagged($tagged);
}
