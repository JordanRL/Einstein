<?php

namespace Samsara\Einstein\Object\Base\Compose;

use Samsara\Newton\Units\Velocity;

trait MovableTrait
{

    /**
     * @var Velocity
     */
    private $velocity;

    public function setVelocity(Velocity $velocity)
    {
        $this->velocity = $velocity;

        return $this;
    }

    public function getVelocity()
    {
        return $this->velocity;
    }

    public function addVelocity(Velocity $velocity)
    {
        $this->velocity->add($velocity);

        return $this;
    }

    public function subtractVelocity(Velocity $velocity)
    {
        $this->velocity->subtract($velocity);

        return $this;
    }

}