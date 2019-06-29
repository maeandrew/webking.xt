<?php
// namespace LisDev\Delivery;
/**
 * Delivery Auto API 2 Class
 * 
 * @author lis-dev
 * @see http://goo.gl/s5L7qm
 * @see https://github.com/lis-dev
 * @license MIT
 */
class DeliveryApi2 {
	/**
	 * @var bool $throwErrors Throw exceptions when in response is error
	 */
	protected $throwErrors = FALSE;
	
	/**
	 * @var string $format Format of returned data - array, json
	 */
	protected $format = 'array';
	
	/**
	 * @var string $culture Language of response (en-US, ru-RU, uk-UA)
	 */
	protected $culture = 'ru-RU';
	
	/**
	 * @var string $model Set current model 
	 */
	protected $model = 'Public';
	
	/**
	 * @var string $method Set method of current model
	 */
	protected $method;
	
	/**
	 * @var array $params Set params of current method of current model
	 */
	protected $params;

	/**
	 * Default constructor
	 * 
	 * @param string $culture Default Language
	 * @param bool $throwErrors Throw request errors as Exceptions
	 * @return this 
	 */
	function __construct($throwErrors = FALSE) {
		$this->throwErrors = $throwErrors;
		return $this;
	}
	
	/**
	 * Setter for culture property
	 * 
	 * @param string $culture
	 * @return this
	 */
	function setCulture($culture) {
		$this->culture = $culture;
		return $this;
	}
	
	/**
	 * Getter for culture property
	 * 
	 * @return string
	 */
	function getCulture() {
		return $this->culture;
	}
	
	/**
	 * Setter for format property
	 * 
	 * @param string $format Format of returned data by methods (json, array)
	 * @return this 
	 */
	function setFormat($format) {
		$this->format = $format;
		return $this;
	}
	
	/**
	 * Getter for format property
	 * 
	 * @return string
	 */
	function getFormat() {
		return $this->format;
	}
	
	/**
	 * Prepare data before return it
	 * 
	 * @param json $data
	 * @return mixed
	 */
	private function prepare($data) {
		//Returns array
		if ($this->format == 'array') {
			$result = is_array($data)
				? $data
				: json_decode($data, 1);
			// If error exists, throw Exception
			if ($this->throwErrors AND $result['errors'])
				throw new \Exception(is_array($result['errors']) ? implode("\n", $result['errors']) : $result['errors']);
			return $result;
		}
		// Returns json
		return $data;
	}
	
	/**
	 * Make request to NovaPoshta API
	 * 
	 * @param string $model Model name
	 * @param string $method Method name
	 * @param bool $curl Use curl for request
	 * @param array $params Required params
	 */
	private function request($model, $method, $params = NULL, $curl = FALSE) {
		// Get json result
		$params['culture'] = $this->culture;
		$url = 'http://www.delivery-auto.com.ua/api/v2';
		if ($curl) {
			$ch = curl_init($url.'/'.$model.'/'.$method);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			// curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
			$result = curl_exec($ch);
			curl_close($ch);
		} else {
			$uri_part = http_build_query($params);
			$result = file_get_contents($url.'/'.$model.'/'.$method.'?'.$uri_part);
		}
		
		return $this->prepare($result);
	}

	/**
	 * Set current model and empties method and params properties
	 * 
	 * @param string $model
	 * @return mixed
	 */
	function model($model = '') {
		if ( ! $model) 
			return $this->model;

		$this->model = $model;
		$this->method = NULL;
		$this->params = NULL;
		return $this;
	}

	/**
	 * Set method of current model property and empties params properties
	 * 
	 * @param string $method
	 * @return mixed
	 */
	function method($method = '') {
		if ( ! $method) 
			return $this->method;

		$this->method = $method;
		$this->params = NULL;
		return $this;
	}
	
	/**
	 * Set params of current method/property property
	 * 
	 * @param array $params
	 * @return mixed
	 */
	function params($params) {
		$this->params = $params;
		return $this;
	}
	
	/**
	 * Execute request to NovaPoshta API
	 * 
	 * @return mixed
	 */
	function execute() {
		return $this->request($this->model, $this->method, $this->params);
	}
	
	/**
	 * GetRegionList
	 * 
	 * @return mixed
	 */
	function getRegionList() {
		return $this->request('Public', 'GetRegionList');
	}
	
	/**
	 * GetAreasList
	 * 
	 * @return mixed
	 */
	function getAreasList() {
		return $this->request('Public', 'GetAreasList');
	}
	
	/**
	 * GetWarehousesList
	 * 
	 * @param string $includeRegionalCenters Show offices
	 * @param string $cityId ID of the city
	 * @param string $regionId ID of the region
	 * @return mixed
	 */
	function getWarehousesList($includeRegionalCenters = FALSE, $cityId = NULL, $regionId = NULL) {
		$params['includeRegionalCenters'] = $includeRegionalCenters ? 'true' : 'false';
		$cityId AND $params['cityId'] = $cityId;
		$regionId AND $params['regionId'] = $regionId;
		return $this->request('Public', 'GetWarehousesList', $params);
	}
	
