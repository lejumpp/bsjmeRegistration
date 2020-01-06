<?php
    $servername = "localhost";
    $username = "root";
    $password ="";
    $dbname= "bsjme";
    // Create connection
    $conn = mysqli_connect($servername,$username,$password, $dbname);
    // Check connection
    if(!$conn)
    {
        die("Connection failed: ".mysqli_connect_error());
    }

    function get_requirementQuesitons($conn)
    {
        $sql = "SELECT * FROM `requirements`";
        $results = mysqli_query($conn,$sql);
        if(mysqli_num_rows($results)>0)
        {
            return $results;
        }
        else
        {
            return null;
        }
    }

    function get_standards($conn)
    {
        $sql = "SELECT * FROM `standard`";
        $results = mysqli_query($conn,$sql);
        if(mysqli_num_rows($results)>0)
        {
            return $results;
        }
        else
        {
            return null;
        }
    }

    function insert_client($conn,$trn,$companyName,$clientName,$companyAddress,$companyCounty,$companyParish,
                            $companyCity,$companyNumber,$companyEmail,$companyWebsite)
    {
        if(check_client_exist($conn,$trn))
        {
            update_client_attempt($conn, $trn);
        }
        else
        {
            $sql = "INSERT INTO `pending_clients` (`ID`, `trn`, `companyName`, `clientName`, `clientAddress`, `clientCounty`, `clientParish`, `clientCity`, `clientContact`, `clientEmail`, `clientWebsite`, `attempts`,`active`) 
            VALUES (NULL, '$trn', '$companyName', '$clientName', '$companyAddress', '$companyCounty', '$companyParish', '$companyCity',  '$companyNumber', '$companyEmail', '$clientWebsite', 1, 1;)";
            if(mysqli_query($conn, $sql))
            {
                echo "Insertion successful";
            }
            else
            {
                echo "Insertion unsuccessful";
            }        
        }
        
    }

    function check_client_exist($conn,$trn)
    {
        $sql = "SELECT * FROM `pending_clients` WHERE `trn`=$trn";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //confirm whether when a client is registering if they will use one trn 
    // or is it a case where different different branches/ departments of the client will be wanting a standard
    function update_client_attempt($conn, $trn)
    {
        $sql = "UPDATE `pending_clients` SET `attempts` = `attempts` + 1 WHERE `trn` = '$trn'";
        if(mysqli_query($conn, $sql))
        {
            echo "Update successful";
        }
        else
        {
            echo "Update unsuccessful";
        }
    }
?>