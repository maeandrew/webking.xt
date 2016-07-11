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
use Fresh\DeliveryAuto\Mapping\WarehouseList\Warehouse;

/**
 * API method to get list of warehouses in details
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ListOfWarehousesMethod extends AbstractApiMethod
{
    /**
     * {@inheritdoc}
     */
    protected static $partOfUrl = 'Public/GetWarehousesListInDetail';

    /**
     * Constructor
     *
     * @param string      $locale            Locale
     * @param bool        $includeRegCenters Include regional centers
     * @param string|null $cityId            City ID
     * @param string|null $regionId          Region ID
     */
    public function __construct($locale, $includeRegCenters = false, $cityId = null, $regionId = null)
    {
        parent::__construct();

        $this->queryParams = [
            'includeRegionalCenters' => $includeRegCenters,
            'CityId'                 => $cityId,
            'RegionId'               => $regionId,
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
            $latitude  = isset($item['latitude']) ? $item['latitude'] : null;
            $longitude = isset($item['longitude']) ? $item['longitude'] : null;

            $warehouse = (new Warehouse())->setId($id)
                                          ->setName($name)
                                          ->setLatitude($latitude)
                                          ->setLongitude($longitude);

            array_push($result, $warehouse);
        }

        return $result;
    }
}
