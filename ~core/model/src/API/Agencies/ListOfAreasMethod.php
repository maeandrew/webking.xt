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
use Fresh\DeliveryAuto\Mapping\AreaList\Area;

/**
 * API method to get list of areas (cities)
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ListOfAreasMethod extends AbstractApiMethod
{
    /**
     * {@inheritdoc}
     */
    protected static $partOfUrl = 'Public/GetAreasList';

    /**
     * Constructor
     *
     * @param string $locale Locale
     */
    public function __construct($locale)
    {
        parent::__construct();

        $this->queryParams = ['culture' => $locale];
    }

    /**
     * Get object mapped result
     *
     * @return array|Area[]
     */
    public function getObjectMappedResult()
    {
        $result = [];

        foreach ($this->getArrayResult() as $item) {
            $id                   = isset($item['id']) ? $item['id'] : null;
            $name                 = isset($item['name']) ? $item['name'] : null;
            $warehouse            = isset($item['IsWarehouse']) ? $item['IsWarehouse'] : null;
            $extraCityPickup      = isset($item['ExtracityPickup']) ? $item['ExtracityPickup'] : null;
            $extraCityShipping    = isset($item['ExtracityShipping']) ? $item['ExtracityShipping'] : null;
            $regionalAreaPickup   = isset($item['RAP']) ? $item['RAP'] : null;
            $regionalAreaShipping = isset($item['RAS']) ? $item['RAS'] : null;

            $area = (new Area())->setId($id)
                                ->setName($name)
                                ->setWarehouse($warehouse)
                                ->setExtraCityPickup($extraCityPickup)
                                ->setExtraCityShipping($extraCityShipping)
                                ->setRegionalAreaPickup($regionalAreaPickup)
                                ->setRegionalAreaShipping($regionalAreaShipping);

            array_push($result, $area);
        }

        return $result;
    }
}
