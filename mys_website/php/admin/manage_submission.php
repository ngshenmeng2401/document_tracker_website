<?php
session_start();
include("dbconnect.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/home8/hubbuddi/public_html/271490/mys_website/php/PHPMailer/Exception.php';
require '/home8/hubbuddi/public_html/271490/mys_website/php/PHPMailer/PHPMailer.php';
require '/home8/hubbuddi/public_html/271490/mys_website/php/PHPMailer/SMTP.php';

if(isset($_POST['submitFile'])){
    
    $submiter_email = $_POST["submiter_email"];
    $profile_id = $_POST["profile_id"];
    $category = $_POST["category"];
    $file = $_FILES["file"];
    $fileName = $_FILES["file"]["name"];
    $fileType = $_FILES["file"]["type"];
    $fileSize = $_FILES["file"]["size"];
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $dash= "-";
    $submited = "submited";
    $isValidate = false;
    
    echo $category;
    
    if ($_FILES["file"]["size"] > 1000000) {
        
        echo "<script type='text/javascript'>alert('Cant upload more than 1mb file !!!');window.location.assign('manage_submission.php');</script>'";
    }else{
        
        if (isset($category)){
            
            $sqlsearch1 = "SELECT a.doc_id, a.doc_name, a.type, a.category, a.profile_id, b.EAL, b.TST, b.EQS, b.ans_scheme, b.ER, b.AL, b.syllabus, b.SoW, b.attendance  
            FROM tbl_document a
            JOIN tbl_validation b
            ON b.email = a.email AND b.profile_id = a.profile_id
            WHERE a.email = '$submiter_email' AND a.category = '$category' AND a.profile_id = '$profile_id'";
            $result1 = $con->query($sqlsearch1);
            if ($result1->num_rows > 0) {
                while ($row = $result1 -> fetch_assoc()){
                    extract($row);
                    
                    $docId = $doc_id;

                    if($category == 1 and $EAL == "yes"){
                    
                        $isValidate = true; 
                   
                    }
                    if($category == 2 and $TST == "yes"){
                    
                        $isValidate = true; 
                   
                    }
                    if($category == 3 and $EQS == "yes"){
                    
                        $isValidate = true; 
                   
                    }
                    if($category == 4 and $ans_scheme == "yes"){
                    
                        $isValidate = true; 
                   
                    }
                    if($category == 5 and $ER == "yes"){
                    
                        $isValidate = true; 
                   
                    }
                    if($category == 6 and $AL == "yes"){
                    
                        $isValidate = true; 
                   
                    }
                    if($category == 7 and $syllabus == "yes"){
                    
                        $isValidate = true; 
                   
                    }
                    if($category == 8 and $SoW == "yes"){
                    
                        $isValidate = true; 
                   
                    }
                    if($category == 9 and $attendance == "yes"){
                    
                        $isValidate = true; 
                   
                    }
                    else{
                        
                        $updateDoc = "UPDATE tbl_document SET doc_name = '$fileName', type = '$ext' WHERE email = '$submiter_email' AND category = '$category' AND profile_id = '$profile_id'";
                        
                    }
                }
                
            }else{
                
                $submitDoc = "INSERT INTO `tbl_document`(`email`, `doc_name`, `type`, `category`, `validation_status`, `profile_id`) VALUES('$submiter_email','$fileName','$ext','$category','$dash', '$profile_id')";
            }
        
            $sqlsearch2 = "SELECT * FROM tbl_submission WHERE email = '$submiter_email' AND profile_id = '$profile_id'";
    
            $result2 = $con->query($sqlsearch2);
            if ($result2->num_rows > 0) {
                
                switch ($category) {
                    case 1:
                    $updateSubmission = "UPDATE tbl_submission SET EAL = '$submited' WHERE email = '$submiter_email' AND profile_id = '$profile_id'";
                    break;
                    case 2:
                    $updateSubmission = "UPDATE tbl_submission SET TST = '$submited' WHERE email = '$submiter_email' AND profile_id = '$profile_id'";
                    break;
                    case 3:
                    $updateSubmission = "UPDATE tbl_submission SET EQS = '$submited' WHERE email = '$submiter_email' AND profile_id = '$profile_id'";
                    break;
                    case 4:
                    $updateSubmission = "UPDATE tbl_submission SET ans_scheme = '$submited' WHERE email = '$submiter_email' AND profile_id = '$profile_id'";
                    break;
                    case 5:
                    $updateSubmission = "UPDATE tbl_submission SET ER = '$submited' WHERE email = '$submiter_email' AND profile_id = '$profile_id'";
                    break;
                    case 6:
                    $updateSubmission = "UPDATE tbl_submission SET AL = '$submited' WHERE email = '$submiter_email' AND profile_id = '$profile_id'";
                    break;
                    case 7:
                    $updateSubmission = "UPDATE tbl_submission SET syllabus = '$submited' WHERE email = '$submiter_email' AND profile_id = '$profile_id'";
                    break;
                    case 8:
                    $updateSubmission = "UPDATE tbl_submission SET SoW = '$submited' WHERE email = '$submiter_email' AND profile_id = '$profile_id'";
                    break;
                    case 9:
                    $updateSubmission = "UPDATE tbl_submission SET attendance = '$submited' WHERE email = '$submiter_email' AND profile_id = '$profile_id'";
                    break;
                }
                
            }else{
                echo "<script type='text/javascript'>alert('Not found the record!!!');window.location.assign('manage_submission.php');</script>'";
            }
            
            if($isValidate == true){
                echo "<script type='text/javascript'>alert('This category document is already validate !!!');window.location.assign('manage_submission.php');</script>'";
            }
            else if($con->query($updateSubmission) === TRUE and $con->query($submitDoc) === TRUE)
            {
                
                $filename = mysqli_insert_id($con);
                move_uploaded_file($file["tmp_name"], "../../assets/files/manage_document/".$filename.".".$ext);
                echo "<script type='text/javascript'>alert('Success!!!');window.location.assign('manage_submission.php');</script>'";
                
            }else if($con->query($updateSubmission) === TRUE and $con->query($updateDoc) === TRUE){
                
                move_uploaded_file($file["tmp_name"], "../../assets/files/manage_document/".$docId.".".$ext);
                echo "<script type='text/javascript'>alert('Success!!!');window.location.assign('manage_submission.php');</script>'";
                
            }else{
                echo "<script type='text/javascript'>alert('Failed!!!');window.location.assign('manage_submission.php');</script>'";
            }
            
        }else {
            
            echo "<script type='text/javascript'>alert('Please select a category!!!');window.location.assign('manage_submission.php');</script>'";
        }
    }
    
    
}else if (isset($_POST['deleteSubmission'])){
        
    $submission_id = $_POST["submission_id2"];
    
    $sqlsearch = "SELECT * FROM tbl_submission WHERE submission_id = '$submission_id'";
    
    $result = $con->query($sqlsearch);
    if ($result->num_rows > 0){
        while ($row = $result -> fetch_assoc()){
            extract($row);
            
            if($EAL == "submited" or $TST == "submited" or $EQS == "submited" or $ans_scheme == "submited" or $ER == "submited" or $AL == "submited" or $syllabus == "submited" or $SoW == "submited"){
                
                echo "<script type='text/javascript'>alert('Delete Failed ! Already submit document !!!');window.location.assign('manage_submission.php');</script>'";
            
                
            }else{
        
                $deleteSubmission = "DELETE FROM `tbl_submission` WHERE submission_id = '$submission_id'";
                
                if($con->query($deleteSubmission) === TRUE)
                {
                    echo "<script type='text/javascript'>alert('Success!');window.location.assign('manage_submission.php');</script>'";
                }else{
                    echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('manage_submission.php');</script>'";
                }
            }
        }
        
    }
}else if (isset($_POST['sendNotification'])){
    
    // $category = $_POST["eal"];
    // $category = $_POST["tst"];
    // $category = $_POST["eqs"];
    // $category = $_POST["answer_scheme"];
    // $category = $_POST["er"];
    // $category = $_POST["al"];
    // $category = $_POST["syllabus"];
    // $category = $_POST["sow"];
        
    $email = $_POST["email"];
    $category = $_POST["category"];
    $name = $_POST["name"];
    
    // echo $email;
    // echo $name;

    sendEmail($email,$category,$name);
    echo "<script type='text/javascript'>alert('Sent Successful !!!');window.location.assign('manage_submission.php');</script>'";
}

function sendEmail($email,$category,$name){
    
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;                           //Disable verbose debug output
    $mail->isSMTP();                                //Send using SMTP
    $mail->Host       = 'mail.javathree99.com';                         //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                       //Enable SMTP authentication
    $mail->Username   = 'mystracker@javathree99.com';                         //SMTP username
    $mail->Password   = '9YH4oECcB5tl';                         //SMTP password
    $mail->SMTPSecure = 'tls';         
    $mail->Port       = 587;
    
    
    
    $from = "mystracker@javathree99.com";
    $to = $email;
    $subject = "From Document Tracker. Please submit your document";
    $index = 1 ;
    $message .= "<p>Hi $name, Please submit the following documents at the below:<br><br> ";
    foreach($category as $item){
        $message .= "$index".". "."$item <br>";
        $index++;
    }
    
    $message .= "<br> Thank You";

    $mail->setFrom($from,"Document Tracker");
    $mail->addAddress($to);                                             //Add a recipient
    
    //Content
    $mail->isHTML(true);                                                //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->send();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Submissions</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <link rel="stylesheet" href="../../css/manage_report.css">
</head>
<body style="background-color: #F2EBF3;">

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light " style="background-color: #693D70">
        <div class="container-fluid">
            <!-- <img src="" alt="logo" class="logoimg" > -->
            <a class="navbar-brand text-light" href="dashboard.php">DOCUMENT TRACKER</a>
            <button class="navbar-toggler" 
                type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNavDropdown" 
                aria-controls="navbarNavDropdown" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item me-3">
                    <a class="nav-link text-light" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Manage
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item" href="manage_document.php">Document</a></li>
                      <li><a class="dropdown-item" href="manage_profile.php">Profile</a></li>
                      <li><a class="dropdown-item" href="manage_report.php">Report</a></li>
                      <li><a class="dropdown-item active" href="manage_submission.php">Submission Status</a></li>
                      <li><a class="dropdown-item" href="manage_validation.php">Validation Status</a></li>
                    </ul>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link text-light" href="personal_details.php">User Personal Details</a>
                </li>
            </ul>
            <!-- <form class="d-flex">
                <input class="form-control me-3" type="search" placeholder="Search" aria-label="Search" required>
                <button class="btn me-5 nav-btn-color" type="submit">Search</button>
            </form> -->
            <ul class="navbar-nav" >
                
                <?php
    		    session_start();
                error_reporting(0);
                include("dbconnect.php");
                // echo $_SESSION["email"];
                $email = $_SESSION['email'];
                if (isset($_SESSION["email"])){
                    
                    $sqlloaduser = "SELECT * FROM tbl_user WHERE email = '$email'";
                    $result = $con->query($sqlloaduser);
                    if ($result->num_rows > 0){
                        while ($row = $result -> fetch_assoc()){
                            extract($row);
                            
                            if($img_status =="no"){
                                ?>
                                
                                <li class="nav-item">
                                    <img src="../../assets/images/profile.png" href="admin_profile.php" class="profileimg rounded-circle" alt="profileimg" style="cursor:pointer">
                                </li>
                                <?php
                            }else{
                                ?>
                                <li class="nav-item">
                                    <img src="../../assets/images/profile_img/<?php echo $phone_no; ?>.<?php echo $img_format; ?>" href="admin_profile.php" class="profileimg rounded-circle" alt="profileimg" style="cursor:pointer">
                                </li>
                                <?php
                            }
                            ?>
                            <li class="nav-item mt-1">
                                <a class="nav-link text-light" href="admin_profile.php"><?php echo $name; ?></a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                    <li class="nav-item mt-1">
                        <a class="nav-link text-light" data-bs-toggle="modal" data-bs-target="#logoutModal" href="">Logout</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        </div>
    </nav>

    <!-- Body -->
    <div class="container">
        <div class="row mt-3">
            <!--<div class="col">-->
            <!--<div class="col-5 col-sm-4 col-lg-6 col-xxl-8">-->
            <!--    <button class="btn userlist-btn float-end text-light" data-bs-toggle="modal" data-bs-target="#addSubmissionModal">Add Submission</button>-->
            <!--</div>-->
            <!--<div class="col-7 col-sm-4 col-lg-3 col-xxl-2">-->
            <!--    <a class="btn userlist-btn float-end text-light" href="manage_report_submit.php">User List (Submited)</a>-->
            <!--</div>-->
            <!--<div class="col-12 col-sm-4 col-lg-3 col-xxl-2 mt-2 mt-sm-0">-->
            <!--    <a class="btn userlist-btn float-end text-light" href="manage_report_nosubmit.php">User List (No Submit)</a>-->
            <!--</div>-->
        </div>
    </div>
    <div class="container">
        <div class="row my-4 px-3 px-sm-0">
            <div class="card shadow mb-4">
                <div class="card-body ">
                    <h1 class="text-center mb-3">Submission List</h1>
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered py-3">
                            <thead>
                                <tr>
                                    <th rowspan="2">Bil.</th>
                                    <th colspan="4" class="text-center">Profile</th>
                                    <th colspan="9" class="text-center">Submission Status</th>
                                    <th rowspan="2">Action</th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Subject</th>
                                    <th>Semester</th>
                                    <th>Exam Announcement Letter</th>
                                    <th>Test Specification Table</th>
                                    <th>Examination Question Script</th>
                                    <th>Answer Scheme</th>
                                    <th>Endorsed Result</th>
                                    <th>Appoint Letter</th>
                                    <th>Syllabus</th>
                                    <th>Scheme of Work</th>
                                    <th>Attendance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                    		    session_start();
                                error_reporting(0);
                                include("dbconnect.php");
                                // echo $_SESSION["email"];
                                // $email = $_SESSION['email'];
                                $index = 1;
                                $sqlloadsubmission = "SELECT a.submission_id, a.profile_id, a.email as submitter_email, a.EAL, a.TST, a.EQS, a.ans_scheme, a.ER, a.AL, a.syllabus, a.SoW, a.attendance, b.status, b.subject, b.semester, c.name
                                FROM tbl_submission a  
                                JOIN tbl_profile b
                                ON b.email = a.email AND b.profile_id = a.profile_id
                                JOIN tbl_user c
                                ON c.email= b.email
                                ORDER BY submission_id ASC";
                                
                                $result = $con->query($sqlloadsubmission);
                                if ($result->num_rows > 0){
                                    while ($row = $result -> fetch_assoc()){
                                        extract($row);
                                        
                                        ?>
                                        
                                        <tr>
                                            <td><?php echo $index++ ?></td>
                                            <td><?php echo $name ?></td>
                                            <td><?php echo $status ?></td>
                                            <td><?php echo $subject ?></td>
                                            <td><?php echo $semester ?></td>
                                            <?php
                                                if($EAL == "submited"){
                                                    $sqlloaddocument = "SELECT * FROM tbl_document WHERE email = '$submitter_email' AND category = '1' AND profile_id = '$profile_id'";
                                                    $result2 = $con->query($sqlloaddocument);
                                                    if ($result2->num_rows > 0){
                                                        while ($row = $result2 -> fetch_assoc()){
                                                            extract($row);
                                                            if($type == "docx"){
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/words.png" style="width: 24px; height: 24px" alt="docx"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/pdf.jpg" style="width: 24px; height: 24px" alt="pdf"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    
                                                }else{
                                                    ?>
                                                    <td><?php echo $EAL ?></td>
                                                    <?php
                                                }
                                            ?>
                                            <?php
                                                if($TST == "submited"){
                                                    $sqlloaddocument = "SELECT * FROM tbl_document WHERE email = '$submitter_email' AND category = '2' AND profile_id = '$profile_id'";
                                                    $result3 = $con->query($sqlloaddocument);
                                                    if ($result3->num_rows > 0){
                                                        while ($row = $result3 -> fetch_assoc()){
                                                            extract($row);
                                                            if($type == "docx"){
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/words.png" style="width: 24px; height: 24px" alt="docx"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/pdf.jpg" style="width: 24px; height: 24px" alt="pdf"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    
                                                }else{
                                                    ?>
                                                    <td><?php echo $TST ?></td>
                                                    <?php
                                                }
                                            ?>
                                            <?php
                                                if($EQS == "submited"){
                                                    $sqlloaddocument = "SELECT * FROM tbl_document WHERE email = '$submitter_email' AND category = '3' AND profile_id = '$profile_id'";
                                                    $result4 = $con->query($sqlloaddocument);
                                                    if ($result4->num_rows > 0){
                                                        while ($row = $result4 -> fetch_assoc()){
                                                            extract($row);
                                                            if($type == "docx"){
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/words.png" style="width: 24px; height: 24px" alt="docx"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/pdf.jpg" style="width: 24px; height: 24px" alt="pdf"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    
                                                }else{
                                                    ?>
                                                    <td><?php echo $EQS ?></td>
                                                    <?php
                                                }
                                            ?>
                                            <?php
                                                if($ans_scheme == "submited"){
                                                    $sqlloaddocument = "SELECT * FROM tbl_document WHERE email = '$submitter_email' AND category = '4' AND profile_id = '$profile_id'";
                                                    $result5 = $con->query($sqlloaddocument);
                                                    if ($result5->num_rows > 0){
                                                        while ($row = $result5 -> fetch_assoc()){
                                                            extract($row);
                                                            if($type == "docx"){
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/words.png" style="width: 24px; height: 24px" alt="docx"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/pdf.jpg" style="width: 24px; height: 24px" alt="pdf"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    
                                                }else{
                                                    ?>
                                                    <td><?php echo $ans_scheme ?></td>
                                                    <?php
                                                }
                                            ?>
                                            <?php
                                                if($ER == "submited"){
                                                    $sqlloaddocument = "SELECT * FROM tbl_document WHERE email = '$submitter_email' AND category = '5' AND profile_id = '$profile_id'";
                                                    $result6 = $con->query($sqlloaddocument);
                                                    if ($result6->num_rows > 0){
                                                        while ($row = $result6 -> fetch_assoc()){
                                                            extract($row);
                                                            if($type == "docx"){
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/words.png" style="width: 24px; height: 24px" alt="docx"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/pdf.jpg" style="width: 24px; height: 24px" alt="pdf"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    
                                                }else{
                                                    ?>
                                                    <td><?php echo $ER ?></td>
                                                    <?php
                                                }
                                            ?>
                                            <?php
                                                if($AL == "submited"){
                                                    $sqlloaddocument = "SELECT * FROM tbl_document WHERE email = '$submitter_email' AND category = '6' AND profile_id = '$profile_id'";
                                                    $result7 = $con->query($sqlloaddocument);
                                                    if ($result7->num_rows > 0){
                                                        while ($row = $result7 -> fetch_assoc()){
                                                            extract($row);
                                                            if($type == "docx"){
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/words.png" style="width: 24px; height: 24px" alt="docx"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/pdf.jpg" style="width: 24px; height: 24px" alt="pdf"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    
                                                }else{
                                                    ?>
                                                    <td><?php echo $AL ?></td>
                                                    <?php
                                                }
                                            ?>
                                            <?php
                                                if($syllabus == "submited"){
                                                    $sqlloaddocument = "SELECT * FROM tbl_document WHERE email = '$submitter_email' AND category = '7' AND profile_id = '$profile_id'";
                                                    $result8 = $con->query($sqlloaddocument);
                                                    if ($result8->num_rows > 0){
                                                        while ($row = $result8 -> fetch_assoc()){
                                                            extract($row);
                                                            if($type == "docx"){
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/words.png" style="width: 24px; height: 24px" alt="docx"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/pdf.jpg" style="width: 24px; height: 24px" alt="pdf"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    
                                                }else{
                                                    ?>
                                                    <td><?php echo $syllabus ?></td>
                                                    <?php
                                                }
                                            ?>
                                            <?php
                                                if($SoW == "submited"){
                                                    $sqlloaddocument = "SELECT * FROM tbl_document WHERE email = '$submitter_email' AND category = '8' AND profile_id = '$profile_id'";
                                                    $result9 = $con->query($sqlloaddocument);
                                                    if ($result9->num_rows > 0){
                                                        while ($row = $result9 -> fetch_assoc()){
                                                            extract($row);
                                                            if($type == "docx"){
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/words.png" style="width: 24px; height: 24px" alt="docx"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/pdf.jpg" style="width: 24px; height: 24px" alt="pdf"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    
                                                }else{
                                                    ?>
                                                    <td><?php echo $SoW ?></td>
                                                    <?php
                                                }
                                            ?>
                                            <?php
                                                if($attendance == "submited"){
                                                    $sqlloaddocument = "SELECT * FROM tbl_document WHERE email = '$submitter_email' AND category = '9' AND profile_id = '$profile_id'";
                                                    $result10 = $con->query($sqlloaddocument);
                                                    if ($result10->num_rows > 0){
                                                        while ($row = $result10 -> fetch_assoc()){
                                                            extract($row);
                                                            if($type == "docx"){
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/words.png" style="width: 24px; height: 24px" alt="docx"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <td><a class="text-dark text-decoration-none" href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/pdf.jpg" style="width: 24px; height: 24px" alt="pdf"> <?php echo $doc_name ?></a></td>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    
                                                }else{
                                                    ?>
                                                    <td><?php echo $attendance ?></td>
                                                    <?php
                                                }
                                            ?>
                                            <td>
                                                <i class="bi bi-file-arrow-up me-3" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#addDocumentModal" onclick="submitDialog('<?php echo $submission_id ?>','<?php echo $submitter_email ?>','<?php echo $profile_id ?>')"></i>
                                                <i class="bi bi-bell me-3" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#notificationModal" onclick="notificationDialog('<?php echo $email ?>','<?php echo $name ?>','<?php echo $EAL ?>','<?php echo $TST ?>','<?php echo $EQS ?>','<?php echo $ans_scheme ?>','<?php echo $ER ?>','<?php echo $AL ?>','<?php echo $syllabus ?>','<?php echo $SoW ?>','<?php echo $attendance ?>')"></i>
                                                <i class="bi bi-trash" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteDialog('<?php echo $submission_id ?>')"></i>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="updateSubmissionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update Submissions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="">
                <div class="modal-body">
                    <p class="h6">Examination Announcement Letter</p> 
                    <input type="hidden" class="form-control" id="document" name="document" aria-describedby="emailHelp" required>
                    <div class="mb-3">
                        <input type="file" class="form-control" id="percentage" name="percentage" aria-describedby="emailHelp" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn userlist-btn text-light" data-bs-dismiss="modal">Save</button>
                    <button type="reset" class="btn btn-outline-warning reset-btn" data-bs-dismiss="modal" aria-label="Close">Reset</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    
    <!--Modal-->
    
    <div class="modal fade" id="addSubmissionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <select class="form-select" aria-label="Default select example" name="profile_id">
                                <!--<option selected>Open this select menu</option>-->
                                <?php
                                    session_start();
                                    error_reporting(0);
                                    include("dbconnect.php");
                                    
                                    $sqlloadprofile = "SELECT * FROM tbl_profile";
                                    $result = $con->query($sqlloadprofile);
                                    if ($result->num_rows > 0){
                                        while ($row = $result -> fetch_assoc()){
                                            extract($row);
                                            
                                            ?>
                                            <option value="<?php echo $profile_id; ?>"><?php echo $name; ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Submited Document</label>
                            <input type="number" class="form-control" id="submitedDocument1" name="submitedDocument" aria-describedby="emailHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Not Submit Document</label>
                            <input type="number" class="form-control" id="noSubmitDocument1" name="noSubmitDocument" aria-describedby="emailHelp" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn userlist-btn text-light" data-bs-dismiss="modal" name="submitReport">Save</button>
                        <button type="reset" class="btn btn-outline-warning reset-btn">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!--Modal-->
    <div class="modal fade" id="addDocumentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Submit Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="submitForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <!--<p class="h6">Examination Announcement Letter</p> -->
                        <input type="hidden" class="form-control" id="submiter_email" name="submiter_email" aria-describedby="emailHelp" required>
                        <input type="hidden" class="form-control" id="profile_id1" name="profile_id" aria-describedby="emailHelp" required>
                    <div class="mb-3">
                        <input type="file" class="form-control" id="file" name="file" aria-describedby="emailHelp" accept="file_extension/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Category</label>
                        <select class="form-select" aria-label="Default select example" name="category">
                            <!--<option selected>Select category</option>-->
                            <option value="1" >Exam Announcement Letter</option>
                            <option value="2" >Test Specification Table</option>
                            <option value="3" >Examination Question Script</option>
                            <option value="4" >Answer Scheme</option>
                            <option value="5" >Endorsed Result</option>
                            <option value="6" >Appointment Letter</option>
                            <option value="7" >Syllabus</option>
                            <option value="8" >Scheme of Work</option>
                            <option value="9" >Attendance</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn userlist-btn text-light" data-bs-dismiss="modal" name='submitFile'>Submit</button>
                    <button type="reset" class="btn btn-outline-warning reset-btn" data-bs-dismiss="modal" aria-label="Close">Reset</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="notificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Send email to:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body" >
                    <input type="hidden" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                    <input type="hidden" class="form-control" id="name" name="name" aria-describedby="emailHelp" required>
                    <div class="row mb-2">
                        <div class="col-11">
                            <label for="exampleInputEmail1" class="form-label">Select All</label>
                        </div>
                        <div class="col-1">
                            <input onchange="selectAllCheckboxes()" class="form-check-input" type="checkbox" value="Examination Announcement Letter" id="checkBoxAll" >
                        </div>
                    </div>
                    <div class="row mb-2" id="ealDiv">
                        <div class="col-11">
                            <label for="exampleInputEmail1" class="form-label">Examination Announcement Letter</label>
                        </div>
                        <div class="col-1">
                            <input class="form-check-input checkbox-option" type="checkbox" value="Examination Announcement Letter" id="eal" name="category[]">
                        </div>
                    </div>
                    <div class="row mb-2" id="tstDiv">
                        <div class="col-11">
                            <label for="exampleInputEmail1" class="form-label">Test Specification Table</label>
                        </div>
                        <div class="col-1">
                            <input class="form-check-input checkbox-option" type="checkbox" value="Test Specification Table" id="tst" name="category[]">
                        </div>
                    </div>
                    <div class="row mb-2" id="eqsDiv">
                        <div class="col-11">
                            <label for="exampleInputEmail1" class="form-label">Examination Question Script</label>                        
                        </div>
                        <div class="col-1">
                            <input class="form-check-input checkbox-option" type="checkbox" value="Examination Question Script" id="eqs" name="category[]">
                        </div>
                    </div>
                    <div class="row mb-2" id="ans_schemeDiv">
                        <div class="col-11">
                            <label for="exampleInputEmail1" class="form-label">Answer Scheme</label>                       
                        </div>
                        <div class="col-1">
                            <input class="form-check-input checkbox-option" type="checkbox" value="Answer Scheme" id="ansScheme" name="category[]">
                        </div>
                    </div>
                    <div class="row mb-2" id="erDiv">
                        <div class="col-11">
                            <label for="exampleInputEmail1" class="form-label">Endorsed Result</label>                       
                        </div>
                        <div class="col-1">
                            <input class="form-check-input checkbox-option" type="checkbox" value="Endorsed Result" id="er" name="category[]">
                        </div>
                    </div>
                    <div class="row mb-2" id="alDiv">
                        <div class="col-11">
                            <label for="exampleInputEmail1" class="form-label">Appointment Letter</label>                      
                        </div>
                        <div class="col-1">
                            <input class="form-check-input checkbox-option" type="checkbox" value="Appointment Letter" id="al" name="category[]">
                        </div>
                    </div>
                    <div class="row mb-2" id="syllabusDiv">
                        <div class="col-11">
                            <label for="exampleInputEmail1" class="form-label">Syllabus</label>                      
                        </div>
                        <div class="col-1" id="ealDiv">
                            <input class="form-check-input checkbox-option" type="checkbox" value="Syllabus" id="syllabus" name="category[]">
                        </div>
                    </div>
                    <div class="row mb-2" id="sowDiv">
                        <div class="col-11">
                            <label for="exampleInputEmail1" class="form-label">Scheme of Work</label>                    
                        </div>
                        <div class="col-1">
                            <input class="form-check-input checkbox-option" type="checkbox" value="Scheme of Work" id="sow" name="category[]">
                        </div>
                    </div>
                    <div class="row mb-2" id="attendanceDiv">
                        <div class="col-11">
                            <label for="exampleInputEmail1" class="form-label">Attendance</label>                    
                        </div>
                        <div class="col-1">
                            <input class="form-check-input checkbox-option" type="checkbox" value="Attendance" id="attendance" name="category[]">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-warning reset-btn">Reset</button>
                    <button type="submit" class="btn userlist-btn text-light" name='sendNotification' data-bs-dismiss="modal">Send</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    Are you sure want to permenently delete this Submission?
                    <input type="hidden" class="form-control" id="submission_id2" name="submission_id2" aria-describedby="emailHelp" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning reset-btn" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn userlist-btn text-light" name='deleteSubmission'>Yes</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="logoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Logout ?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are You Sure ?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-warning reset-btn" data-bs-dismiss="modal">No</button>
            <a href="../login.php?status=logout" >
                <button type="button" class="btn userlist-btn text-light">Yes</button>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="main-footer">
        <div class="footer-middle py-sm-2" style="background: #F2F2F2">
            <div class="container">  
                <div class="footer-bottom">
                    <p class="text-xs-center footer-title-text">
                        &copy; <script>document.write(new Date().getFullYear())</script> Document Tracker - ISO Document Submission Tracking System
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" class="init">
    $(document).ready( function (){

        var events = $('#events');
        var table = $('#example').DataTable( {
            select: true,
            "pagingType": "full",
            "columnDefs": [
                { "width": "17%", "targets": 10 }
            ]
        })
    });
    
    function submitDialog(submissionId, submiter_email, profile_id){
        
    // 	document.getElementById('submissionId').value = submissionId;
        document.getElementById('submiter_email').value = submiter_email;
        document.getElementById('profile_id1').value = profile_id;
        
        //  console.log(submiter_email);
    }
    
    function notificationDialog(email, name, eal, tst, eqs, ans_scheme, er, al, syllabus, sow, attendance){
        
    	document.getElementById('email').value=email;
        document.getElementById('name').value=name;
        
        var element1 = document.getElementById("ealDiv");
        var element2 = document.getElementById("tstDiv");
        var element3 = document.getElementById("eqsDiv");
        var element4 = document.getElementById("ans_schemeDiv");
        var element5 = document.getElementById("erDiv");
        var element6 = document.getElementById("alDiv");
        var element7 = document.getElementById("syllabusDiv");
        var element8 = document.getElementById("sowDiv");
        var element9 = document.getElementById("attendanceDiv");
        
        if(eal == "submited"){
            document.getElementById("eal").disabled = true;
            element1.style.display = "none";
        }else{
            document.getElementById("eal").disabled = false;
            element1.style.display = "flex";
        }
        
        if(tst == "submited"){
            document.getElementById("tst").disabled = true;
            element2.style.display = "none";
        }else{
            document.getElementById("tst").disabled = false;
            element2.style.display = "flex";
        }
        
        if(eqs == "submited"){
            document.getElementById("eqs").disabled = true;
            element3.style.display = "none";
        }else{
            document.getElementById("eqs").disabled = false;
            element3.style.display = "flex";
        }
        
        if(ans_scheme == "submited"){
            document.getElementById("ansScheme").disabled = true;
            element4.style.display = "none";
        }else{
            document.getElementById("ansScheme").disabled = false;
            element4.style.display = "flex";
        }
        
        if(er == "submited"){
            document.getElementById("er").disabled = true;
            element5.style.display = "none";
        }else{
            document.getElementById("er").disabled = false;
            element5.style.display = "flex";
        }
        
        if(al == "submited"){
            document.getElementById("al").disabled = true;
            element6.style.display = "none";
        }else{
            document.getElementById("al").disabled = false;
            element6.style.display = "flex";
        }
        
        if(syllabus == "submited"){
            document.getElementById("syllabus").disabled = true;
            element7.style.display = "none";
        }else{
            document.getElementById("syllabus").disabled = false;
            element7.style.display = "flex";
        }
        
        if(sow == "submited"){
            document.getElementById("sow").disabled = true;
            element8.style.display = "none";
        }else{
            document.getElementById("sow").disabled = false;
            element8.style.display = "flex";
        }
        
        if(attendance == "submited"){
            document.getElementById("attendance").disabled = true;
            element9.style.display = "none";
        }else{
            document.getElementById("attendance").disabled = false;
            element9.style.display = "flex";
        }
        
       
    }
    
    const checkBoxAll = document.querySelector('#checkBoxAll');
    const checkBoxOption = document.querySelectorAll('.checkbox-option');
    
    function selectAllCheckboxes(){
        
        const isChecked = checkBoxAll.checked;
        
        for(let i = 0 ; i < checkBoxOption.length ; i++){
            checkBoxOption[i].checked = isChecked;
        }
    }
    
    function deleteDialog(submission_id){
        
    	document.getElementById('submission_id2').value=submission_id;

    }
    </script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>