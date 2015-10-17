<?php

namespace Samsara\Einstein\Object\Base;

use Samsara\Newton\Core\UnitComposition;

abstract class BaseObject
{

    /**
     * @var UnitComposition
     */
    private $unitComposition;

    public function __construct(UnitComposition $unitComposition)
    {
        $this->unitComposition = $unitComposition;
    }

    /**
     * @return UnitComposition
     */
    public function getUnitComposition()
    {
        return $this->unitComposition;
    }

}