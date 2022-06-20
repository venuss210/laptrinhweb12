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
</head>

<body>
    <div id="wrapper">
        <?php
        include "header.php";
        ?>
        <!--/. NAV TOP  -->
        <?php
        include "sidebar.php";
        ?>
        <!-- /. NAV SIDE  -->
        <?php
        include "includes/database.php";
        include "includes/blogs.php";
        include "includes/tags.php";

        $database = new database();
        $db = $database->connect();

        $new_blogs = new blogs($db);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['DeleteBlog'])) {
                $new_tags = new tags($db);
                $new_tags->n_blog_post_id = $_POST['blog_id'];
                $new_tags->delete();

                if ($_POST['Main_img'] != "") {
                    unlink("images/upload/" . $_POST['Main_img']);
                }
                if ($_POST['Alt_img'] != "") {
                    unlink("images/upload/" . $_POST['Alt_img']);
                }

                $new_blogs->n_blog_post_id = $_POST['blog_id'];

                if ($new_blogs->delete()) {
                    $flag = "Delete blog successful !";
                };
            } 
            
            if (isset($_POST['Update_Blog'])) {

                $target_file = "images/upload/";
                $access_extension = array('jpg', 'png');
                $main_image = "" ;
                $alt_image = "" ; 

                $file_upload_main_img = $_FILES['main_image'];
                if (!empty($file_upload_main_img['name'])){
                    //-------------Clean main_image data           
                    $file_main_img = pathinfo($file_upload_main_img['name']);
                    $extension_main_img = $file_main_img['extension'];
                    if (in_array($extension_main_img, $access_extension)){
                        $main_image = $file_upload_main_img['name'];
                        move_uploaded_file($file_upload_main_img['tmp_name'], $target_file . $main_image);
                    
                    } else {
                        $main_image = $_POST['old_main_image'];
                    }
                }
    
                $file_upload_alt_img = $_FILES['alt_image'];
                if (!empty($file_upload_alt_img['name'])){
                    //-------------Clean alt_image data       
                    $file_alt_img = pathinfo($file_upload_alt_img['name']);
                    $extension_alt_img = $file_alt_img['extension'];
                    if (in_array($extension_alt_img, $access_extension)){
                        $alt_image = $file_upload_alt_img['name'];
                        move_uploaded_file($file_upload_alt_img['tmp_name'], $target_file . $alt_image);
                    
                    } else {
                        $alt_image = $_POST['old_alt_image'];
                    }
                }    

                $new_blogs->n_blog_post_id = $_POST['blog_id'];
                $new_blogs->n_category_id = $_POST['select_category'];
                $new_blogs->v_post_title = $_POST['title'];
                $new_blogs->v_post_meta_title = $_POST['meta_title'];
                $new_blogs->v_post_path = $_POST['blog_path'];
                $new_blogs->v_post_summary = $_POST['blog_summary'];
                $new_blogs->v_post_content = $_POST['blog_content'];
                $new_blogs->v_main_image_url = $main_image;
                $new_blogs->v_alt_image_url = $alt_image;
                $new_blogs->n_blog_post_views = $_POST['post_view'];
                $new_blogs->n_home_page_place = $_POST['opt_place'];
                $new_blogs->f_post_status = $_POST['status'];
                $new_blogs->d_date_created = date("Y-m-d",intval($_POST['date_created']));
                $new_blogs->d_time_created = date("h:i:s",intval($_POST['time_created']));
                // $new_blog->d_date_updated = date("Y-m-d",time());
                // $new_blog->d_time_updated = date("h:i:s",time());

                if ($new_blogs->update()) {
                    $flag = "Update successful !";
                }


            }

            if (isset($_POST['Write_Blog'])) {

                $target_file = "images/upload/";
                $access_extension = array('jpg', 'png');
                $main_image = "" ;
                $alt_image = "" ; 

                $file_upload_main_img = $_FILES['main_image'];
                if (!empty($file_upload_main_img['name'])){
                    //-------------Clean main_image data           
                    $file_main_img = pathinfo($file_upload_main_img['name']);
                    $extension_main_img = $file_main_img['extension'];
                    if (in_array($extension_main_img, $access_extension)){
                        $main_image = $file_upload_main_img['name'];
                        move_uploaded_file($file_upload_main_img['tmp_name'], $target_file . $main_image);
                    
                    } 


                }
                   else {
                        $main_image = "";
                    }
                
                $file_upload_alt_img = $_FILES['alt_image'];
                if (!empty($file_upload_alt_img['name'])){
                    //-------------Clean alt_image data       
                    $file_alt_img = pathinfo($file_upload_alt_img['name']);
                    $extension_alt_img = $file_alt_img['extension'];
                    if (in_array($extension_alt_img, $access_extension)){
                        $alt_image = $file_upload_alt_img['name'];
                        move_uploaded_file($file_upload_alt_img['tmp_name'], $target_file . $alt_image);
                    
                    } 
                }    
                else {
                        $alt_image = "";
                    }
                    
                $opt = empty($_POST['opt_place']) ? 0 : $_POST['opt_place'];

                $new_blogs->n_category_id = $_POST['select_category'];
                $new_blogs->v_post_title = $_POST['title'];
                $new_blogs->v_post_meta_title = $_POST['meta_title'];
                $new_blogs->v_post_path = $_POST['blog_path'];
                $new_blogs->v_post_summary = $_POST['blog_summary'];
                $new_blogs->v_post_content = $_POST['blog_content'];
                $new_blogs->v_main_image_url = $main_image;
                $new_blogs->v_alt_image_url = $alt_image;
                $new_blogs->n_blog_post_views = 0;
                $new_blogs->n_home_page_place = $opt;
                $new_blogs->f_post_status = 1;
                $new_blogs->d_date_created = date("Y-m-d",time());
                $new_blogs->d_time_created = date("h:i:s",time());



                if ($new_blogs->create()) {
                    $flag = "Write a Blog successful !";

                    $new_tags = new tags($db);

                    $result = $new_blogs->last_id();
                    $rows = $result->fetch();
                    $new_tags->n_blog_post_id = $rows[0];
                    $new_tags->v_tag = $_POST['blog_tags'];
                    $new_tags->create();
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
                            Blogs
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
                <div class="col-lg-12">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Blogs Post
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>View</th>
                                            <th>Path</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $result = $new_blogs->read();
                                        $num = $result->rowCount();
                                        if ($num > 0) {
                                            while ($row = $result->fetch()) {

                                        ?>
                                                <tr>
                                                    <td><?php echo $row['n_blog_post_id']; ?></td>
                                                    <td><?php echo $row['v_post_title']; ?></td>
                                                    <td><?php echo $row['n_blog_post_views']; ?></td>
                                                    <td><?php echo $row['v_post_path']; ?></td>
                                                    <td>
                                                        <button class="popup-button btn btn-success">Views</button>
                                                        <button class="btn btn-warning" onclick="location.href='edit_blog.php?id=<?php
                                                        echo $row['n_blog_post_id'] ?>'">
                                                            Edit
                                                        </button>
                                                        <button class="btn btn-danger" data-toggle="modal" data-target="#delete_blog<?php
                                                        echo $row['n_blog_post_id'] ?>">
                                                            Delete
                                                        </button>

                                                        <div class="modal fade" id="delete_blog<?php
                                                            echo $row['n_blog_post_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form method="POST" action="">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel">Delete Category</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure that you want to delete this blogs ?
                                                                        </div>
                                                                        <div class="modal-footer">

                                                                            <input hidden="true" name="Main_img" value="<?php echo $row['v_main_image_url'] ?>">
                                                                            <input hidden="true" name="Alt_img" value="<?php echo $row['v_alt_image_url'] ?>">
                                                                            <input hidden="true" name="blog_id" value="<?php echo $row['n_blog_post_id'] ?>">   
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            <button type="submit" name="DeleteBlog" class="btn btn-primary" onclick="">Delete</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
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


</body>

</html>