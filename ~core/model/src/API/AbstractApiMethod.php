<?php
/*
 * This file is part of the "Delivery Auto" API PHP Client
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fresh\DeliveryAuto\API;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Abstract API Method Class
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 *
 * @abstract
 */
abstract class AbstractApiMethod
{
    /**
     * @var string $apiUrl apiUrl API URL
     * @static
     */
    protected static $apiUrl = 'http://www.delivery-auto.com/api/v2/';

    /**
     * @var string $partOfUrl Part of URL
     * @static
     */
    protected static $partOfUrl = '';

    /**
     * @var array $queryParams Query params
     */
    protected $queryParams = [];

    /**
     * @var GuzzleClient $guzzleClient Guzzle HTTP client
     */
    protected $guzzleClient;

    /**
     * Method returns object mapped result depends on each API call
     *
     * @abstract
     */
    abstract public function getObjectMappedResult();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->guzzleClient = new GuzzleClient();
    }

    /**
     * Get raw response
     *
     * @return mixed Raw response
     */
    public function getRawResponse()
    {
        return $this->getGuzzleClient()->get($this->buildMethodApiUrl($this->queryParams))->json();
    }

    /**
     * Get array result
     *
     * @throws \Exception
     *
     * @return mixed Raw array result
     */
    public function getArrayResult()
    {
        $rawResponse = $this->getRawResponse();

        if (!empty($rawResponse) && is_array($rawResponse)) {
            if ($rawResponse['status']) {
                return $rawResponse['data'];
            }

            throw new \Exception($rawResponse['message']);
        }

        throw new \Exception('Wrong response type');
    }

    /**
     * Get Guzzle client
     *
     * @return GuzzleClient Guzzle client
     */
    protected function getGuzzleClient()
    {
        return $this->guzzleClient;
    }

    /**
     * Build API Method URL
     *
     * @param array $queryParams Query params
     *
     * @return string API Method URL
     */
    protected function buildMethodApiUrl(array $queryParams)
    {
        return static::$apiUrl . static::$partOfUrl . '?' . http_build_query($queryParams);
    }
}
