<?php

namespace Samsara\Einstein\Action\Physics;

use Samsara\Einstein\Action\Base\ActionInterface;
use Samsara\Einstein\Object\Base\ActionableInterface;
use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Force;
use Samsara\Newton\Units\Time;

class ThrustAction implements ActionInterface
{

    public function invoke($force, $time, ActionableInterface $object)
    {
        if (!($force instanceof Force) && is_numeric($force)) {
            $force = $object->getUnitComposition()->getUnitClass(UnitComposition::FORCE, $force);
        } elseif (!($force instanceof Force)) {
            throw new \Exception('Force must be either a number or an instance of a Force unit.');
        }

        if (!($time instanceof Time) && is_numeric($time)) {
            $time = $object->getUnitComposition()->getUnitClass(UnitComposition::TIME, $time);
        } elseif (!($force instanceof Time)) {
            throw new \Exception('Time must be either a number or an instance of a Time unit.');
        }

        return $object->addAction($time, 'thrust', $force);
    }

}