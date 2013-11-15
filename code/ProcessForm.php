<?php
include "ApiConfig.php";
include "lib/RpmApi.php";
class ProcessForm
{
    private $errorMessage = "";
    private function validateData()
    {
        return
            !empty($_POST['name']) &&
            !empty($_POST['email']) &&
            !empty($_POST['message']);
    }
    private function emailValid($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    private function invalidate($message) {
        $this->errorMessage = $message;
    }

    public function errorMessage() {
        return $this->errorMessage;
    }

    public function go()
    {
        if (!$this->validateData($_POST)) {
            $this->invalidate('Please fill all the fields');
            return;
        }
        if (!$this->emailValid($_POST['email'])) {
            $this->invalidate('The email provided is not valid');
            return;
        }
        if ($this->errorMessage != "") {
             return false;
        }
        $rpm = new RpmApi(ApiConfig::$ApiUrl, ApiConfig::$ApiKey);
        $data = array(
            'ProcessID' => ApiConfig::$ProcessID,
            'Form' => array(
                'Fields' => array(
                    array(
                        'Field' => 'name',
                        'Value' => $_POST['name'],
                    ),
                    array(
                        'Field' => 'email',
                        'Value' => $_POST['email'],
                    ),
                    array(
                        'Field' => 'message',
                        'Value' => $_POST['message'],
                    ),
                )
            )
        );
        $newForm = $rpm->send('ProcFormAdd', $data);
        return $newForm;
    }
    
}
