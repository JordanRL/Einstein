<?php

namespace Samsara\Einstein\Object\Base\Compose;

use Samsara\Newton\Units\Mass;

trait MassiveTrait
{

    /**
     * @var Mass
     */
    private $mass;

    /**
     * @param Mass $mass
     * @return $this
     */
    public function setMass(Mass $mass)
    {
        $this->mass = $mass;

        return $this;
    }

    /**
     * @return Mass
     */
    public function getMass()
    {
        return $this->mass;
    }

    /**
     * @param Mass $mass
     * @return $this
     * @throws \Exception
     */
    public function addMass(Mass $mass)
    {
        $this->mass->add($mass);

        return $this;
    }

    /**
     * @param Mass $mass
     * @return $this
     * @throws \Exception
     */
    public function subtractMass(Mass $mass)
    {
        $this->mass->subtract($mass);

        return $this;
    }

}