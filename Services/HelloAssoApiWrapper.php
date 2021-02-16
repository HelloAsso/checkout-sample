<?php

namespace Services
{
    /**
     * This class could appear complicated but once prefill documentation in your hands it will make perfect sens !
     */
    class HelloAssoApiWrapper
    {
        private $config;

        public function __construct($config)
        {
            $this->config = $config;
        }

        /**
         * We need to change url segment for prefill
         */
        private function getPrefillUrl()
        {
            return str_replace('/paiements/', '/prefill/', $this->config->formUrl);
        }

        /**
         * Call HelloAsso API to initialize cart
         * If ok this function return a token 
         * Else an error code
         */
        public function initCart($data)   
        {
            $request = new \HTTP_Request2();
            $request->setUrl($this->getPrefillUrl() . '/initializeform'); 
            $request->setMethod(\HTTP_Request2::METHOD_POST);
            $request->setHeader(array(
                'Content-Type' => 'application/json',
            ));
            $date = new \Datetime($data->birthdate);
            $request->setBody('{"FirstName":"' . $data->firstname . '",
                                "LastName":"' . $data->lastname . '",
                                "IsCompany":' . ($data->isCompany ? 'true' : 'false') . ',
                                "Company":"' . $data->company . '",
                                "Email":"' . $data->email . '",
                                "BirthDate":"' . $date->format('d/m/Y') . '",
                                "Address":"' . $data->address . '",
                                "ZipCode":"' . $data->zipcode . '",
                                "City":"' . $data->city . '",
                                "Country":"' . $data->country . '",
                                "Amount":' . ($data->amount * 100) . ',
                                "PartnerId":"' . $this->config->partnerId . '",
                                "ErrorUrl":"' . $this->config->errorUrl . '",
                                "ReturnUrl":"' . $this->config->successUrl . '"}');

            try{
                $response = $request->send();
                print_r($response);
                return json_decode($response->getBody());
            } catch(\Exception $e){
                return json_decode('{"error":"' . $e . '"}');
            }
        }

        /**
         * Generate url for redirect
         */
        public function getPaymentFormUrl($token)
        {
            return $this->getPrefillUrl() . '?token=' . $token;
        }
    }
}

?>