<?php 
    require_once("functions.php")
?>
<?php
    session_start();

	if(isset($_GET['k'])){
		$_SESSION['k'] = $_GET['k'];
	}
            
    $con = openConnection();
    $strSql= "SELECT * FROM tbl_products WHERE id = ".$_SESSION['k'];
    

   	if($rsProducts = mysqli_query($con, $strSql)){
        if(mysqli_num_rows($rsProducts) > 0){
           ($recProducts = mysqli_fetch_array($rsProducts));
               mysqli_free_result($rsProducts);
               }
		else{
            echo '<tr>';
                echo '<td 	No Record Found!</td>';
            echo '</tr>';
                }
           
   	}

   	else{
   		echo 'ERROR: Could not execute your request.';
   	}
       closeConnection($con); 

    if(isset($_POST['Delete'])){
        $con = openConnection();
        $name = sanitizeInput($con, $_POST['prodName']);
        $description = sanitizeInput($con, $_POST['prodDesc']);
        $price = $_POST['prodPrice'];

        $err = [];


        if(empty($name))
            $err[] = "Name is required!";
        if(empty($description))
            $err[] = "Description is required!";
        if(empty($price))
            $err[] = "Price is required!";

            if(empty($err)){
                    $strSql = "
                                DELETE FROM tbl_products
                                WHERE id = ".$_SESSION['k'];
                if(mysqli_query($con, $strSql))
                    header('location: products.php');
                
                else
                    echo 'ERROR: Failed to Delete Record!';
            }
        closeConnection($con); 
    }

?>
<?php require_once("header.php") ?>
    <div class="container-fluid">
        <div class="row">
            <?php require_once("nav.php") ?>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"> <i class="fa fa-edit"></i> Delete Products</h1>
                </div> 
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="prodName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="prodName" id="prodName" value="<?php echo (isset($recProducts['name']) ? $recProducts['name'] : ''); ?>" required>
                            </div>
                    </div>
                    <div class="form-group row">
                        <label for="prodDesc" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="prodDesc" id="prodDesc" value="<?php echo (isset($recProducts['description']) ? $recProducts['description'] : ''); ?>" required>
                            </div>
                    </div>
                    <div class="form-group row">
                        <label for="prodPrice" class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="prodPrice" id="prodPrice" value="<?php echo (isset($recProducts['price']) ? $recProducts['price'] : ''); ?>" required>
                            </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" name="Delete" class="btn btn-primary  "><i class="fa fa-edit"></i> Delete Record</button>
                            <a href="products.php" class="btn btn-primary  ">Go back</a>
                        </div>
                    </div>
                </form>
                <br><br>
            </main>
        </div>
    </div>       
<?php require_once("footer.php") ?>
