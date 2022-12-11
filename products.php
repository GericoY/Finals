<?php
    session_start();
    $_SESSION['CURR_PAGE'] = 'products';

    require_once("header.php"); 
    require_once("functions.php");

    if(isset($_POST['btnAdd']) && isset($_FILES['photo1']) && isset($_FILES['photo2'])){
        $con = openConnection();
        $name = sanitizeInput($con, $_POST['prodName']);
        $description = sanitizeInput($con, $_POST['prodDesc']);
        $price = $_POST['prodPrice'];

        $err = [];

        $fileName = $_FILES['photo1']['name'];
        $fileSize = $_FILES['photo1']['size'];
        $fileTemp = $_FILES['photo1']['tmp_name'];
        $fileType = $_FILES['photo1']['type'];

        $fileExtTemp = explode('.', $fileName);
        $fileExt = strtolower(end( $fileExtTemp));

        $fileNameTwo = $_FILES['photo2']['name'];
        $fileSizeTwo = $_FILES['photo2']['size'];
        $fileTempTwo = $_FILES['photo2']['tmp_name'];
        $fileTypeTwo = $_FILES['photo2']['type'];

        $fileExtTempTwo = explode('.', $fileNameTwo);
        $fileExtTwo = strtolower(end( $fileExtTempTwo));

        $allowed = array('jpeg', 'jpg', 'png');

    
        $uploadDir = 'uploads/' . $fileName;
        $uploadDirTwo = 'uploads/' . $fileNameTwo;

        if (in_array($fileExt, $allowed) === false && in_array($fileExtTwo, $allowed) === false)
            $err[] = "Extension file is not allowed";
        if ($fileSize > 5000000 && $fileSizeTwo > 5000000 )
            $err[] = "File Should be 5mb Maximum";
        if(empty($name))
            $err[] = "Last name is required!";
        if(empty($description))
            $err[] = "Description is required!";
        if(empty($price))
            $err[] = "Price is required!";

        if(empty($err)){
                $strSql ="
                        INSERT INTO tbl_products(name, description, price, photo1, photo2)
                        VALUES('$name', '$description', '$price', '$fileName', '$fileNameTwo')
                    ";

                if(mysqli_query($con, $strSql)){
                    move_uploaded_file($fileTemp , $uploadDir);
                    move_uploaded_file($fileTempTwo , $uploadDirTwo);
                    header("location:add-success-product.php ");
                }          
                else
                    echo 'Error: Failed to insert record';
           
        }
        closeConnection($con); 
    }
?>


    <div class="container-fluid">
        <div class="row">
            <?php require_once("nav.php") ?>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Add Products</h1>
                    </div>
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="prodName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="prodName" id="prodName" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="prodDesc" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="prodDesc" id="prodDesc" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="prodPrice" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="prodPrice" id="prodPrice" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="photo1" class="col-sm-2 col-form-label"> Photo 1</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="photo1" id="photo1">
                                </div>
                            </div>
                                <div class="form-group row">
                                <label for="photo2" class="col-sm-2 col-form-label"> Photo 2</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="photo2" id="photo2" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" name="btnAdd" class="btn btn-primary  ">Add New Record</button>
                                </div>
                            </div>
                        </form>
                        <br><br>

                    <h3> <i class="fa fa-table"></i>Products List</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Photo</th>
                                    <th colspan="2" >Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $con = openConnection();
                                    $strSql = "SELECT * FROM tbl_products";
                                    $recProducts = getRecord($con, $strSql);

                                    if(!empty($recProducts)){
                                        foreach ($recProducts as $key => $value) {
                                        echo '<tr>';
                                            echo '<td>' . $value['name'] .'</td>';
                                            echo '<td>' . $value['description'] .'</td>';
                                            echo '<td>' . $value['price'] .'</td>';
                                            echo '<td><img src="uploads/'. $value['photo1'] .'" style="height: 50px;"></td>';
                                            echo '<td>'; 
                                                echo '<a href="edit-products.php?k=' . $value['id'] .'" class="btn btn-success">Edit</a> ';
                                                echo '<a href="delete-products.php?k=' . $value['id'] .'" class="btn btn-danger">Remove</a>';
                                            echo '</td>';
                                        echo '</tr>';                       
                                        }
                                    }
                                    else{
                                        echo '<tr>';
                                            echo '<td colspan="5" class="text-center"> No Records found</td>';
                                        echo '</tr>';
                                    }
                                closeConnection($con);                  
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
<?php require_once("footer.php") ?>
