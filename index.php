<?php
    include 'database_functions.php';
    $requirement_results = get_requirementQuesitons($conn);
    $standard_results = get_standards($conn);
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
            
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="container">
                <a href="https://www.bsj.org.jm/">
                    <img src="./images/bsjLogo.jpg" alt="bsjLogo">
                </a>
                <br>
                <form class="form-group" id="clientRegForm" action="<?php echo htmlspecialchars("./validation.php");?>" method="POST">
                    <!--First page of form tat will capture information about the client-->
                    <div class="tab">
                        <br>
                        <p><span class="error">All fields are required:</span></p>
                        <div class="row">
                            <div class="col">
                                <label for="trn">TRN #:</label>
                                <input type="number" class="form-control" name="trn" placeholder="123456789">
                            </div>
                            <div class="col">
                                    <label for="companyName">Company Name:</label>
                                    <input type="text" class="form-control" name="companyName" placeholder="Bureau of Standards">
                            </div>
                            <div class="col">
                                    <label for="clientName">Client Name:</label>
                                    <input type="text" class="form-control" name="clientName" placeholder="Nicholas Jumpp">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="companyaddress">Address:</label>
                                <input type="text" class="form-control" name="companyAddress"   placeholder="6 Winchester Road">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="companyCounty">County:</label>
                                <select name="companyCounty"   class="custom-select">
                                    <option value="" selected>Select County</optionvalue="">
                                    <option value="Cornwall">Cornwall</option>
                                    <option value="Middlesex">Middlesex</option>
                                    <option value="Surrey">Surrey</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="companyParish">Parish:</label>
                                <select name="companyParish" class="custom-select"  >
                                    <option value="" selected>Select Parish</option>
                                    <option value="St. Thomas">St. Thomas</option>
                                    <option value="St. Andrew">St. Andrew</option>
                                    <option value="Kingston">Kingston</option>
                                    <option value="St. Catherine">St. Catherine</option>
                                    <option value="Clarendon">Clarendon</option>
                                    <option value="Manchester">Manchester</option>
                                    <option value="St. Elizabeth">St. Elizabeth</option>
                                    <option value="Westmoreland">Westmoreland</option>
                                    <option value="Hanover">Hanover</option>
                                    <option value="St. James">St. James</option>
                                    <option value="Trelawny">Trelawny</option>
                                    <option value="St. Ann">St. Ann</option>
                                    <option value="St. Mary">St. Mary</option>
                                    <option value="Portland">Portland</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="companyCity">City:</label>
                                <input type="text" class="form-control" name="companyCity"   placeholder="Kingston 10">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="companyNumber">Contact:</label>
                                <input type="text" class="form-control" name="companyNumber"   placeholder="1-xxx-xxx-xxxx">
                            </div>
                            <div class="col">
                                <label for="companyEmail">Email:</label>
                                <input type="email" class="form-control" name="companyEmail"   placeholder="company@example.org">
                            </div>
                            <div class="col">
                                <label for="companyWebsite">Website:</label>
                                <input type="text" class="form-control" name="companyWebsite"   placeholder="https://www.bsj.org.jm/">
                            </div>
                        </div>
                    </div>
                    <!--Second page of form which the requirements questions will be displayed from the database-->
                    <div class="tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" id="progressBar" style="width:33%"></div>
                        </div>
                        <br>
                        <?php
                            $quest_no=1;
                            if($requirement_results==null)
                            {
                                echo"<h3>No Questions Available. Try Again Later</h3>";
                            }
                            else
                            {
                                echo "<p><span class='error'>All fields are required,<br>Hover on question for description</span></p>";
                                while($row = mysqli_fetch_assoc($requirement_results))
                                {
                                    $choices=array();
                                    echo "
                                    <div class='row'>
                                        <div class='col'>
                                        <div class='hint'>
                                            <a href='#' data-toggle='tooltip' data-placement='right' title='".$row["questionDescription"]."'><label for='question".$row["id"]."'>".$quest_no.". ".$row["question"]."</label></a>
                                        </div>
                                            ";
                                            if($row["questionType"]=="RADIO")
                                            {
                                                $choices = json_decode($row["questionChoice"],true);
                                                foreach($choices as $choice)
                                                {
                                                    echo"
                                                    <div class='form-check-inline'>
                                                        <label class='form-check-label'>
                                                            <input type='radio' checked class='form-check-input' name='question".$row["id"]."'  value='".strtolower($choice)."'>".ucfirst(strtolower($choice))."
                                                        </label>
                                                    </div>
                                                    ";
                                                }
                                            }
                                            elseif($row["questionType"]=="CHECKBOX")
                                            {
                                                $choices = json_decode($row["questionChoice"],true);
                                                foreach($choices as $choice)
                                                {
                                                    echo"
                                                    <div class='form-check-inline'>
                                                        <label class='form-check-label'>
                                                            <input type='checkbox' class='form-check-input' name='question".$row["id"]."'  value='".strtolower($choice)."'>".strtolower($choice)."
                                                        </label>
                                                    </div>
                                                    ";
                                                }
                                            }
                                            elseif($row["questionType"]=="TEXT" || $row["questionType"]=="TEXTAREA" )
                                            {
                                                echo"
                                                <textarea style='overflow:auto;resize:none' class='form-control' rows='1' name='question".$row["id"]."' ></textarea>
                                                ";
                                            }
                                            elseif($row["questionType"]=="LIST" )
                                            {
                                                $choices = json_decode($row["questionChoice"],true);
                                                echo"
                                                <div class='form-group'>
                                                    <select class='form-control' id='question".$row["id"]."'>
                                                        <option value='' selected>Select One</option>";
                                                        
                                                        foreach($choices as $choice)
                                                        {
                                                            echo"
                                                            <option value='".strtolower($choice)."'>".strtolower($choice)."</option>
                                                            ";
                                                        }
                                                    echo"
                                                    </select>
                                                </div>
                                                ";
                                            }
                                    echo"</div>
                                        </div>
                                        ";     
                                        $quest_no++;
                                }
                            }                            
                        ?>
                        <br>
                        <div class="row" align="left">
                            <div class="col">
                                <label for="committmentLetter">Please upload committment letter here.</label>
                                <!-- <br> -->
                                <input type="file" class="form-control-file" name="committmentLetter"  value="">
                            </div>
                        </div>
                    </div>
                    <!--Third page of form-->
                    <div class="tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" id="progressBar" style="width:66%"></div>
                        </div>
                        <br>
                        <!-- to be written in php to make it dynamic as the database grows-->
                        <div class="row">
                            <div class="col">
                                <p><span class='error'>All fields are required:</span></p>
                                <label for="targetStandard">Target/Goal:</label>
                                <select class="form-control"  name="targetStandard">
                                    <option value="" selected>Select Standard</option>
                                    <?php
                                    if($standard_results==null)
                                    {
                                        echo"
                                        <option>No Standards Available</option>
                                        ";
                                    }
                                    else{
                                        while($row = mysqli_fetch_assoc($standard_results))
                                        {
                                            echo"
                                            <option>".$row["name"]."</option>
                                            ";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="ClauseNumber">Result:</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="clauses"  value="all">All Clauses
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="clauses"  value="manual">Manual (specific clauses)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <button type="button" id="btnPrev" class="btn btn-outline-secondary btn-block" onclick="nextPrev(-1)">Previous</button>
                        </div>
                        <div class="col">
                            <button type="button" id="btnNext" class="btn btn-primary btn-block" onclick="nextPrev(1)">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            var currentTab = 0; // Current tab is set to be the first tab (0)
            showTab(currentTab); // Display the current tab

            $(document).ready(function()
            {
                $('[data-toggle="tooltip"]').tooltip();   
            });
            
            function showTab(n) 
            {
                // This function will display the specified tab of the form...
                var x = document.getElementsByClassName("tab");
                x[n].style.display = "block";
                //... and fix the Previous/Next buttons:
                if (n == 0) {
                    document.getElementById("btnPrev").style.display = "none";
                } else {
                    document.getElementById("btnPrev").style.display = "inline";
                }
                if (n == (x.length - 1)) {
                    document.getElementById("btnNext").innerHTML = "Submit";
                } else {
                    document.getElementById("btnNext").innerHTML = "Next";
                }
            }

            function nextPrev(n) 
            {
                // This function will figure out which tab to display
                var x = document.getElementsByClassName("tab");
                
                // Hide the current tab:
                x[currentTab].style.display = "none";
                // Increase or decrease the current tab by 1:
                currentTab = currentTab + n;
                // if you have reached the end of the form...
                if (currentTab >= x.length) {
                    // ... the form gets submitted:
                    document.getElementById("clientRegForm").submit();
                    return false;
                }
                // Otherwise, display the correct tab:
                showTab(currentTab);
            }

        </script>
    </body>
</html>