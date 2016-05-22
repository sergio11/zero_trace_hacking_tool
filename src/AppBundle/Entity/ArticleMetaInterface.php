<?php

namespace AppBundle\Entity;

interface ArticleMetaInterface
{
    public function setArticle(ArticleInterface $article=null);
    public function getArticle();
    public function setKey($key);
    public function getKey();
    public function setValue($value);
    public function getValue();
}
