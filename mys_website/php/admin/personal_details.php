<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User' Personal Details</title>
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
                    <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Manage
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item" href="manage_document.php">Document</a></li>
                      <li><a class="dropdown-item" href="manage_profile.php">Profile</a></li>
                      <li><a class="dropdown-item" href="manage_report.php">Report</a></li>
                      <li><a class="dropdown-item" href="manage_submission.php">Submission Status</a></li>
                      <li><a class="dropdown-item" href="manage_validation.php">Validation Status</a></li>
                    </ul>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link active" href="personal_details.php">User Personal Details</a>
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
                                ON c.email= a.email
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
                                                    $result1 = $con->query($sqlloaddocument);
                                                    if ($result1->num_rows > 0){
                                                        while ($row = $result1 -> fetch_assoc()){
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
                                                    $result1 = $con->query($sqlloaddocument);
                                                    if ($result1->num_rows > 0){
                                                        while ($row = $result1 -> fetch_assoc()){
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
                                                    $result1 = $con->query($sqlloaddocument);
                                                    if ($result1->num_rows > 0){
                                                        while ($row = $result1 -> fetch_assoc()){
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
                                                    $result1 = $con->query($sqlloaddocument);
                                                    if ($result1->num_rows > 0){
                                                        while ($row = $result1 -> fetch_assoc()){
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
                                                    $result1 = $con->query($sqlloaddocument);
                                                    if ($result1->num_rows > 0){
                                                        while ($row = $result1 -> fetch_assoc()){
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
                                                    $result1 = $con->query($sqlloaddocument);
                                                    if ($result1->num_rows > 0){
                                                        while ($row = $result1 -> fetch_assoc()){
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
                                                    $result1 = $con->query($sqlloaddocument);
                                                    if ($result1->num_rows > 0){
                                                        while ($row = $result1 -> fetch_assoc()){
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
                                                    $result1 = $con->query($sqlloaddocument);
                                                    if ($result1->num_rows > 0){
                                                        while ($row = $result1 -> fetch_assoc()){
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
                                                    $result1 = $con->query($sqlloaddocument);
                                                    if ($result1->num_rows > 0){
                                                        while ($row = $result1 -> fetch_assoc()){
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
    
    <!--Modal-->
    
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
    </script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>