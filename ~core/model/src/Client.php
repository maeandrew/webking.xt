<?php
/*
 * This file is part of the "Delivery Auto" API PHP Client
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fresh\DeliveryAuto;

use Fresh\DeliveryAuto\Mapping;
use Fresh\DeliveryAuto\Directory\Currency;
use Fresh\DeliveryAuto\Directory\Locale;
use Fresh\DeliveryAuto\API\Agencies as AgenciesAPI;
use Fresh\DeliveryAuto\API\Cost as CostAPI;
use Fresh\DeliveryAuto\API\Receipts as ReceiptsAPI;

/**
 * "Delivery Auto" API PHP Client
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 * @see    http://www.delivery-auto.com/uk-UA/GenericPages/DbIndex/2082 "Delivery Auto" API Documentation
 */
class Client
{
    /**
     * @var string $locale Locale
     */
    private $locale = Locale::UKRAINIAN;

    /**
     * Set locale
     *
     * @param string $locale Locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Get list of regions
     *
     * Method 1.1 from API documentation
     *
     * @return API\Agencies\ListOfRegionsMethod
     */
    public function getListOfRegions()
    {
        return new AgenciesAPI\ListOfRegionsMethod($this->locale);
    }

    /**
     * Get list of areas (cities)
     *
     * Method 1.2 from API documentation
     *
     * @return API\Agencies\ListOfAreasMethod
     */
    public function getListOfAreas()
    {
        return new AgenciesAPI\ListOfAreasMethod($this->locale);
    }

    /**
     * Get list of warehouses
     *
     * Method 1.3 from API documentation
     *
     * @param bool        $includeRegionalCenters Include regional centers
     * @param string|null $cityId                 City ID
     * @param string|null $regionId               Region ID
     *
     * @return API\Agencies\ListOfWarehousesMethod
     */
    public function getListOfWarehouses($includeRegionalCenters = false, $cityId = null, $regionId = null)
    {
        return new AgenciesAPI\ListOfWarehousesMethod($this->locale, $includeRegionalCenters, $cityId, $regionId);
    }

    /**
     * Get warehouse info
     *
     * Method 1.4 from API documentation
     *
     * @param string $warehouseId Warehouse ID
     *
     * @return API\Agencies\WarehouseInfoMethod
     */
    public function getWarehouseInfo($warehouseId)
    {
        return new AgenciesAPI\WarehouseInfoMethod($this->locale, $warehouseId);
    }

    /**
     * Find warehouses
     *
     * Method 1.5 from API documentation
     *
     * @param bool  $includeRegCenters Include regional centers
     * @param float $longitude         Longitude
     * @param float $latitude          Latitude
     * @param int   $count             Count
     *
     * @return API\Agencies\FindWarehousesMethod
     */
    public function findWarehouses($includeRegCenters, $longitude, $latitude, $count)
    {
        return new AgenciesAPI\FindWarehousesMethod($this->locale, $includeRegCenters, $longitude, $latitude, $count);
    }

    /**
     * Get list of warehouses in detail
     *
     * Method 1.6 from API documentation
     *
     * @param string $cityId City ID
     *
     * @return API\Agencies\ListOfWarehousesInDetailMethod
     */
    public function getListOfWarehousesInDetail($cityId)
    {
        return new AgenciesAPI\ListOfWarehousesInDetailMethod($this->locale, $cityId);
    }

    /**
     * Get receipt details
     *
     * Method 2.1 from API documentation
     *
     * @param string $number Receipt number
     *
     * @return API\Receipts\ReceiptDetailsMethod
     */
    public function getReceiptDetails($number)
    {
        return new ReceiptsAPI\ReceiptDetailsMethod($this->locale, $number);
    }

    /**
     * Get arrival date
     *
     * Method 2.2 from API documentation
     *
     * @param string      $cityFromId      City from ID
     * @param string      $cityToId        City to ID
     * @param string      $dateOfSend      Date of send
     * @param int         $currency        Currency
     * @param string|null $warehouseFromId Warehouse from ID
     * @param string|null $warehouseToId   Warehouse to ID
     *
     * @return API\Receipts\ArrivalDateMethod
     */
    public function getArrivalDate(
        $cityFromId,
        $cityToId,
        $dateOfSend,
        $currency = Currency::UAH,
        $warehouseFromId = null,
        $warehouseToId = null
    ) {
        return new ReceiptsAPI\ArrivalDateMethod(
            $cityFromId,
            $cityToId,
            $dateOfSend,
            $currency,
            $warehouseFromId,
            $warehouseToId
        );
    }

    /**
     * Get list of additional services
     *
     * Method 3.2 from API documentation
     *
     * @param int $currency Currency
     *
     * @return API\Cost\ListOfAdditionalServicesMethod
     */
    public function getListOfAdditionalServices($currency = Currency::UAH)
    {
        return new CostAPI\ListOfAdditionalServicesMethod($this->locale, $currency);
    }

    /**
     * Get list of tariff categories
     *
     * Method 3.3 from API documentation
     *
     * @return API\Cost\ListOfTariffCategories
     */
    public function getListOfTariffCategories()
    {
        return new CostAPI\ListOfTariffCategories($this->locale);
    }

    /**
     * Get list of delivery schemas
     *
     * Method 3.4 from API documentation
     *
     * @return API\Cost\ListOfDeliverySchemas
     */
    public function getListOfDeliverySchemas()
    {
        return new CostAPI\ListOfDeliverySchemas($this->locale);
    }

    /**
     * Calculate fare
     *
     * Method 3.5 from API documentation
     *
     * @return API\Cost\CalculateFare
     */
    public function calculateFare()
    {
        return new CostAPI\CalculateFare();
    }
}
