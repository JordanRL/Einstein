<?php

namespace Samsara\Einstein;

use Samsara\Einstein\Action\Base\ActionInterface;
use Samsara\Einstein\Exception\EngineException;
use Samsara\Newton\Core\Quantity;
use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Time;
use Samsara\Einstein\Object\Base\ActionableInterface;
use Samsara\Planck\Core\GridInterface;
use Samsara\Einstein\Object\ObjectCollection;
use Samsara\Einstein\Action\ActionQueue;

class Engine
{

    /**
     * @var ObjectCollection
     */
    private $physicsObjects;

    /**
     * @var ObjectCollection
     */
    private $nonPhysicsObjects;

    /**
     * @var GridInterface
     */
    private $grid;

    /**
     * @var Time
     */
    private $tickLength;

    /**
     * @var UnitComposition
     */
    private $unitComposition;

    public function __construct(GridInterface $grid, UnitComposition $unitComposition, $tickLength)
    {
        $this->grid = $grid;

        $this->unitComposition = $unitComposition;

        if ($tickLength instanceof Time) {
            $this->tickLength = $tickLength;
        } elseif (is_numeric($tickLength)) {
            $this->tickLength = $this->unitComposition->getUnitClass(UnitComposition::TIME, $tickLength);
        } else {
            throw new EngineException('Invalid tick length.');
        }
    }

    public function tick()
    {
        /** @var ActionableInterface $object */
        foreach ($this->physicsObjects as $object) {
            // TODO: go through physicsObjects, examine each object's queue, start actions scheduled to start
            $object->elapse($this->tickLength);
        }

        /** @var ActionableInterface $npObject */
        foreach ($this->nonPhysicsObjects as $npObject) {
            $npObject->elapse($this->tickLength);
        }
    }

    public function queuePhysicsAction(ActionInterface $action, Quantity $actionUnit, $duration, $startAfter, ActionableInterface $object)
    {
        if (!$this->physicsObjects->offsetExists($object)) {
            throw new EngineException('Cannot queue actions for non-existent objects.');
        }

        /** @var ActionQueue $data */
        $data = $this->physicsObjects->offsetGet($object);

        $data->insert(['action' => $action, 'actionUnit' => $actionUnit, 'duration' => $duration], $startAfter);

        $this->physicsObjects->offsetSet($object, $data);

        return $this;
    }

}