<?php
/*
 * This file is part of the "Delivery Auto" API PHP Client
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fresh\DeliveryAuto\API\Receipts;

use Fresh\DeliveryAuto\API\AbstractApiMethod;

/**
 * API method to get arrival date
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ArrivalDateMethod extends AbstractApiMethod
{
    /**
     * {@inheritdoc}
     */
    protected static $partOfUrl = 'Public/GetDateArrival';

    /**
     * Constructor
     *
     * @param string      $cityFromId      City from ID
     * @param string      $cityToId        City to ID
     * @param string      $dateOfSend      Date of send
     * @param string      $currency        Currency
     * @param string|null $warehouseFromId Warehouse from ID
     * @param string|null $warehouseToId   Warehouse to ID
     */
    public function __construct($cityFromId, $cityToId, $dateOfSend, $currency, $warehouseFromId, $warehouseToId)
    {
        parent::__construct();

        $this->queryParams = [
            'areasSendId'       => $cityFromId,
            'areasResiveId'     => $cityToId,
            'dateSend'          => $dateOfSend,
            'currency'          => $currency,
            'warehouseSendId'   => $warehouseFromId,
            'warehouseResiveId' => $warehouseToId
        ];
    }

    /**
     * Get object mapped result
     *
     * @return array
     */
    public function getObjectMappedResult()
    {
        $item = $this->getArrayResult();
    }
}
