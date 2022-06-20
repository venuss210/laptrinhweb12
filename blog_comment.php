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
        include "includes/comment.php";

        $database = new database();
        $db = $database->connect();

        $blogs_comment = new blogs_comment($db);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['DeleteBlog'])) {

                $blogs_comment->n_blog_comment_id = $_POST['blog_id'];

                if ($blogs_comment->delete()) {
                    $flag = "Delete blog successful !";
                };
            }
        }
        ?>
        <!-- DATABASE AND SQL -->
        <div id="page-wrapper">
            <div id="page-inner">

                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Blogs Comment
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
                            Blogs Comment
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Comment</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $result = $blogs_comment->read();
                                        $num = $result->rowCount();
                                        if ($num > 0) {
                                            while ($row = $result->fetch()) {

                                        ?>
                                                <tr>
                                                    <td><?php echo $row['n_blog_comment_id']; ?></td>
                                                    <td><?php echo $row['v_comment_author_email']; ?></td>
                                                    <td><?php echo $row['v_comment']; ?></td>
                                                    <td>
                                                        <button class="btn btn-danger" data-toggle="modal" data-target="#delete_blog<?php
                                                            echo $row['n_blog_comment_id'] ?>">
                                                            Delete
                                                        </button>

                                                        <div class="modal fade" id="delete_blog<?php
                                                            echo $row['n_blog_comment_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form method="POST" action="">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel">Delete Contact</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure that you want to delete this blogs comment ?
                                                                        </div>
                                                                        <div class="modal-footer">

                                                                            <input type="hidden" name="blog_id" value="<?php echo $row['n_blog_comment_id'] ?>">
                                                                            <input type="hidden" name="DeleteBlog" value="1">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-danger" onclick="">Delete</button>
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