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
        include "includes/categories.php";

        $database = new database();
        $db = $database->connect();

        $category = new categories($db);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['AddForm'])) {
                $category->v_category_title = $_POST['title'];
                $category->v_category_meta_title = $_POST['meta_title'];
                $category->v_category_path = $_POST['path'];
                $category->d_date_created = date("Y-m-d",time());
                $category->d_time_created = date("h:i:s",time());

                if($category->create()){
                    $flag = "Add category successful !";
                };

            }else if(isset($_POST['EditForm'])) {
                $category->n_category_id = $_POST['category_id'];
                $category->v_category_title = $_POST['title'];
                $category->v_category_meta_title = $_POST['meta_title'];
                $category->v_category_path = $_POST['path'];
                $category->d_date_created = date("Y-m-d",time());
                $category->d_time_created = date("h:i:s",time());

                

                if($category->update()){
                    $flag = "Edit category successful !"; 
                };

            }else if(isset($_POST['DeleteCategory'])){
                $category->n_category_id = $_POST['category_id'];
                
                if($category->delete()){
                    $flag = "Delete category successful !";
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
                            Blog Categories
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->

                <?php
                    if(isset($flag)){
                ?>        
                    <div class="alert alert-success">
                        <strong><?php echo $flag?></strong>
                    </div>
                <?php        
                    }
                ?>
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Add Categories
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" method="POST" action="">
                                        <div class="form-group">
                                            <label>Category Title</label>
                                            <input class="form-control" placeholder="Enter category title" name="title">
                                        </div>
                                        <div class="form-group">
                                            <label>Category Meta Title</label>
                                            <input class="form-control" placeholder="Enter category meta title" name="meta_title">
                                        </div>
                                        <div class="form-group">
                                            <label>Category Path</label>
                                            <input class="form-control" placeholder="Enter category path" name="path">
                                        </div>
                                        <div class="form-group">
                                            <input hidden="true" name="AddForm" value="1">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Add Category</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            All Categories
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Meta title</th>
                                            <th>Category Path</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $result = $category->read();
                                        $num = $result->rowCount();
                                        if ($num > 0) {
                                            while ($row = $result->fetch()) {

                                        ?>
                                                <tr>
                                                    <td><?php echo $row['n_category_id']; ?></td>
                                                    <td><?php echo $row['v_category_title']; ?></td>
                                                    <td><?php echo $row['v_category_meta_title']; ?></td>
                                                    <td><?php echo $row['v_category_path']; ?></td>
                                                    <td>
                                                        <button class="popup-button btn btn-success">Views</button>
                                                        <button class="btn btn-warning" data-toggle="modal" data-target="#edit_category<?php
                                                            echo $row['n_category_id'] ?>">
                                                            Edit
                                                        </button>
                                                        <button class="btn btn-danger" data-toggle="modal" data-target="#delete_category<?php
                                                            echo $row['n_category_id'] ?>">
                                                            Delete
                                                        </button>

                                                        <div class="modal fade" id="edit_category<?php
                                                            echo $row['n_category_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h4 class="modal-title" id="myModalLabel">Edit Category</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form role="form" method="POST" action="">
                                                                            <div class="form-group">
                                                                                <label>Category Title</label>
                                                                                <input class="form-control" placeholder="Enter category title" name="title" value="<?php echo $row['v_category_title'] ?>">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Category Meta Title</label>
                                                                                <input class="form-control" placeholder="Enter category meta title" name="meta_title" value="<?php echo $row['v_category_meta_title'] ?>">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Category Path</label>
                                                                                <input class="form-control" placeholder="Enter category path" name="path" value="<?php echo $row['v_category_path'] ?>">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <input hidden="true" name="EditForm" value="1">
                                                                                <input hidden="true" name="category_id" value="<?php echo $row['n_category_id']?>">
                                                                            </div>
                                                                            
                                                                            <div class="modal-footer">
                                                                                
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal fade" id="delete_category<?php
                                                            echo $row['n_category_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form method="POST" action="">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h4 class="modal-title" id="myModalLabel">Delete Category</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure that you want to delete that category ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input hidden="true" name="category_id" value="<?php echo $row['n_category_id']?>">
                                                                        <input hidden="true" name="DeleteCategory" value="1">
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