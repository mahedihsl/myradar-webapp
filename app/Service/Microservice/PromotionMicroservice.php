<?php

namespace App\Service\Microservice;

class PromotionMicroservice extends BaseService
{
    const SERVICE_NAME = 'promotion';

    public function __construct()
    {
        parent::__construct(self::SERVICE_NAME);
    }

    public function saveCouponLead($data)
    {
        return $this->post('/lead/lucky-coupon', $data);
    }

    public function saveDemoLead($data)
    {
        return $this->post('/lead/demo-user', $data);
    }

    public function saveContactMessage($data)
    {
        return $this->post('/lead/contact-message', $data);
    }
}
