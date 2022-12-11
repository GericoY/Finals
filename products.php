<?php
    session_start();
    $_SESSION['CURR_PAGE'] = 'products';

    require_once("header.php"); 
    require_once("functions.php");

    if(isset($_POST['add'])){
        $prodName = sanitizeInput($con, $_POST['prodName']);
        $prodDesc = sanitizeInput($con, $_POST['prodDesc']);
        $prodPrice = sanitizeInput($con, $_POST['prodPrice']);
        $photo1 = $_POST['photo1'];
        $photo2 = $_POST['photo2'];

        $err = [];

        if(empty($prodName))
            $err = "Product Name is required!";
        if(empty($prodDesc))
            $err = "Product Description is required!";
        if(empty($prodPrice))
            $err = "Product Price is required!";

        if(empty($err)){
            $con = openConnection();

            $strSql = "
                    INSERT INTO tbl_products(name, description, price)
                    VALUES ('$prodName', '$prodDesc', '$prodPrice')
            ";

            if(mysqli_query($con, $strSql))
                header('add-success-product');
            else
                echo 'ERROR: Failed to insert record!';
            
            closeConnection($con);
        }
    }
?>


    <div class="container-fluid">
        <div class="row">
            <?php require_once("nav.php") ?>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Add Products</h1>
                    </div>

                    <form method="post">
                        <div class="form-group row">
                            <label for="prodName" class="col-sm-2 col-form-label text-right">Product Name: <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="prodName" id="prodName" class="form-control" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="prodDesc" class="col-sm-2 col-form-label text-right">Product Description: <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="prodDesc" id="prodDesc" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="prodPrice" class="col-sm-2 col-form-label text-right">Product Price: <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="prodPrice" id="prodPrice" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="photo1" class="col-sm-2 col-form-label text-right">Select Photo 1: <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" name="photo1" id="photo1" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="photo2" class="col-sm-2 col-form-label text-right">Select Photo 1: <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" name="photo2" id="photo2" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                                <button type="submit" name="add" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>

                <h2>Products</h2>    
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>price</th>
                                <th>photo1</th>
                                <th>photo2</th>
                                <th colspan="2">Options</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                $con = openConnection();
                                $strSql = "SELECT * FROM tbl_products";
                                $recPersons = getRecord($con, $strSql);

                                if(!empty($recPersons)){
                                    foreach ($recPersons as $key => $value) {
                                            echo '<tr>';
                                                echo '<td>' . $value['id'] . '</td>';
                                                echo '<td>' . $value['name'] . '</td>';
                                                echo '<td>' . $value['description'] . '</td>';
                                                echo '<td>' . $value['price'] . '</td>';
                                                echo '<td>' . $value['photo1'] . '</td>';
                                                echo '<td>' . $value['photo2'] . '</td>';
                                                echo '<td>
                                                    <a href="update-person.php?k='. $value[$key] .'" class="btn btn-success"></a>
                                                    <a href="delete-person.php?k='. $value[$key] .'" class="btn btn-danger"></a>
                                                </td>';
                                            echo '</tr>';
                                    }
                                }
                                else{

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
