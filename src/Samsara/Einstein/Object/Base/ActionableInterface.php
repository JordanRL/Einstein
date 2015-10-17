<?php

namespace Samsara\Einstein\Object\Base;

use Samsara\Newton\Units\Time;
use Samsara\Newton\Core\Quantity;
use Samsara\Newton\Core\UnitComposition;

interface ActionableInterface
{

    public function addAction(Time $time, $actionMethod, Quantity $quantity);

    public function elapse(Time $time);

    /**
     * @return UnitComposition
     */
    public function getUnitComposition();

}