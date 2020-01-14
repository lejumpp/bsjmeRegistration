<?php
    include 'database_functions.php';
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $responseArray=[];
        $questionArray=[];
        $errorFlag=null;
        foreach($_POST as $key => $value)
        {
            ///echo $key."<br>";
            if(empty(test_input($value)))
            {
                echo"A field is empty ".$key."<br>";
                //var_dump($key);
                $errorFlag=1;
            }
            else
            {
                $$key = test_input($value);
                if(is_numeric($key))
                {
                    array_push($questionArray,$key);
                    array_push($responseArray,$value);
                }
            }
        }
        var_dump($questionArray);
        var_dump($responseArray);
        if($errorFlag==1)
        {
            echo"An error has occured";
            //$errorFlag=null;
        }
        else
        {
            if(strlen($trn)!=9){
                echo"An error has occured 1";
                $errorFlag=1;
            }
            if(!preg_match("/^1-[1-9]{3}-[1-9]{3}-[0-9]{4}$/",$companyNumber)){
                echo"An error has occured 2";
                $errorFlag=1;
            }
            if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $companyEmail)){
                echo"An error has occured 3";
                $errorFlag=1;
            }
            if(!filter_var($companyWebsite, FILTER_VALIDATE_URL)){
                echo"An error has occured 4";
                $errorFlag=1;
            }
            else //this else is for the insertion function in database_functions
            {
                echo"else statement";
                if(insert_client($conn,$trn,$companyName,$clientName,$companyAddress,$companyCounty,$companyParish,
                $companyCity,$companyNumber,$companyEmail,$companyWebsite))
                {
                    if(!insert_responses($conn,$trn,$questionArray,$responseArray)){
                        echo"<br>no errors";
                    }
                    else{
                        echo"<br>erros";
                    }
                }
                else{
                    echo "<br>Error in adding a new pending client";
                }
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