<?php

namespace Samsara\Einstein\Object\Base\Compose;

use Samsara\Newton\Units\Momentum;

trait MovableMassTrait
{
    use MassiveTrait;
    use MovableTrait;

    /**
     * @var Momentum
     */
    private $momentum;

    public function setMomentum(Momentum $momentum)
    {
        $this->momentum = $momentum;

        return $this;
    }

    public function getMomentum()
    {
        return $this->momentum;
    }

    public function addMomentum(Momentum $momentum)
    {
        $this->momentum->add($momentum);

        return $this;
    }

    public function subtractMomentum(Momentum $momentum)
    {
        $this->momentum->subtract($momentum);

        return $this;
    }

}