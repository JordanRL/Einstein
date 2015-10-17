<?php

namespace Samsara\Einstein\Object\Base\Compose;

use Samsara\Newton\Units\Density;

trait ThreeDimensionMassTrait
{
    use ThreeDimensionTrait;
    use MassiveTrait;

    /**
     * @var Density
     */
    private $density;

    public function setDensity(Density $density)
    {
        $this->density = $density;

        return $this;
    }

    public function getDensity()
    {
        return $this->density;
    }

    public function addDensity(Density $density)
    {
        $this->density->add($density);

        return $this;
    }

    public function subtractDensity(Density $density)
    {
        $this->density->subtract($density);

        return $this;
    }

    public function recalculateDensity()
    {
        if (is_null($this->getVolume()) || $this->getVolume()->getValue() == 0) {
            throw new \Exception('Cannot calculate density with a volume of zero.');
        }

        $this->density = $this->getMass()->divideBy($this->getVolume());

        return $this;
    }

}