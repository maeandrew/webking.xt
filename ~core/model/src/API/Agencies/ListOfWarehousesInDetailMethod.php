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
use Fresh\DeliveryAuto\Mapping\WarehouseList\WarehouseDetails;

/**
 * API method to get information about warehouse
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ListOfWarehousesInDetailMethod extends AbstractApiMethod
{
    /**
     * {@inheritdoc}
     */
    protected static $partOfUrl = 'Public/GetWarehousesListInDetail';

    /**
     * Constructor
     *
     * @param string $locale Locale
     * @param string $cityId City ID
     */
    public function __construct($locale, $cityId)
    {
        parent::__construct();

        $this->queryParams = [
            'culture' => $locale,
            'CityId'  => $cityId
        ];
    }

    /**
     * Get object mapped result
     *
     * @return array|WarehouseDetails[]
     */
    public function getObjectMappedResult()
    {
        $result = [];

        foreach ($this->getArrayResult() as $item) {
            $id        = isset($item['id']) ? $item['id'] : null;
            $name      = isset($item['name']) ? $item['name'] : null;
            $latitude  = isset($item['latitude']) ? $item['latitude'] : null;
            $longitude = isset($item['longitude']) ? $item['longitude'] : null;

            $warehouse = (new WarehouseDetails())->setId($id)
                                                 ->setName($name)
                                                 ->setLatitude($latitude)
                                                 ->setLongitude($longitude);

            array_push($result, $warehouse);
        }

        return $result;
    }
}
