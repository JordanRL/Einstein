<?php

namespace Samsara\Einstein\Object\Base;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Planck\Node\Node;

abstract class BaseObject
{

    /**
     * @var UnitComposition
     */
    private $unitComposition;

    /**
     * @var Node
     */
    private $node;

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

    public function setNode(Node $node)
    {
        $this->node = $node;

        return $this;
    }

    public function getNode()
    {
        return $this->node;
    }

}