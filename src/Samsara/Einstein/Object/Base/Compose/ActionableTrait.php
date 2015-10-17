<?php

namespace Samsara\Einstein\Object\Base\Compose;

use Samsara\Newton\Units\Time;
use Samsara\Newton\Core\Quantity;
use Samsara\Cantor\Provider\BCProvider;

trait ActionableTrait
{

    private $actions = [];

    public function addAction(Time $time, $actionMethod, Quantity $quantity)
    {
        $this->actions[] = [
            'action' => $actionMethod,
            'argument' => $quantity,
            'time' => $time,
        ];

        return $this;
    }

    public function elapse(Time $time)
    {
        foreach ($this->actions as $key => $action) {
            /** @var Time $timeLeft */
            $timeLeft = $action['time'];
            $method = $action['action'];
            $argument = $action['argument'];

            $timeLeft->toNative();
            $time->toNative();

            $timeLeft->subtract($time);

            if (BCProvider::compare($timeLeft->getValue(), 0) <= 0) {
                unset($this->actions[$key]);
                $executeTime = clone $timeLeft->add($time);
            } else {
                $executeTime = $time;
            }

            $reflectMethod = new \ReflectionMethod($this, $method);

            $params = $reflectMethod->getParameters();

            if (count($params) != 2) {
                throw new \Exception('Cannot invoke action because a parameter count mismatch.');
            }

            $args = [];

            foreach ($params as $pKey => $param) {
                if (strpos($param->getClass()->name, 'Time') !== false) {
                    $args[$pKey] = $executeTime;
                } else {
                    $args[$pKey] = $argument;
                }
            }

            $reflectMethod->invokeArgs($this, $args);
        }

        return $this;
    }

}