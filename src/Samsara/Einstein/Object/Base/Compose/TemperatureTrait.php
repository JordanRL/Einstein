<?php

namespace Samsara\Einstein\Object\Base\Compose;

use Samsara\Newton\Units\Temperature;

trait TemperatureTrait
{

    /**
     * @var Temperature
     */
    private $temperature;

    public function setTemperature(Temperature $temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getTemperature()
    {
        return $this->temperature;
    }

    public function addTemperature(Temperature $temperature)
    {
        $this->temperature->add($temperature);

        return $this;
    }

    public function subtractTemperature(Temperature $temperature)
    {
        $this->temperature->subtract($temperature);

        return $this;
    }

}