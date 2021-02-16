<?php

namespace Controllers
{
    use Models\FormViewModel;
    
    class FormController
    {
        private $helloassoApiWrapper;

        public function __construct($helloassoApiWrapper)
        {
            $this->helloassoApiWrapper = $helloassoApiWrapper;
        }

        public function get()
        {
            $model = new FormViewModel();
            return ['form', $model];
        }

        /**
         * Get all values posted from submitted form, store them in model then call api wrapper
         */
        public function post()
        {
            $model = new FormViewModel();
            $model->firstname = $_POST['firstname'];
            $model->lastname = $_POST['lastname'];
            $model->isCompany = isset($_POST['iscompany']) == 1;
            $model->company = $_POST['company'];
            $model->email = $_POST['email'];
            $model->birthdate = $_POST['birthdate'];
            $model->address = $_POST['address'];
            $model->zipcode = $_POST['zipcode'];
            $model->city = $_POST['city'];
            $model->country = $_POST['country'];
            $model->amount = $_POST['amount'];
            
            // Call API
            $response = $this->helloassoApiWrapper->initCart($model);

            if(isset($response->token)) {
                // If success, redirect to HelloAsso
                $url = $this->helloassoApiWrapper->getPaymentFormUrl($response->token);
                header('Location:' . $url);
                exit();
            } else if (isset($response)) {
                $model->error = $response->error;
                return ['form', $model];
            } else {
                $model->error = "Une erreur inconnue s'est produite";
                return ['form', $model];
            }
        }

        public function success()
        {
            return ['success', null];
        }

        public function error()
        {
            return ['error', null];
        }
    }
}

?>