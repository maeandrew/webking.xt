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
use Fresh\DeliveryAuto\Mapping\AdditionalServiceList\Classification;
use Fresh\DeliveryAuto\Mapping\AdditionalServiceList\Service;

/**
 * API method to get list of additional services
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ListOfAdditionalServicesMethod extends AbstractApiMethod
{
    /**
     * {@inheritdoc}
     */
    protected static $partOfUrl = 'Public/GetDopUslugiClassification';

    /**
     * Constructor
     *
     * @param string $locale   Locale
     * @param int    $currency Currency
     */
    public function __construct($locale, $currency)
    {
        parent::__construct();

        $this->queryParams = [
            'currency' => $currency,
            'culture'  => $locale
        ];
    }

    /**
     * Get object mapped result
     *
     * @return array|Classification[]
     */
    public function getObjectMappedResult()
    {
        $result = [];

        foreach ($this->getArrayResult() as $item) {
            $additionalServices = [];
            foreach ($item['dopUsluga'] as $service) {
                $id             = isset($service['uslugaId']) ? $service['uslugaId'] : null;
                $name           = isset($service['name']) ? $service['name'] : null;
                $cost           = isset($service['cost']) ? $service['cost'] : null;
                $count          = isset($service['count']) ? $service['count'] : null;
                $classification = isset($service['classification']) ? $service['classification'] : null;
                $minWidth       = isset($service['minWidth']) ? $service['minWidth'] : null;
                $maxWidth       = isset($service['maxWidth']) ? $service['maxWidth'] : null;
                $sum            = isset($service['summa']) ? $service['summa'] : null;
                $comment        = isset($service['comment']) ? $service['comment'] : null;
                $currencyCode   = isset($service['currency']) ? $service['currency'] : null;

                $additionalService = (new Service())->setId($id)
                                                    ->setName($name)
                                                    ->setCost($cost)
                                                    ->setCount($count)
                                                    ->setClassification($classification)
                                                    ->setMinWidth($minWidth)
                                                    ->setMaxWidth($maxWidth)
                                                    ->setSum($sum)
                                                    ->setComment($comment)
                                                    ->setCurrencyCode($currencyCode);

                array_push($additionalServices, $additionalService);
            }

            $classificationCode = isset($item['classification']) ? $item['classification'] : null;
            $name               = isset($item['name']) ? $item['name'] : null;

            $classificationCode = (new Classification())->setClassificationCode($classificationCode)
                                                        ->setName($name)
                                                        ->setAdditionalServices($additionalServices);

            array_push($result, $classificationCode);
        }

        return $result;
    }
}
