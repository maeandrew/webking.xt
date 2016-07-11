<?php
/*
 * This file is part of the "Delivery Auto" API PHP Client
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fresh\DeliveryAuto\API\Cost;

use Fresh\DeliveryAuto\API\AbstractApiMethod;
use Fresh\DeliveryAuto\Mapping\Delivery\Schema;

/**
 * API method to get list of delivery schemas
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ListOfDeliverySchemas extends AbstractApiMethod
{
    /**
     * {@inheritdoc}
     */
    protected static $partOfUrl = 'Public/GetDeliveryScheme';

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
     * @return array|Schema[]
     */
    public function getObjectMappedResult()
    {
        $result = [];

        foreach ($this->getArrayResult() as $item) {
            $id   = isset($item['id']) ? $item['id'] : null;
            $name = isset($item['name']) ? $item['name'] : null;

            $category = (new Schema())->setId($id)
                                      ->setName($name);

            array_push($result, $category);
        }

        return $result;
    }
}