	/**
	 * GetWarehousesInfo
	 * 
	 * @param string $warehousesId
	 * @return mixed
	 */
	function getWarehousesInfo($warehousesId) {
		return $this->request('Public', 'GetWarehousesInfo', array(
			'WarehousesId' => $warehousesId
		));
	}
	
	/**
	 * GetFindWarehouses
	 * 
	 * @param int $count
	 * @param string $longitude
	 * @param string $latitude
	 * @param string $includeRegionalCenters
	 * @return mixed
	 */
	function getFindWarehouses($count, $longitude, $latitude, $includeRegionalCenters) {
		return $this->request('Public', 'GetFindWarehouses', array(
			'count' => $count,
			'Longitude' => $longitude,
			'Latitude' => $latitude,
			'includeRegionalCenters' => $includeRegionalCenters ? 'true' : 'false',
		));
	}
	
	/**
	 * GetWarehousesListInDetail
	 * TODO Uncomment when API method will be repeared (now is 404 error) 
	 * @param string $cityId
	 * @return mixed
	function getWarehousesListInDetail($cityId) {
		return $this->request('Public', 'GetWarehousesListInDetail', array(
			'CityId' => $cityId,
		));
	}
	*/
	
	/**
	 * GetReceiptDetails
	 * 
	 * @param string $number
	 * @return mixed
	 */
	function getReceiptDetails($number) {
		return $this->request('Public', 'GetReceiptDetails', array(
			'number' => $number,
		));
	}
	
	/**
	 * Get date of delivery by cities ID and date of shipping
	 * 
	 * @param string $areasSendId City Sender ID
	 * @param string $areasResiveId City Receiver ID
	 * @param string $dateSend Date format 2014-06-05T09:54:20
	 * @param string $warehouseSendId Warehouse Sender ID
	 * @param string $warehouseResiveId Warehouse Receiver ID
	 * @param string $currency Currency ID, 100000000 it's hrn
	 * @return mixed
	 */
	function getDateArrival($areasSendId, $areasResiveId, $dateSend, $warehouseSendId = NULL, $warehouseResiveId = NULL, $currency = 100000000) {
		return $this->request('Public', 'GetDateArrival', array(
			'areasSendId' => $areasSendId,
			'areasResiveId' => $areasResiveId,
			'dateSend' => $dateSend,
			'warehouseSendId' => $warehouseSendId,
			'warehouseResiveId' => $warehouseResiveId,
			'currency' => $currency,
		));
	}
	
	/**
	 * GetDopUslugiClassification
	 * 
	 * @param string $currency Currency ID, 100000000 it's hrn
	 * @return mixed
	 */
	function getDopUslugiClassification($currency = 100000000) {
		return $this->request('Public', 'GetDopUslugiClassification', array(
			'currency' => $currency,
		));
	}
	
	/**
	 * GetTariffCategory
	 * 
	 * @return mixed
	 */
	function getTariffCategory() {
		return $this->request('Public', 'GetTariffCategory');
	}
	
	/**
	 * GetDeliveryScheme
	 * 
	 * @return mixed
	 */
	function getDeliveryScheme() {
		return $this->request('Public', 'GetDeliveryScheme');
	}
	
	/**
	 * Calculate price of shipping
	 * 
	 * @param array $params Params for shipping. Required fields:
	 *  areasSendId => string, areasResiveId => string, warehouseSendId => string, warehouseResiveId => string, InsuranceValue => float,
	 *  dateSend => string (format 13.06.2014), deliveryScheme => int, 
	 *  category => array(array(
	 *    categoryId => string, countPlace => int, helf => int, size => int
	 *  ))
	 * 	 
	 * @return mixed
	 */
	function postReceiptCalculate($params) {
		return $this->request('Public', 'PostReceiptCalculate', $params, TRUE);
	}
	
	/**
	 * Calculate price of shipping (simplest method. only required fields)
	 * 
	 * @param string $areasSendId Sender City ID
	 * @param string $areasResiveId Recipient City ID
	 * @param string $warehouseSendId Sender Warehouse ID
	 * @param string $warehouseResiveId Recipient Warehouse ID
	 * @param float $InsuranceValue Insurance value for parcel, price of goods
	 * @param string $dateSend Date of shipping, format 13.06.2014
	 * @param int $countPlace Count of places
	 * @param ing $weight Weight
	 * @param string $volume Size at m^3
	 * 
	 * @return mixed
	 */
	function postReceiptCalculateSimple($areasSendId, $areasResiveId, $warehouseSendId, $warehouseResiveId,
		$InsuranceValue, $dateSend, $countPlace, $weight, $volume) {
		return $this->postReceiptCalculate(array(
			'areasSendId' => $areasSendId,
			'areasResiveId' => $areasResiveId,
			'warehouseSendId' => $warehouseSendId,
			'warehouseResiveId' => $warehouseResiveId,
			'InsuranceValue' => (float) $InsuranceValue,
			'dateSend' => $dateSend,
			'deliveryScheme' =>  2,
			'category' => array(
				array(
					'categoryId' => "00000000-0000-0000-0000-000000000000",
					'countPlace' => $countPlace,
					'helf' => $weight,
					'size' => $volume,
				),
			)
		));
	}
	
}
