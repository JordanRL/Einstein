<?php

namespace Samsara\Einstein\Action\Base;

use Samsara\Einstein\Object\Base\ActionableInterface;

interface ActionInterface
{

    public function invoke($actionUnit, $time, ActionableInterface $object);

}