<?php

namespace Lce\Resource;

use Lce\Lce;

class Offer extends Resource
{
    public static function find($id)
    {
        $offer = Lce::$connection->get('offers', $id);

        return new self($offer);
    }

    public function order($params)
    {
        return Order::place($this->id, $params);
    }

    public function available_delivery_locations($params)
    {
        $available_delivery_locations = Lce::$connection->get('offers', $this->id, 'available_delivery_locations', null, array('location' => $params));

        return $available_delivery_locations;
    }
}
