<?php

namespace App\Consumer;

use App\Entities\Device;
use Illuminate\Support\Collection;

/**
 * @class VelocityConsumer
 */
class VelocityConsumer extends ServiceConsumer
{
    /**
     * @var Collection
     */
    private $positions;

    function __construct($data)
    {
        parent::__construct($data);
    }

    protected function transform($data)
    {
        return floatval($data);
    }

    public function consume(Device $device)
    {
        $speed = $this->getData();

        $this->positions->each(function($pos) use ($speed) {
            $pos->update(['speed' => $speed]);
        });
    }

    public function setPositions($list)
    {
        $this->positions = $list;
    }
}
