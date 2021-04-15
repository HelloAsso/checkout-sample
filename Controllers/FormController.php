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
            $model->id = rand();
            $model->method = 1;
            return ['form', $model];
        }

        /**
         * Get all values posted from submitted form, store them in model then call api wrapper
         */
        public function post()
        {
            $model = new FormViewModel();
            $model->id = $_POST['id'];
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
            $model->method = $_POST['method'];

            // Call API
            $response = $this->helloassoApiWrapper->initCart($model);

            if(isset($response->redirectUrl)) {
                // We can store checkout id somewhere
                //$response->checkoutIntentId;

                // then redirect to HelloAsso
                header('Location:' . $response->redirectUrl);
                exit();
            } else if (isset($response)) {
                $model->error = $response->error;
                return ['form', $model];
            } else {
                $model->error = "Une erreur inconnue s'est produite";
                return ['form', $model];
            }
        }

        public function return()
        {
            return ['return', null];
        }
    }
}

?>