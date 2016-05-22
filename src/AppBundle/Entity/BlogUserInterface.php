<?php

namespace AppBundle\Entity;

interface BlogUserInterface
{
    public function getBlogDisplayName();
    public function setBlogDisplayName($blogDisplayName);
}
