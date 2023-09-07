<?php

namespace App\Services\SendingProcess\Telecom\SMPP;

/**
 * Primitive class for encapsulating smpp addresses
 * @author hd@onlinecity.dk
 */
class SmppAddress
{
    // numbering-plan-indicator
    public $value;

    /**
     * Construct a new object of class Address
     *
     * @param string $value
     * @param integer $ton
     * @param integer $npi
     * @throws InvalidArgumentException
     */
    public function __construct($value, public $ton = SMPP::TON_UNKNOWN, public $npi = SMPP::NPI_UNKNOWN)
    {
        // Address-Value field may contain 10 octets (12-length-type), see 3GPP TS 23.040 v 9.3.0 - section 9.1.2.5 page 46.
//		if ($ton == SMPP::TON_ALPHANUMERIC && strlen($value) > 11) throw new \InvalidArgumentException('Alphanumeric address may only contain 11 chars'); //MrMsg asked to disable
//		if ($ton == SMPP::TON_INTERNATIONAL && $npi == SMPP::NPI_E164 && strlen($value) > 15) throw new \InvalidArgumentException('E164 address may only contain 15 digits');

        $this->value = (string)$value;
    }
}
