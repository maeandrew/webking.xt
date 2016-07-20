<?php
/*
 * This file is part of the "Delivery Auto" API PHP Client
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fresh\DeliveryAuto\Directory;

/**
 * ReceiptStatus
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ReceiptStatus
{
    const NOT_SPECIFIED = 0;

    const PARTIALLY_ISSUED = 1;

    const ISSUED = 2;

    const RECOVERED = 3;

    const SOLD = 4;

    const CANCELED = 5;

    const ON_THE_WAY = 6;

    const IN_STOCK = 7;

    const RESERVED = 8;
}
