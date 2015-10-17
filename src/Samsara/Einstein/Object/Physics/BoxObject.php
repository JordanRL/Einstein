<?php

namespace Samsara\Einstein\Object\Physics;

use Samsara\Einstein\Object\Base\ActionableInterface;
use Samsara\Einstein\Object\Base\BaseObject;
use Samsara\Einstein\Object\Base\Compose\ActionableTrait;
use Samsara\Einstein\Object\Base\Compose\ClassicalObjectTrait;
use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Provider\PhysicsProvider;
use Samsara\Newton\Units\Force;
use Samsara\Newton\Units\Length;
use Samsara\Newton\Units\Mass;
use Samsara\Newton\Units\Temperature;
use Samsara\Newton\Units\Time;
use Samsara\Newton\Units\Velocity;
use Samsara\Newton\Units\Momentum;
use Samsara\Newton\Units\Acceleration;

class BoxObject extends BaseObject implements ActionableInterface
{

    use ClassicalObjectTrait;
    use ActionableTrait;

    public function setAllFromCore(Mass $mass, Length $lengthX, Length $lengthY, Length $lengthZ, Temperature $temperature)
    {
        $this->setMass($mass)
            ->setTemperature($temperature)
            ->setLengthX($lengthX, false)
            ->setLengthY($lengthY, false)
            ->setLengthZ($lengthZ);

        /** @var Velocity $velocity */
        $velocity = $this->getUnitComposition()->getUnitClass(UnitComposition::VELOCITY);
        /** @var Momentum $momentum */
        $momentum = $this->getUnitComposition()->getUnitClass(UnitComposition::MOMENTUM);

        $this->setVelocity($velocity)
            ->setMomentum($momentum)
            ->recalculateDensity();

        return $this;
    }

    protected function thrust(Force $thrust, Time $time)
    {
        /** @var Acceleration $acceleration */
        $acceleration = PhysicsProvider::forceMassAccelCalcs($thrust, $this->getMass());

        $additionalVelocity = $acceleration->multiplyBy($time);

        $this->getVelocity()->add($additionalVelocity);

        /** @var Momentum $momentum */
        $momentum = $this->getMass()->multiplyBy($this->getVelocity());

        $this->setMomentum($momentum);

        return $this;
    }

}