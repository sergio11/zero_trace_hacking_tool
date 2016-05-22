<?php

namespace AppBundle\Entity;

interface BlogTermInterface
{
    public function getTitle();
    public function setTitle($title);
    public function getSlug();
    public function setSlug($slug);
}
