<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ngoc Hieu</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- include summernote css/js -->
    <link href="summernote/summernote.min.css" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        <?php
        include "header.php";
        // NAV TOP  
        include "sidebar.php";
        //NAV SIDE 
        include "includes/database.php";
        include "includes/users.php";

        $database = new database();
        $db = $database->connect();
        $new_user = new user($db);
        $new_user->n_user_id = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['Update_Profile'])) {

                $file_upload = $_FILES['ImageProfile'];
                $image_name = "";


                if (!empty($file_upload['name'])) {
                    //clean file upload 
                    $file = pathinfo($file_upload['name']);
                    $extension = $file['extension'];
                    $access_extension = array('jpg', 'png');
                    if (in_array($extension, $access_extension)) {
                        $target_file = "images/avatars/";
                        $image_name = $file_upload['name'];
                        move_uploaded_file($file_upload['tmp_name'], $target_file . $image_name);
                    } 
                }else {
                    $image_name = $_POST['old_image_profile'];
                }

                $new_user->n_user_id = $_SESSION['user_id'];
                $new_user->v_fullname = $_POST['Fullname'];
                $new_user->v_email = $_POST['Email'];
                $new_user->v_username = $_POST['Username'];
                if ($_POST['Password'] != $_POST['Old_password']) {
                    $new_user->v_password = md5($_POST['Password']);
                } else {
                    $new_user->v_password = $_POST['Old_password'];
                }
                $new_user->v_phone = $_POST['PhoneNumber'];
                $new_user->v_image = $image_name;
                $new_user->v_message = $_POST['AboutProfile'];
                $new_user->d_date_updated = date("Y-m-d", time());
                $new_user->d_time_updated = date("h:i:s", time());

                if ($new_user->update()) {
                    $flag = "Update success";
                }
            }
        }

        ?>
        <!-- DATABASE AND SQL -->
        <div id="page-wrapper">
            <div id="page-inner">


                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            User Profile
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->

                <?php
                if (isset($flag)) {
                ?>
                    <div class="alert alert-success">
                        <strong><?php echo $flag ?></strong>
                    </div>
                <?php
                }
                ?>
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Profile Page
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <?php
                                $result = $new_user->read_single();
                                $row = $result->fetch();
                                ?>
                                <div class="col-md-9">

                                    <form role="form" method="POST" enctype="multipart/form-data" action="edit_user_profile.php">
                                        <div class="form-group">
                                            <label>Fullname</label>
                                            <input name="Fullname" value="<?php echo $row['v_fullname'] ?>" class="form-control" placeholder="Enter fullname">
                                        </div>

                                        <div class="form-group">
                                            <label>Email</label>
                                            <input name="Email" value="<?php echo $row['v_email'] ?>" class="form-control" placeholder="Enter email">
                                        </div>

                                        <div class="form-group">
                                            <label>Username</label>
                                            <input name="Username" value="<?php echo $row['v_username'] ?>" class="form-control" placeholder="Enter username">
                                        </div>

                                        <div class="form-group">
                                            <label>Password</label>
                                            <input name="Password" value="<?php echo $row['v_password'] ?>" type="password" class="form-control" placeholder="Enter password">
                                            <input name="Old_password" value="<?php echo $row['v_password'] ?>" type="hidden" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input name="PhoneNumber" value="<?php echo $row['v_phone'] ?>" class="form-control" placeholder="Enter phone number">
                                        </div>

                                        <div class="form-group">
                                            <label>Image Profile</label>
                                            <input type="file" name="ImageProfile" id="ImageProfile">
                                            <input type="hidden" name="old_image_profile" value="<?php echo $row['v_image'] ?>">
                                        </div>

                                        <div class="form-group">
                                            <label>About Me</label>
                                            <textarea id="AboutProfile" name="AboutProfile" class="form-control" rows="3">
                                            <?php echo $row['v_message'] ?>
                                            </textarea>
                                        </div>

                                        <div class="form-group">
                                            <input type="hidden" name="Update_Profile" value="1">
                                            <input type="hidden" name="user_id" value="<?php $row['n_user_id'] ?>">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </form>
                                </div>
                                <div class="col-md-3">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            Image Profile
                                        </div>
                                        <div class="panel-body">
                                            <?php
                                            if (empty($row['v_image'])) {
                                                if (empty($_POST['old_image_profile'])) {
                                            ?>

                                                <img class="img-thumbnail" src="images/avatars/user-01.jpg" alt="img" width=180px>

                                                <?php
                                                }
                                            } else {
                                                ?>

                                                <img class="img-thumbnail" src="<?php echo "images/avatars/" . $row['v_image'] ?>" alt="img" width=180px>

                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row (nested) -->

                        </div>
                        <!-- /.panel-body -->
                    </div>


                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>

            <?php include "footer.php" ?>
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>

    <script src="summernote/summernote.min.js"></script>
    <script>
        $('#AboutProfile').summernote({
            placeholder: 'About Me',
            height: 100
        });
    </script>

</body>

</html>