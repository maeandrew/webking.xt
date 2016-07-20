<?php
/*
 * This file is part of the "Delivery Auto" API PHP Client
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fresh\DeliveryAuto\API\Agencies;

use Fresh\DeliveryAuto\API\AbstractApiMethod;
use Fresh\DeliveryAuto\Mapping\FindWarehouses\Warehouse;

/**
 * API method to find warehouses
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class FindWarehousesMethod extends AbstractApiMethod
{
    /**
     * {@inheritdoc}
     */
    protected static $partOfUrl = 'Public/GetFindWarehouses';

    /**
     * Constructor
     *
     * @param string $locale            Locale
     * @param bool   $includeRegCenters Include regional centers
     * @param float  $longitude         Longitude
     * @param float  $latitude          Latitude
     * @param int    $count             Count
     */
    public function __construct($locale, $includeRegCenters, $longitude, $latitude, $count)
    {
        parent::__construct();

        $this->queryParams = [
            'includeRegionalCenters' => $includeRegCenters,
            'Longitude'              => $longitude,
            'Latitude'               => $latitude,
            'count'                  => $count,
            'culture'                => $locale
        ];
    }

    /**
     * Get object mapped result
     *
     * @return array|Warehouse[]
     */
    public function getObjectMappedResult()
    {
        $result = [];

        foreach ($this->getArrayResult() as $item) {
            $id        = isset($item['id']) ? $item['id'] : null;
            $name      = isset($item['name']) ? $item['name'] : null;
            $cityName  = isset($item['cityName']) ? $item['cityName'] : null;
            $address   = isset($item['address']) ? $item['address'] : null;
            $warehouse = isset($item['IsWarehouse']) ? $item['IsWarehouse'] : null;
            $distance  = isset($item['distance']) ? $item['distance'] : null;
            $latitude  = isset($item['latitude']) ? $item['latitude'] : null;
            $longitude = isset($item['longitude']) ? $item['longitude'] : null;

            $warehouse = (new Warehouse())->setId($id)
                                          ->setName($name)
                                          ->setCityName($cityName)
                                          ->setAddress($address)
                                          ->setWarehouse($warehouse)
                                          ->setDistance($distance)
                                          ->setLatitude($latitude)
                                          ->setLongitude($longitude);

            array_push($result, $warehouse);
        }

        return $result;
    }
}
