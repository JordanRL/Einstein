<?php

namespace Samsara\Einstein\Object\Base\Compose;

use Samsara\Fermat\Values\Vector;

trait ThreeDimensionVectorTrait
{

    private $heading;

    private $azimuth;

    private $inclination;

    private $vector;

    public function changeHeading($heading)
    {
        $parts = explode('mark', strtolower($heading));

        $vector = new Vector($parts[1], $parts[0], 1);

        return $this->changeHeadingByVector($vector);
    }

    public function changeHeadingByVector(Vector $vector)
    {
        $this->vector = $vector;

        $azimuth = $vector->getAzimuth();
        $inclination = $vector->getInclination();

        $this->azimuth = $azimuth;
        $this->inclination = $inclination;

        $this->heading = $azimuth->round(2)->getValue().' Mark '.$inclination->round(2)->getValue();

        return $this;
    }

    public function changeHeadingByCartesian($x, $y, $z)
    {
        $vector = Vector::createFromCartesian($x, $y, $z);

        return $this->changeHeadingByVector($vector);
    }

}