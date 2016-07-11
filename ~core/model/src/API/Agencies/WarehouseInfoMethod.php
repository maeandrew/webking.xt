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
use Fresh\DeliveryAuto\Mapping\WarehouseInfo\Warehouse;

/**
 * API method to get information about warehouse
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class WarehouseInfoMethod extends AbstractApiMethod
{
    /**
     * {@inheritdoc}
     */
    protected static $partOfUrl = 'Public/GetWarehousesInfo';

    /**
     * Constructor
     *
     * @param string $locale      Locale
     * @param string $warehouseId Warehouse ID
     */
    public function __construct($locale, $warehouseId)
    {
        parent::__construct();

        $this->queryParams = [
            'culture'      => $locale,
            'WarehousesId' => $warehouseId
        ];
    }

    /**
     * Get object mapped result
     *
     * @return array|Warehouse[]
     */
    public function getObjectMappedResult()
    {
        $item = $this->getArrayResult();

        $id            = isset($item['id']) ? $item['id'] : null;
        $name          = isset($item['name']) ? $item['name'] : null;
        $address       = isset($item['address']) ? $item['address'] : null;
        $operatingTime = isset($item['operatingTime']) ? $item['operatingTime'] : null;
        $phone         = isset($item['Phone']) ? $item['Phone'] : null;
        $emailStorage  = isset($item['EmailStorage']) ? $item['EmailStorage'] : null;
        $latitude      = isset($item['latitude']) ? $item['latitude'] : null;
        $longitude     = isset($item['longitude']) ? $item['longitude'] : null;
        $office        = isset($item['office']) ? $item['office'] : null;

        return (new Warehouse())->setId($id)
                                ->setName($name)
                                ->setAddress($address)
                                ->setOperatingTime($operatingTime)
                                ->setPhone($phone)
                                ->setEmailStorage($emailStorage)
                                ->setLatitude($latitude)
                                ->setLongitude($longitude)
                                ->setOffice($office);
    }
}
