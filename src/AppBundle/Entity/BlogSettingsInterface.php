<?php

namespace AppBundle\Entity;

interface BlogSettingsInterface
{
    public function setValue($value);
    public function getValue();
    public function setProperty($property);
    public function getProperty();
}
