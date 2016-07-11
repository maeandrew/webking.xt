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
use Fresh\DeliveryAuto\Mapping\Tariff\Category;

/**
 * API method to get list of tariff categories
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ListOfTariffCategories extends AbstractApiMethod
{
    /**
     * {@inheritdoc}
     */
    protected static $partOfUrl = 'Public/GetTariffCategory';

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
     * @return array|Category[]
     */
    public function getObjectMappedResult()
    {
        $result = [];

        foreach ($this->getArrayResult() as $item) {
            $id         = isset($item['id']) ? $item['id'] : null;
            $name       = isset($item['name']) ? $item['name'] : null;
            $categoryId = isset($item['Category']) ? $item['Category'] : null;
            $maxSize    = isset($item['MaxWidth']) ? $item['MaxWidth'] : null;
            $maxWidth   = isset($item['MaxSize']) ? $item['MaxSize'] : null;

            $category = (new Category())->setId($id)
                                        ->setName($name)
                                        ->setCategoryId($categoryId)
                                        ->setMaxSize($maxSize)
                                        ->setMaxWidth($maxWidth);

            array_push($result, $category);
        }

        return $result;
    }
}
