<?php

namespace AppBundle\Entity;

interface ArticleInterface
{
    public function setTitle($title);
    public function getTitle();
    public function setContent($content);
    public function getContent();
    public function setExcerpt($excerpt);
    public function getExcerpt();
    public function setSlug($slug);
    public function getSlug();
    public function setStatus($status);
    public function getStatus();
    public function setPublishedAt(\DateTime $publishedAt);
    public function getPublishedAt();
    public function setModifiedAt(\DateTime $modifiedAt);
    public function getModifiedAt();
    public function setAuthor(BlogUserInterface $author);
    public function getAuthor();
    public function setMetaData($metaData);
    public function getMetaData();
    public function setParent(ArticleInterface $parent=null);
    public function getParent();
    public function setCategories($categories);
    public function getCategories();
    public function setTags($tags);
    public function getTags();
    public function setComments($comments);
    public function getComments();
}
