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
use Fresh\DeliveryAuto\Mapping\Receipt\Details;

/**
 * API method to get receipt details
 *
 * @author Artem Genvald  <genvaldartem@gmail.com>
 * @author Timur Bolotyuh <timur.bolotyuh@gmail.com>
 */
class ReceiptDetailsMethod extends AbstractApiMethod
{
    /**
     * {@inheritdoc}
     */
    protected static $partOfUrl = 'Public/GetReceiptDetails';

    /**
     * Constructor
     *
     * @param string $locale Locale
     * @param string $number Receipt number
     */
    public function __construct($locale, $number)
    {
        parent::__construct();

        $this->queryParams = [
            'culture' => $locale,
            'number'  => $number
        ];
    }

    /**
     * Get object mapped result
     *
     * @return array|Details[]
     */
    public function getObjectMappedResult()
    {
        $result = $this->getArrayResult();

        return (new Details())->setId($result['id'])
                              ->setNumber($result['number'])
                              ->setSendDate($result['SendDate'])
                              ->setReceiveDate($result['ReceiveDate'])
                              ->setSenderWarehouseName($result['SenderWarehouseName'])
                              ->setRecipientWarehouseName($result['RecepientWarehouseName'])
                              ->setDiscount($result['Discount'])
                              ->setTotalCost($result['TotalCost'])
                              ->setStatus($result['Status'])
                              ->setWeight($result['Weight'])
                              ->setVolume($result['Volume'])
                              ->setSites($result['Sites'])
                              ->setPaymentStatus($result['PaymentStatus'])
                              ->setCurrency($result['Currency'])
                              ->setInsuranceCost($result['InsuranceCost'])
                              ->setInsuranceCurrency($result['InsuranceCurrency'])
                              ->setPushStateCode($result['PushStateCode']);
    }
}
