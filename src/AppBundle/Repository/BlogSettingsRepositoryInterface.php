<?php

namespace AppBundle\Repository;

interface BlogSettingsRepositoryInterface
{
    public function getSettingsArray();
    public function removeAll();
}
