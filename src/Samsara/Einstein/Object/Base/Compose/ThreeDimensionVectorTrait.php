<?php

namespace Samsara\Einstein\Object\Base\Compose;

use Samsara\Fermat\Numbers;
use Samsara\Fermat\Provider\TrigonometryProvider;

trait ThreeDimensionVectorTrait
{

    private $heading;

    private $azimuth;

    private $inclination;

    public function changeHeading($heading)
    {
        $this->heading = $heading;

        return $this;
    }

    public function changeHeadingByVector($x, $y, $z)
    {
        $xyR = TrigonometryProvider::radiansToDegrees(TrigonometryProvider::sphericalCartesianAzimuth($x, $y));
        $zR = TrigonometryProvider::radiansToDegrees(TrigonometryProvider::sphericalCartesianInclination($x, $y, $z));

        $azimuth = Numbers::make(Numbers::IMMUTABLE, $xyR);
        $inclination = Numbers::make(Numbers::IMMUTABLE, $zR);

        $this->azimuth = $azimuth;
        $this->inclination = $inclination;

        $this->heading = $azimuth->round(2)->getValue().' Mark '.$inclination->round(2)->getValue();

        return $this;
    }

}