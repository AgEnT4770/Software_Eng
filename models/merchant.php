<?php

class Merchant extends User {
    private $merchant_name;

    public function getMerchantName() { return $this->merchant_name; }
    public function setMerchantName($merchant_name) { $this->merchant_name = $merchant_name; }
}
?>