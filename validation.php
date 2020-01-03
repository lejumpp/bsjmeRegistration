<?php
    include 'database_functions.php';
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $errorFlag=null;
        foreach($_POST as $key => $value)
        {
            ///echo $key."<br>";
            if(empty(test_input($value)))
            {
                echo"A field is empty ".$key."<br>";
                var_dump($key);
                $errorFlag=1;
            }
            else
            {
                $$key = test_input($value);
            }
        }
        if($errorFlag==1)
        {
            echo"An error has occured";
            //$errorFlag=null;
        }
        else
        {
            if(strlen($trn)!=9){
                $errorFlag=1;
            }
            if(!preg_match("/^1-[1-9]{3}-[1-9]{3}-[0-9]{4}$/",$companyNumber)){
                $errorFlag=1;
            }
            if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $companyEmail)){
                $errorFlag=1;
            }
            if(!filter_var($companyWebsite, FILTER_VALIDATE_URL)){
                $errorFlag=1;
            }
            else //this else is for the insertion function in database_functions
            {
                insert_client($conn,$trn,$companyName,$clientName,$companyAddress,$companyCounty,$companyParish,
                                $companyCity,$companyNumber,$companyEmail,$companyWebsite);
            }
        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>