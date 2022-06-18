<?php 

session_start();
include("dbconnect.php");
$email = $_SESSION["email"];

if (isset($_POST['changeProfile'])){
    
    $username = $_POST["username"];
    $phoneNo = $_POST["phoneNo"];
    
    $loadProfile = "SELECT * FROM tbl_user WHERE email = '$email'";
    $result = $con->query($loadProfile);
    if ($result->num_rows > 0){
        while ($row = $result -> fetch_assoc()){
            extract($row);
            
            if($img_status == "yes" and $phoneNo != $phone_no){
                
                rename("../../assets/images/profile_img/".$phone_no.".".$img_format,"../../assets/images/profile_img/".$phoneNo.".".$img_format);
            }
        }
            
        $updateProfile = "UPDATE `tbl_user` SET name = '$username', phone_no = '$phoneNo' WHERE email = '$email'";
    
        if($con->query($updateProfile) === TRUE)
        {
            
            echo "<script type='text/javascript'>alert('Success!');window.location.assign('user_profile.php');</script>'";
        }else{
            echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('user_profile.php');</script>'";
        }
        
    }else{
        echo "<script type='text/javascript'>alert('No any record !!!');window.location.assign('user_profile.php');</script>'";
    }
    
}else if (isset($_POST['changePassword'])){
    
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $passsha1=sha1($password);
    
    $loadProfile = "SELECT * FROM tbl_user WHERE email = '$email'";
    $result = $con->query($loadProfile);
    if ($result->num_rows > 0){
        
        if($password != $confirmPassword or $confirmPassword != $password){
            
            echo "<script type='text/javascript'>alert('Both password are different !');window.location.assign('user_profile.php');</script>'";
        }else{
         
            $updatePassword = "UPDATE `tbl_user` SET password = '$passsha1' WHERE email = '$email'";
    
            if($con->query($updatePassword) === TRUE)
            {
                
                echo "<script type='text/javascript'>alert('Success!');window.location.assign('user_profile.php');</script>'";
            }else{
                echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('user_profile.php');</script>'";
            }   
        }
        
    }else{
        echo "<script type='text/javascript'>alert('No any record !!!');window.location.assign('user_profile.php');</script>'";
    }
    
}else if (isset($_POST['changeProfilePic'])){
    
    $file = $_FILES["file"];
    $fileName = $_FILES["file"]["name"];
    $fileType = $_FILES["file"]["type"];
    $fileSize = $_FILES["file"]["size"];
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $phoneNo = $_POST["phoneNo"];
    $haveProfileImg = "yes";
    
    if ($_FILES["file"]["size"] > 3000000) {
        
        echo "<script type='text/javascript'>alert('Cant upload more than 3mb file !!!');window.location.assign('user_profile.php');</script>'";
    }else{
        
        $loadProfile = "SELECT * FROM tbl_user WHERE email = '$email'";
        $result = $con->query($loadProfile);
        if ($result->num_rows > 0){
            
            move_uploaded_file($file["tmp_name"], "../../assets/images/profile_img/".$phoneNo.".".$ext);    
            $updateProfilePic = "UPDATE `tbl_user` SET img_status = '$haveProfileImg', img_format = '$ext' WHERE email = '$email'";
            
            if($con->query($updateProfilePic) === TRUE)
            {
                
                echo "<script type='text/javascript'>alert('Success!');window.location.assign('user_profile.php');</script>'";
            }else{
                echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('user_profile.php');</script>'";
            }
            
        }else{
            echo "<script type='text/javascript'>alert('No any record !!!');window.location.assign('user_profile.php');</script>'";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
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
    <link rel="stylesheet" href="../../css/signup.css">
</head>
<body style="background-color: #F2EBF3;">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light " style="background-color: #693D70">
        <div class="container-fluid">
            <!-- <img src="" alt="logo" class="logoimg" > -->
            <a class="navbar-brand text-light" href="home.php">DOCUMENT TRACKER</a>
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
                    <a class="nav-link text-light" href="manage_document.php">Manage Document</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="manage_profile.php">Manage Profile</a>
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
                                    <img src="../../assets/images/profile.png" href="user_profile.php" class="profileimg rounded-circle" alt="profileimg" style="cursor:pointer">
                                </li>
                                <?php
                            }else{
                                ?>
                                <li class="nav-item">
                                    <img src="../../assets/images/profile_img/<?php echo $phone_no; ?>.<?php echo $img_format; ?>" href="user_profile.php" class="profileimg rounded-circle" alt="profileimg" style="cursor:pointer">
                                </li>
                                <?php
                            }
                            ?>
                            <li class="nav-item mt-1">
                                <a class="nav-link active" href="user_profile.php"><?php echo $name; ?></a>
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

    <div class="container rounded shadow border-style my-4 py-3" style="background-color: #fff">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <div class="row">
                    <h2>My Profile</h2>
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
                                ?>
                                
                                <div class="col-md-6 col-12">
                                    <div class="row mb-2 mb-md-0">
                                        <div class="mb-2">
                                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                                <input type="email" value="<?php echo $email ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" readonly>
                                        </div>
                                        <div class="mb-2">
                                                <label for="exampleInputPassword1" class="form-label">Position</label>
                                                <input type="text" value="<?php echo $position ?>" class="form-control" id="exampleInputPassword1" readonly>
                                        </div>
                                        <form method="POST" id="submitForm" enctype="multipart/form-data">
                                            <div class="mb-2">
                                                <label for="exampleInputPassword1" class="form-label">Username</label>
                                                <input type="text" value="<?php echo $name ?>" name="username" class="form-control" id="exampleInputPassword1" required>
                                            </div>
                                            <div class="mb-2">
                                                <label for="exampleInputPassword1" class="form-label">Phone No</label>
                                                <input type="number" value="<?php echo $phone_no ?>" name="phoneNo" class="form-control" id="exampleInputPassword1" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-4 col-sm-6 col-0"></div>
                                                <div class="col-lg-3 col-md-4 col-sm-3 col-6">
                                                    <button type="submit" class="btn userlist-btn text-light" data-bs-dismiss="modal" name='changeProfile'>Submit</button>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-3 col-6">
                                                    <button type="reset" class="btn reset-btn float-end" data-bs-dismiss="modal" aria-label="Close">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row mb-sm-3 mb-md-0">
                                        <form method="POST" id="submitForm" enctype="multipart/form-data" onsubmit ="return verifyPassword()">
                                            <div class="mb-2">
                                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                                <input type="password" value="" id="password" name="password" class="form-control" id="exampleInputPassword1" required>
                                            </div>
                                            <div class="mb-2">
                                                <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                                                <input type="password" value="" id="confirmPassword" name="confirmPassword" class="form-control" id="exampleInputPassword1" required>
                                            </div>
                                            <!--<div>-->
                                            <!--    <p id="length" class="invalid">Password & Confirm Password are different</p>-->
                                            <!--</div>-->
                                            <div class="row">
                                                <div class="col-lg-6 col-md-4 col-sm-6 col-0"></div>
                                                <div class="col-lg-3 col-md-4 col-sm-3 col-6">
                                                    <button type="submit" id="submit" class="btn userlist-btn text-light" data-bs-dismiss="modal" name='changePassword'>Submit</button>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-3 col-6">
                                                    <button type="reset" class="btn reset-btn float-end" data-bs-dismiss="modal" aria-label="Close">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- <div class="col-md-1 col-1"></div> -->
                                <div class="col-md-1 col-0"></div>
                                <div class="col-md-5 col-12">
                                    <div class="row">
                                        <label for="exampleInputPassword1" class="form-label m-0">Profile Image</label>
                                        <?php
                                        if($img_status =="no"){
                                            ?>
                                                <img src="../../assets/images/profile.png" alt="" class="img-fluid">
                                            <?php
                                        }else{
                                            ?>
                                                <img src="../../assets/images/profile_img/<?php echo $phone_no; ?>.<?php echo $img_format; ?>" alt="" class="img-fluid rounded-circle">
                                            <?php
                                        }
                                        ?>
                                        
                                    </div>
                                    <form method="POST" id="submitForm" enctype="multipart/form-data">
                                        <div class="row my-1 p-0">
                                            <input type="hidden" value="<?php echo $phone_no ?>" name="phoneNo" class="form-control" id="exampleInputPassword1" required>
                                            <input type="file" class="form-control" id="file" name="file" aria-describedby="emailHelp" accept="image/*" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-9"></div>
                                            <div class="col-3 px-0">
                                                <button type="submit" class="btn userlist-btn text-light float-end" data-bs-dismiss="modal" name='changeProfilePic'>Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-1"></div>
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
    
    <script>

        function verifyPassword(){
            
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var length = document.getElementById("length");
            var submitbtn = document.getElementById("submit");
            
            if(password != confirmPassword) {
                length.classList.remove("invalid");
                length.classList.add("valid");
                submitbtn.disabled = false;

            } else {
                length.classList.remove("valid");
                length.classList.add("invalid");
                submitbtn.disabled = true;
            }
        }
    </script>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>