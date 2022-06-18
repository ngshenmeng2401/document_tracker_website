<?php

session_start();
include("dbconnect.php");
$email = $_SESSION["email"];

if (isset($_POST['updateFile'])){
    
    $file = $_FILES["file"];
    $fileName = $_FILES["file"]["name"];
    $fileType = $_FILES["file"]["type"];
    $fileSize = $_FILES["file"]["size"];
    $remarks = $_POST["remarks"];
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $doc_id = $_POST["doc_id"];
    
    $sql = "SELECT * FROM tbl_document WHERE doc_id = '$doc_id'";
    $result = $con->query($sql);
    if ($result->num_rows > 0){
        
        if ($_FILES["file"]["size"] > 1000000) {
        
            echo "<script type='text/javascript'>alert('Cant upload more than 1mb file !!!');window.location.assign('manage_document.php');</script>'";
            
        }else{
            
            $updateDoc = "UPDATE `tbl_document` SET doc_name = '$fileName', type = '$ext' WHERE doc_id = '$doc_id'";
        
            if($con->query($updateDoc) === TRUE)
            {
                
                move_uploaded_file($file["tmp_name"], "../../assets/files/manage_document/".$doc_id.".".$ext);
                echo "<script type='text/javascript'>alert('Success!');window.location.assign('manage_document.php');</script>'";
            }else{
                echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('manage_document.php');</script>'";
            }
            
        }
    }else{
        echo "<script type='text/javascript'>alert('No any record !!!');window.location.assign('manage_document.php');</script>'";
    }
    
}else if (isset($_POST['deleteFile'])){
    
    $email = $_POST["email"];
    $doc_id = $_POST["doc_id"];
    $profile_id = $_POST["profile_id"];
    $type = $_POST["type"];
    $category = $_POST["category"];
    $dash = "-";
    
    switch ($category) {
        case 1:
        $sqlinsert = "UPDATE tbl_submission SET EAL = '$dash' WHERE email = '$email' AND profile_id = '$profile_id'";
        break;
        case 2:
        $sqlinsert = "UPDATE tbl_submission SET TST = '$dash' WHERE email = '$email' AND profile_id = '$profile_id'";
        break;
        case 3:
        $sqlinsert = "UPDATE tbl_submission SET EQS = '$dash' WHERE email = '$email' AND profile_id = '$profile_id'";
        break;
        case 4:
        $sqlinsert = "UPDATE tbl_submission SET ans_scheme = '$dash' WHERE email = '$email' AND profile_id = '$profile_id'";
        break;
        case 5:
        $sqlinsert = "UPDATE tbl_submission SET ER = '$dash' WHERE email = '$email' AND profile_id = '$profile_id'";
        break;
        case 6:
        $sqlinsert = "UPDATE tbl_submission SET AL = '$dash' WHERE email = '$email' AND profile_id = '$profile_id'";
        break;
        case 7:
        $sqlinsert = "UPDATE tbl_submission SET syllabus = '$dash' WHERE email = '$email' AND profile_id = '$profile_id'";
        break;
        case 8:
        $sqlinsert = "UPDATE tbl_submission SET SoW = '$dash' WHERE email = '$email' AND profile_id = '$profile_id'";
        break;
        case 9:
        $sqlinsert = "UPDATE tbl_submission SET attendance = '$dash' WHERE email = '$email' AND profile_id = '$profile_id'";
        break;
    }
    
    $deleteDoc = "DELETE FROM `tbl_document` WHERE doc_id = '$doc_id' ";
    
    if($con->query($deleteDoc) === TRUE and $con->query($sqlinsert) === TRUE)
    {
        unlink("../../assets/files/manage_document/".$doc_id.".".$type);
        echo "<script type='text/javascript'>alert('Success!');window.location.assign('manage_document.php');</script>'";
    }else{
        echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('manage_document.php');</script>'";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Document</title>
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
                      <li><a class="dropdown-item active" href="manage_document.php">Document</a></li>
                      <li><a class="dropdown-item" href="manage_profile.php">Profile</a></li>
                      <li><a class="dropdown-item" href="manage_report.php">Report</a></li>
                      <li><a class="dropdown-item" href="manage_submission.php">Submission Status</a></li>
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
        <div class="row my-4 px-3 px-sm-0">
            <div class="card shadow mb-4">
                <div class="card-body ">
                    <h1 class="text-center mb-3">Document List</h1>
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered py-3">
                            <thead>
                                <tr>
                                    <th>Bil.</th>
                                    <th>Email</th>
                                    <th>Document Name</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Download</th>
                                    <th>Validation Status</th>
                                    <th>Subject</th>
                                    <th>Semester</th>
                                    <th>Action</th>
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
                                $sqlloaddocument = "SELECT a.doc_id,a.email,a.doc_name,a.profile_id, a.type, a.category, b.EAL, b.TST, b.EQS, b.ans_scheme, b.ER, b.AL, b.syllabus, b.SoW, b.attendance, c.subject, c.semester
                                FROM tbl_document a
                                JOIN tbl_validation b
                                ON b.email = a.email AND b.profile_id = a.profile_id
                                JOIN tbl_profile c
                                ON c.email = a.email AND c.profile_id = a.profile_id";
                                $result = $con->query($sqlloaddocument);
                                if ($result->num_rows > 0){
                                    while ($row = $result -> fetch_assoc()){
                                        extract($row);
                                        
                                        ?>
                                        <tr>
                                            <td><?php echo $index++ ?></td>
                                            <td><?php echo $email ?></td>
                                            <td><?php echo $doc_name ?></td>
                                            <td><?php echo $type ?></td>
                                            <?php
                                                switch ($category) {
                                                    case 1:
                                                    ?> <td>Exam Announcement Letter</td> <?php
                                                    break;
                                                    case 2:
                                                    ?> <td>Test Specification Table</td> <?php
                                                    break;
                                                    case 3:
                                                    ?> <td>Examination Question Script</td> <?php
                                                    break;
                                                    case 4:
                                                    ?> <td>Answer Scheme</td> <?php
                                                    break;
                                                    case 5:
                                                    ?> <td>Endorsed Result</td> <?php
                                                    break;
                                                    case 6:
                                                    ?> <td>Appointment Letter</td> <?php
                                                    break;
                                                    case 7:
                                                    ?> <td>Syllabus</td> <?php
                                                    break;
                                                    case 8:
                                                    ?> <td>Scheme of Work</td> <?php
                                                    case 9:
                                                    ?> <td>Attendance</td> <?php
                                                    break;
                                                }
                                                if($type == "docx"){
                                                    ?>
                                                    <td><a href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>"  download="<?php echo $doc_name ?>"><img src="../../assets/images/words.png" style="width: 24px; height: 24px" alt="docx"></a></td>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <td><a href="../../assets/files/manage_document/<?php echo $doc_id.".".$type ?>" download="<?php echo $doc_name ?>"><img src="../../assets/images/pdf.jpg" style="width: 24px; height: 24px" alt="pdf"></a></td>
                                                    <?php
                                                }
                                                switch ($category) {
                                                    case 1:
                                                    ?> <td><?php echo $EAL ?></td> <?php
                                                    break;
                                                    case 2:
                                                    ?> <td><?php echo $TST ?></td> <?php
                                                    break;
                                                    case 3:
                                                    ?> <td><?php echo $EQS ?></td> <?php
                                                    break;
                                                    case 4:
                                                    ?> <td><?php echo $ans_scheme ?></td> <?php
                                                    break;
                                                    case 5:
                                                    ?> <td><?php echo $ER ?></td> <?php
                                                    break;
                                                    case 6:
                                                    ?> <td><?php echo $AL ?></td> <?php
                                                    break;
                                                    case 7:
                                                    ?> <td><?php echo $syllabus ?></td> <?php
                                                    break;
                                                    case 8:
                                                    ?> <td><?php echo $SoW ?></td> <?php
                                                    case 9:
                                                    ?> <td><?php echo $attendance ?></td> <?php
                                                    break;
                                                }
                                                ?>
                                                <td><?php echo $subject ?></td>
                                                <td><?php echo $semester ?></td>
                                                <?php
                                                switch ($category) {
                                                    case 1:
                                                        if($EAL == "yes"){
                                                            ?>
                                                            <td></td>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <td>
                                                                <!--<i class="bi bi-pencil me-3" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" onclick="updateDialog('<?php echo $doc_id ?>')"></i>-->
                                                                <i class="bi bi-trash" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteDialog('<?php echo $doc_id ?>','<?php echo $type ?>','<?php echo $category ?>','<?php echo $profile_id ?>','<?php echo $email ?>')"></i>
                                                            </td>
                                                            <?php
                                                        }
                                                    break;
                                                    case 2:
                                                        if($TST == "yes"){
                                                            ?>
                                                            <td></td>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <td>
                                                                <!--<i class="bi bi-pencil me-3" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" onclick="updateDialog('<?php echo $doc_id ?>')"></i>-->
                                                                <i class="bi bi-trash" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteDialog('<?php echo $doc_id ?>','<?php echo $type ?>','<?php echo $category ?>','<?php echo $profile_id ?>','<?php echo $email ?>')"></i>
                                                            </td>
                                                            <?php
                                                        }
                                                    break;
                                                    case 3:
                                                        if($EQS == "yes"){
                                                            ?>
                                                            <td></td>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <td>
                                                                <!--<i class="bi bi-pencil me-3" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" onclick="updateDialog('<?php echo $doc_id ?>')"></i>-->
                                                                <i class="bi bi-trash" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteDialog('<?php echo $doc_id ?>','<?php echo $type ?>','<?php echo $category ?>','<?php echo $profile_id ?>','<?php echo $email ?>')"></i>
                                                            </td>
                                                            <?php
                                                        }
                                                    break;
                                                    case 4:
                                                        if($ans_scheme == "yes"){
                                                            ?>
                                                            <td></td>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <td>
                                                                <!--<i class="bi bi-pencil me-3" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" onclick="updateDialog('<?php echo $doc_id ?>')"></i>-->
                                                                <i class="bi bi-trash" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteDialog('<?php echo $doc_id ?>','<?php echo $type ?>','<?php echo $category ?>','<?php echo $profile_id ?>','<?php echo $email ?>')"></i>
                                                            </td>
                                                            <?php
                                                        }
                                                    break;
                                                    case 5:
                                                        if($ER == "yes"){
                                                            ?>
                                                            <td></td>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <td>
                                                                <!--<i class="bi bi-pencil me-3" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" onclick="updateDialog('<?php echo $doc_id ?>')"></i>-->
                                                                <i class="bi bi-trash" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteDialog('<?php echo $doc_id ?>','<?php echo $type ?>','<?php echo $category ?>','<?php echo $profile_id ?>','<?php echo $email ?>')"></i>
                                                            </td>
                                                            <?php
                                                        }
                                                    break;
                                                    case 6:
                                                        if($AL == "yes"){
                                                            ?>
                                                            <td></td>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <td>
                                                                <!--<i class="bi bi-pencil me-3" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" onclick="updateDialog('<?php echo $doc_id ?>')"></i>-->
                                                                <i class="bi bi-trash" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteDialog('<?php echo $doc_id ?>','<?php echo $type ?>','<?php echo $category ?>','<?php echo $profile_id ?>','<?php echo $email ?>')"></i>
                                                            </td>
                                                            <?php
                                                        }
                                                    break;
                                                    case 7:
                                                        if($syllabus == "yes"){
                                                            ?>
                                                            <td></td>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <td>
                                                                <!--<i class="bi bi-pencil me-3" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" onclick="updateDialog('<?php echo $doc_id ?>')"></i>-->
                                                                <i class="bi bi-trash" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteDialog('<?php echo $doc_id ?>','<?php echo $type ?>','<?php echo $category ?>','<?php echo $profile_id ?>','<?php echo $email ?>')"></i>
                                                            </td>
                                                            <?php
                                                        }
                                                    break;
                                                    case 8:
                                                        if($SoW == "yes"){
                                                            ?>
                                                            <td></td>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <td>
                                                                <!--<i class="bi bi-pencil me-3" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" onclick="updateDialog('<?php echo $doc_id ?>')"></i>-->
                                                                <i class="bi bi-trash" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteDialog('<?php echo $doc_id ?>','<?php echo $type ?>','<?php echo $category ?>','<?php echo $profile_id ?>','<?php echo $email ?>')"></i>
                                                            </td>
                                                            <?php
                                                        }
                                                    break;
                                                    case 9:
                                                        if($attendance == "yes"){
                                                            ?>
                                                            <td></td>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <td>
                                                                <!--<i class="bi bi-pencil me-3" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" onclick="updateDialog('<?php echo $doc_id ?>')"></i>-->
                                                                <i class="bi bi-trash" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteDialog('<?php echo $doc_id ?>','<?php echo $type ?>','<?php echo $category ?>','<?php echo $profile_id ?>','<?php echo $email ?>')"></i>
                                                            </td>
                                                            <?php
                                                        }
                                                    break;
                                                }
                                                ?>
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
    <div class="modal fade" id="updateDocumentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="submitForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <p class="h6">Examination Announcement Letter</p> 
                    <input type="hidden" class="form-control" id="doc_id1" name="doc_id" aria-describedby="emailHelp" required>
                    <div class="mb-3">
                        <input type="file" class="form-control" id="file" name="file" aria-describedby="emailHelp" accept="file_extension/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn userlist-btn text-light" data-bs-dismiss="modal" name='updateFile' value="Submit">Update</button>
                    <button type="reset" class="btn btn-outline-warning reset-btn" data-bs-dismiss="modal" aria-label="Close">Reset</button>
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
                    Are you sure want to permenently delete this Document?
                    <input type="hidden" class="form-control" id="doc_id2" name="doc_id" aria-describedby="emailHelp" required>
                    <input type="hidden" class="form-control" id="type" name="type" aria-describedby="emailHelp" required>
                    <input type="hidden" class="form-control" id="category" name="category" aria-describedby="emailHelp" required>
                    <input type="hidden" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                    <input type="hidden" class="form-control" id="profile_id" name="profile_id" aria-describedby="emailHelp" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning reset-btn" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn userlist-btn text-light" name='deleteFile'>Yes</button>
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
        })
    });
    
    function updateDialog(doc_id){
    	
    	document.getElementById('doc_id1').value=doc_id;
    	
    }
    
    function deleteDialog(doc_id, type, category, profile_id, email){
        
    	document.getElementById('doc_id2').value=doc_id;
    	document.getElementById('type').value=type;
    	document.getElementById('profile_id').value=profile_id;
    	document.getElementById('category').value=category;
    	document.getElementById('email').value=email;
    }
    </script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>