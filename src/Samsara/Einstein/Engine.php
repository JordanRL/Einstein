<?php

namespace Samsara\Einstein;

use Samsara\Einstein\Action\Base\ActionInterface;
use Samsara\Einstein\Exception\EngineException;
use Samsara\Einstein\Object\Base\BaseObject;
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

    /**
     * @param GridInterface   $grid
     * @param UnitComposition $unitComposition
     * @param int|float       $tickLength           This is how much time passes per tick, in seconds.
     *
     * @throws EngineException
     * @throws \Exception
     */
    public function __construct(GridInterface $grid, UnitComposition $unitComposition, $tickLength = 1)
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
        /**
         * @var ActionableInterface $object
         * @var ActionQueue $queue
         */
        foreach ($this->physicsObjects as $object => $queue) {
            $queue->setExtractFlags(ActionQueue::EXTR_BOTH);
            $queue->top();

            $newQueue = new ActionQueue();

            while ($queue->valid()) {
                $data = $queue->current();
                if ($data['priority'] <= $this->tickLength) {
                    // It's time to start a scheduled action
                    /** @var ActionInterface $action */
                    $action = $data['data']['action'];
                    $action->invoke($data['data']['actionUnit'], $data['data']['duration'], $object);
                } else {
                    // Not time yet, wait for the next tick
                    $newQueue->insert($data['data'], ($data['priority'] - $this->tickLength));
                }

                $queue->next();
            }

            $this->physicsObjects->offsetSet($object, $newQueue);

            unset($queue);

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

    public function spawnPhysicsObject(BaseObject $object, $address)
    {
        $node = $this->grid->getNode($address);

        $node->set('obj_'.spl_object_hash($object), $object);

        $object->setNode($node);

        $this->physicsObjects->attach($object, new ActionQueue());

        return $this;
    }

}