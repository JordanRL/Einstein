<?php

namespace Samsara\Einstein\Object\Base\Compose;

use Samsara\Newton\Units\Length;
use Samsara\Newton\Units\Volume;
use Samsara\Newton\Units\Area;

trait ThreeDimensionTrait
{

    /**
     * @var Length
     */
    private $lengthX;

    /**
     * @var Length
     */
    private $lengthY;

    /**
     * @var Length
     */
    private $lengthZ;

    /**
     * @var Volume
     */
    private $volume;

    /**
     * @var Area
     */
    private $area;

    public function setLengthX(Length $length, $revalidate = true)
    {
        $this->lengthX = $length;

        if ($revalidate) {
            return $this->revalidate();
        }

        return $this;
    }

    public function getLengthX()
    {
        return $this->lengthX;
    }

    public function addLengthX(Length $length, $revalidate = true)
    {
        $this->lengthX->add($length);

        if ($revalidate) {
            return $this->revalidate();
        }

        return $this;
    }

    public function subtractLengthX(Length $length, $revalidate = true)
    {
        $this->lengthX->subtract($length);

        if ($revalidate) {
            return $this->revalidate();
        }

        return $this;
    }

    public function setLengthY(Length $length, $revalidate = true)
    {
        $this->lengthY = $length;

        if ($revalidate) {
            return $this->revalidate();
        }

        return $this;
    }

    public function getLengthY()
    {
        return $this->lengthY;
    }

    public function addLengthY(Length $length, $revalidate = true)
    {
        $this->lengthY->add($length);

        if ($revalidate) {
            return $this->revalidate();
        }

        return $this;
    }

    public function subtractLengthY(Length $length, $revalidate = true)
    {
        $this->lengthY->subtract($length);

        if ($revalidate) {
            return $this->revalidate();
        }

        return $this;
    }

    public function setLengthZ(Length $length, $revalidate = true)
    {
        $this->lengthZ = $length;

        if ($revalidate) {
            return $this->revalidate();
        }

        return $this;
    }

    public function getLengthZ()
    {
        return $this->lengthZ;
    }

    public function addLengthZ(Length $length, $revalidate = true)
    {
        $this->lengthZ->add($length);

        if ($revalidate) {
            return $this->revalidate();
        }

        return $this;
    }

    public function subtractLengthZ(Length $length, $revalidate = true)
    {
        $this->lengthZ->subtract($length);

        if ($revalidate) {
            return $this->revalidate();
        }

        return $this;
    }

    public function setVolume(Volume $volume)
    {
        $this->volume = $volume;

        return $this;
    }

    public function getVolume()
    {
        return $this->volume;
    }

    public function addVolume(Volume $volume)
    {
        $this->volume->add($volume);

        return $this;
    }

    public function subtractVolume(Volume $volume)
    {
        $this->volume->subtract($volume);

        return $this;
    }

    public function setArea(Area $area)
    {
        $this->area = $area;

        return $this;
    }

    public function getArea()
    {
        return $this->area;
    }

    public function addArea(Area $area)
    {
        $this->area->add($area);

        return $this;
    }

    public function subtractArea(Area $area)
    {
        $this->area->subtract($area);

        return $this;
    }

    protected function revalidate()
    {
        if (isset($this->lengthX, $this->lengthY, $this->lengthZ)) {
            $this->volume = $this->lengthX->multiplyBy($this->lengthY)->multiplyBy($this->lengthZ);

            $area1 = $this->lengthX->multiplyBy($this->lengthY)->preConvertedMultiply(2);
            $area2 = $this->lengthX->multiplyBy($this->lengthZ)->preConvertedMultiply(2);
            $area3 = $this->lengthY->multiplyBy($this->lengthZ)->preConvertedMultiply(2);

            $this->area = $area1->add($area2)->add($area3);

            return $this;
        }

        throw new \Exception('Cannot validate dimensions of object.');
    }

}