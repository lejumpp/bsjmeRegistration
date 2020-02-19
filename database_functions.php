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

    function get_county($conn)
    {
        $sql = "SELECT * FROM `county`";
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

    function get_parish($conn)
    {
        $sql = "SELECT * FROM `parish`";
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
            if(update_client_attempt($conn, $trn))
            {
                return true;
            }
            else{
                return false;
            }
        }
        else
        {
            $sql = "INSERT INTO `pending_clients` (`id`, `trn`, `companyName`, `clientName`, `clientAddress`, `clientCounty`, `clientParish`, `clientCity`, `clientContact`, `clientEmail`, `clientWebsite`, `attempts`,`active`)
            VALUES (NULL, '$trn', '$companyName', '$clientName', '$companyAddress', '$companyCounty', '$companyParish', '$companyCity',  '$companyNumber', '$companyEmail', '$companyWebsite', 1, 3)";
            
            if(mysqli_query($conn, $sql))
            {
               return true;
            }
            else
            {
                return false;
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
            return true;
        }
        else
        {
            return false;
        }
    }

    function insert_responses($conn,$trn,$questionIdArray,$responesArray)
    {
        for($x=0; $x<count($questionIdArray); $x++)
        {
                $sql = "INSERT INTO `pcresponses` (`id`, `pdTRN`, `rId`, `questionResponse`) VALUES (NULL, '$trn', '$questionIdArray[$x]', '$responesArray[$x]')";
                if(mysqli_query($conn, $sql))
                {
                    echo '<script>console.log("Saved Successfully!"); </script>';
                }
                else{
                    echo '<script>console.log("Save was not successful!"); </script>';
                    return false;
                }
        }
    }

    function insert_document($conn, $trn, $document)
    {
        
        $sql ="INSERT INTO `pcdocument`(`id`, `trn`, `docname`) VALUES (NULL, '$trn', '$document')";
        if(mysqli_query($conn, $sql))
        {
            echo '<script>console.log("Saved Successfully!"); </script>';
            $path = "../../bsjme/upload/documents/".$trn."/";
            if(!is_dir($path))//if path doesn't exist already
            {
                mkdir($path,0755,TRUE);
                return $path;
            }
            else
            {
                echo '<script>console.log("Directory already exist!"); </script>';
                return $path;
            }
        }
        else
        {
            echo '<script>console.log("Save was not successful!"); </script>';
            return false;
        }
    }
?>