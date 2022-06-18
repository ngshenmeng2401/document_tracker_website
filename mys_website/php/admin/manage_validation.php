<?php
session_start();
include("dbconnect.php");

if (isset($_POST['updateValidation'])){
    
    $validation_id = $_POST["validation_id1"];
    $eal = $_POST["eal"];
    $tst = $_POST["tst"];
    $eqs = $_POST["eqs"];
    $ans_scheme = $_POST["ans_scheme"];
    $er = $_POST["er"];
    $al = $_POST["al"];
    $syllabus = $_POST["syllabus"];
    $sow = $_POST["sow"];
    $attendance = $_POST["attendance"];
    $profile_id = $_POST["profile_id"];
    
    if(empty($eal)){
        $eal = "-";
    }
    if(empty($tst)){
        $tst = "-";
    }
    if(empty($eqs)){
        $eqs = "-";
    }
    if(empty($ans_scheme)){
        $ans_scheme = "-";
    }
    if(empty($er)){
        $er = "-";
    }
    if(empty($al)){
        $al = "-";
    }
    if(empty($syllabus)){
        $syllabus = "-";
    }
    if(empty($sow)){
        $sow = "-";
    }
    if(empty($attendance)){
        $attendance = "-";
    }
    
    $sql = "SELECT * FROM tbl_validation WHERE validation_id = '$validation_id'";
    $result = $con->query($sql);
    if ($result->num_rows > 0){
        
        $updateValidation = "UPDATE `tbl_validation` SET EAL = '$eal', TST = '$tst', EQS = '$eqs', ans_scheme = '$ans_scheme', ER = '$er', AL = '$al', syllabus = '$syllabus', SoW = '$sow', attendance = '$attendance' WHERE validation_id = '$validation_id'";
    
        if($con->query($updateValidation) === TRUE)
        {
            
            echo "<script type='text/javascript'>alert('Success!');window.location.assign('manage_validation.php');</script>'";
        }else{
            echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('manage_validation.php');</script>'";
        }
    }else{
        echo "<script type='text/javascript'>alert('No any record !!!');window.location.assign('manage_validation.php');</script>'";
    }
    
}else if (isset($_POST['deleteValidation'])){
    
    $validation_id = $_POST["validation_id2"];
    
    $sql = "SELECT * FROM tbl_validation WHERE validation_id = '$validation_id'";
    $result = $con->query($sql);
    if ($result->num_rows > 0){
        while ($row = $result -> fetch_assoc()){
            extract($row);
            
            if($EAL != "-" or $TST != "-" or $EQS != "-" or $ans_scheme != "-" or $ER != "-" or $AL != "-" or $syllabus != "-" or $SoW != "-"){
                
                echo "<script type='text/javascript'>alert('Delete Failed ! Already conduct validation !!!');window.location.assign('manage_validation.php');</script>'";
            }else{
                
                $deleteValidation = "DELETE FROM `tbl_validation` WHERE validation_id = '$validation_id' ";
    
                if($con->query($deleteValidation) === TRUE)
                {
                    echo "<script type='text/javascript'>alert('Success!');window.location.assign('manage_validation.php');</script>'";
                }else{
                    echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('manage_validation.php');</script>'";
                }
            }
        }
    }else{
        
        echo "<script type='text/javascript'>alert('No any record !!!');window.location.assign('manage_validation.php');</script>'";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Validation</title>
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
                      <li><a class="dropdown-item" href="manage_submission.php">Submission Status</a></li>
                      <li><a class="dropdown-item active" href="manage_validation.php">Validation Status</a></li>
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
                <!--<button class="btn userlist-btn float-end text-light" data-bs-toggle="modal" data-bs-target="#addSubmissionModal">Add Validation</button>-->
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
                    <h1 class="text-center mb-3">Validation List</h1>
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered py-3">
                            <thead>
                                <tr>
                                    <th rowspan="2">Bil.</th>
                                    <th colspan="4" class="text-center">Profile</th>
                                    <th colspan="9" class="text-center">Validation Status</th>
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
                                    <th>Attendance File</th>
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
                                $sqlloadvalidation = "SELECT a.validation_id, a.profile_id, a.email, a.EAL as vadilationEAL, a.TST as vadilationTST, a.EQS as vadilationEQS, a.ans_scheme as vadilationANS, a.ER as vadilationER, a.AL as vadilationAL, a.syllabus as vadilationSy, a.SoW as vadilationSOW, a.attendance as vadilationAttend, 
                                b.status, b.subject, b.semester, c.name,
                                d.EAL as submissionEAL, d.TST as submissionTST, d.EQS as submissionEQS, d.ans_scheme as submissionANS, d.ER as submissionER, d.AL as submissionAL, d.syllabus as submissionSy, d.SoW as submissionSOW, d.attendance as submissionAttend
                                FROM tbl_validation a  
                                JOIN tbl_profile b
                                ON b.email = a.email AND b.profile_id = a.profile_id
                                JOIN tbl_user c
                                ON c.email= b.email
                                JOIN tbl_submission d
                                ON d.email= a.email AND d.profile_id = a.profile_id
                                ORDER BY validation_id ASC";
                                
                                $result = $con->query($sqlloadvalidation);
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
                                            <td><?php echo $vadilationEAL ?></td>
                                            <td><?php echo $vadilationTST ?></td>
                                            <td><?php echo $vadilationEQS ?></td>
                                            <td><?php echo $vadilationANS ?></td>
                                            <td><?php echo $vadilationER ?></td>
                                            <td><?php echo $vadilationAL ?></td>
                                            <td><?php echo $vadilationSy ?></td>
                                            <td><?php echo $vadilationSOW ?></td>
                                            <td><?php echo $vadilationAttend ?></td>
                                            <td>
                                                <i class="bi bi-pencil me-3" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#updateValidationModal" onclick="updateDialog(
                                                '<?php echo $validation_id ?>','<?php echo $vadilationEAL ?>','<?php echo $vadilationTST ?>','<?php echo $vadilationEQS ?>','<?php echo $vadilationANS ?>','<?php echo $vadilationER ?>','<?php echo $vadilationAL ?>','<?php echo $vadilationSy ?>','<?php echo $vadilationSOW ?>','<?php echo $vadilationAttend ?>',
                                                '<?php echo $submissionEAL ?>','<?php echo $submissionTST ?>','<?php echo $submissionEQS ?>','<?php echo $submissionANS ?>','<?php echo $submissionER ?>','<?php echo $submissionAL ?>','<?php echo $submissionSy ?>','<?php echo $submissionSOW ?>','<?php echo $submissionAttend ?>','<?php echo $profile_id ?>')"></i>
                                                <i class="bi bi-trash" style="color: #693D70 ; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteDialog('<?php echo $validation_id ?>')"></i>
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
    <div class="modal fade" id="updateValidationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update Validation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                <input type="hidden" class="form-control" id="validation_id1" name="validation_id1" aria-describedby="emailHelp" required>
                <input type="hidden" class="form-control" id="profile_id" name="profile_id" aria-describedby="emailHelp" required>
                    <div class="row mb-2">
                        <div class="col-8">
                            <label for="exampleInputEmail1" class="form-label">Examination Announcement Letter</label>
                        </div>
                        <div class="col-4">
                            <select class="form-select" id="eal" aria-label="Default select example" name="eal">
                                <option value="-" >-</option>
                                <option value="yes" >Yes</option>
                                <option value="no" >No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-8">
                            <label for="exampleInputEmail1" class="form-label">Test Specification Table</label>
                        </div>
                        <div class="col-4">
                            <select class="form-select" id="tst" aria-label="Default select example" name="tst">
                                <option value="-" >-</option>
                                <option value="yes" >Yes</option>
                                <option value="no" >No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-8">
                            <label for="exampleInputEmail1" class="form-label">Examination Question Script</label>                        
                        </div>
                        <div class="col-4">
                            <select class="form-select" id="eqs" aria-label="Default select example" name="eqs">
                                <option value="-" >-</option>
                                <option value="yes" >Yes</option>
                                <option value="no" >No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-8">
                            <label for="exampleInputEmail1" class="form-label">Answer Scheme</label>                       
                        </div>
                        <div class="col-4">
                            <select class="form-select" id="ans_scheme" aria-label="Default select example" name="ans_scheme">
                                <option value="-" >-</option>
                                <option value="yes" >Yes</option>
                                <option value="no" >No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-8">
                            <label for="exampleInputEmail1" class="form-label">Endorsed Result</label>                       
                        </div>
                        <div class="col-4">
                            <select class="form-select" id="er" aria-label="Default select example" name="er">
                                <option value="-" >-</option>
                                <option value="yes" >Yes</option>
                                <option value="no" >No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-8">
                            <label for="exampleInputEmail1" class="form-label">Appointment Letter</label>                      
                        </div>
                        <div class="col-4">
                            <select class="form-select" id="al" aria-label="Default select example" name="al">
                                <option value="-" >-</option>
                                <option value="yes" >Yes</option>
                                <option value="no" >No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-8">
                            <label for="exampleInputEmail1" class="form-label">Syllabus</label>                      
                        </div>
                        <div class="col-4">
                            <select class="form-select" id="syllabus" aria-label="Default select example" name="syllabus">
                                <option value="-" >-</option>
                                <option value="yes" >Yes</option>
                                <option value="no" >No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-8">
                            <label for="exampleInputEmail1" class="form-label">Scheme of Work</label>                    
                        </div>
                        <div class="col-4">
                            <select class="form-select" id="sow" aria-label="Default select example" name="sow">
                                <option value="-" >-</option>
                                <option value="yes" >Yes</option>
                                <option value="no" >No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-8">
                            <label for="exampleInputEmail1" class="form-label">Attendance</label>                    
                        </div>
                        <div class="col-4">
                            <select class="form-select" id="attendance" aria-label="Default select example" name="attendance">
                                <option value="-" >-</option>
                                <option value="yes" >Yes</option>
                                <option value="no" >No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn userlist-btn text-light" data-bs-dismiss="modal" name="updateValidation">Update</button>
                    <button type="reset" class="btn btn-outline-warning reset-btn">Reset</button>
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
                    Are you sure want to permenently delete this Validation?
                    <input type="hidden" class="form-control" id="validation_id2" name="validation_id2" aria-describedby="emailHelp" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning reset-btn" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn userlist-btn text-light" name='deleteValidation'>Yes</button>
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
    
    function updateDialog(validation_id, eal1, tst1, eqs1, ans_scheme1, er1, al1, syllabus1, sow1, attendance1, eal2, tst2, eqs2, ans_scheme2, er2, al2, syllabus2, sow2, attendance2, profile_id){
        
    	document.getElementById('validation_id1').value=validation_id;
    	
    	document.getElementById('eal').value=eal1;
    	document.getElementById('tst').value=tst1;
    	document.getElementById('eqs').value=eqs1;
    	document.getElementById('ans_scheme').value=ans_scheme1;
    	document.getElementById('er').value=er1;
    	document.getElementById('al').value=al1;
    	document.getElementById('syllabus').value=syllabus1;
        document.getElementById('sow').value=sow1;
        document.getElementById('attendance').value=attendance1;
        document.getElementById('profile_id').value=profile_id;
        
        if(eal2 == "submited"){
            document.getElementById('eal').disabled = false;
        }else{
            document.getElementById('eal').disabled = true;
        }
        
        if(tst2 == "submited"){
            document.getElementById('tst').disabled = false;
        }else{
            document.getElementById('tst').disabled = true;
        }
        
        if(eqs2 == "submited"){
            document.getElementById('eqs').disabled = false;
        }else{
            document.getElementById('eqs').disabled = true;
        }
        
        if(ans_scheme2 == "submited"){
            document.getElementById('ans_scheme').disabled = false;
        }else{
            document.getElementById('ans_scheme').disabled = true;
        }
        
        if(er2 == "submited"){
            document.getElementById('er').disabled = false;
        }else{
            document.getElementById('er').disabled = true;
        }
        
        if(al2 == "submited"){
            document.getElementById('al').disabled = false;
        }else{
            document.getElementById('al').disabled = true;
        }
        
        if(syllabus2 == "submited"){
            document.getElementById('syllabus').disabled = false;
        }else{
            document.getElementById('syllabus').disabled = true;
        }
        
        if(sow2 == "submited"){
            document.getElementById('sow').disabled = false;
        }else{
            document.getElementById('sow').disabled = true;
        }
        
        if(attendance2 == "submited"){
            document.getElementById('attendance').disabled = false;
        }else{
            document.getElementById('attendance').disabled = true;
        }
    }
    
    function deleteDialog(validation_id){
        
    	document.getElementById('validation_id2').value=validation_id;

    }
    </script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>