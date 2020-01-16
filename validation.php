<?php
    session_start();
    include 'database_functions.php';
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $responseArray=[];
        $questionArray=[];
        $errorFlag=null;
        $_SESSION['errFlag']=null;
        foreach($_POST as $key => $value)
        {
            ///echo $key."<br>";
            if(empty(test_input($value)))
            {
                echo"A field is empty ".$key."<br>";
                //var_dump($key);
                $errorFlag=1;
                $_SESSION['errFlag']=1;
            }
            else
            {
                $$key = test_input($value);
                $_SESSION[$key] = test_input($value);
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
                $_SESSION['errFlag']=1;
            }
            if(!preg_match("/^1-[1-9]{3}-[1-9]{3}-[0-9]{4}$/",$companyNumber)){
                echo"An error has occured 2";
                $errorFlag=1;
                $_SESSION['errFlag']=1;
            }
            if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $companyEmail)){
                echo"An error has occured 3";
                $errorFlag=1;
                $_SESSION['errFlag']=1;
            }
            else //this else is for the insertion function in database_functions
            {
                
                echo"else statement";
                if(insert_client($conn,$trn,$companyName,$clientName,$companyAddress,$companyCounty,$companyParish,
                $companyCity,$companyNumber,$companyEmail,$companyWebsite))
                {
                    if(!insert_responses($conn,$trn,$questionArray,$responseArray)){
                        echo"<br>no errors inserting response";
                        if(saveFile($conn,$trn))
                        {
                            echo"No error occured";
                        }
                        else
                        {
                            echo"Error occured";
                        }
                    }
                    else{
                        echo"<br>errors inserting responses";
                    }
                }
                else
                {
                    echo "<br>Error in adding a new pending client";
                }
            }
        }
    }
    else
    {
        successScreen();
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function saveFile($conn,$trn)
    {
        //echo $committmentLetter;
        $fileName= $_FILES['committmentLetter']['name'];
        if($fileName!=null)
        {
            $path=insert_document($conn,$trn,$fileName);
            if($path)
            {
                //save the file locally on the machine
                $targetFile = $path . basename($_FILES["committmentLetter"]["name"]);
                echo "<br>".$targetFile;
                if(move_uploaded_file($_FILES["committmentLetter"]["tmp_name"], $targetFile))
                {
                    echo '<script>console.log("Saved Successfully!"); </script>';
                    return true;
                }
                else
                {
                    echo '<script>console.log("Did not save Successfully!"); </script>';
                    return false;
                }
            }
            else
            {
                echo '<script>console.log("Did not save Successfully!"); </script>';
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    function successScreen()
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>BSJ REGISTRATION</title>
                <!-- Latest compiled and minified CSS -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
                <!-- jQuery library -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                <!-- Popper JS -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
                <!-- Latest compiled JavaScript -->
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
                <!--Main Style Sheet-->
                <link rel="stylesheet" href="./css/main.css">
                <style>
                    body 
                    {
                        /* background-color: #f1f1f1; */
                        background-image: url("./images/background.jpg");
                        /* background-repeat: no-repeat; */
                    }
                    label
                    {
                        color: black;
                    }
                    .container{
                        position: absolute;
                        margin: auto;
                        top: 20%;
                        right: 0;
                        bottom: 0;
                        left: 0;
                    }
                    .text-box{
                        width: 80%;
                        padding: 15px;
                        background-color: white;
                        box-shadow: 10px 10px 5px grey;
                        word-wrap: break-word;
                    }
                </style>
            </head>
            <body>
                <div class="container" align= "center">
                    <a href="https://www.bsj.org.jm/">
                        <img src="./images/bsjLogo.jpg" alt="bsjLogo">
                    </a>
                    <br>
                    <div class="text-box">
                        <h1>Thank You for Your Interest!</h1>
                        <h4>Your information has been sent to a coordinator that will make contact with you via email or call.</h4>
                    </div>
                </div>
            </body>
        </html>
        <?php
    }
?>