<?php
    $user_types = ["Admin", "Content Manager", "System User"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/styles.css">
    <title>Shopping Cart | Login</title>
</head>
<body>
    <div class="container">
        <?php
            if(isset($_POST['btn_login'])) {
                $valid_user = false;

                foreach($users as $user) {                
                    if($user['user_type'] == $_POST['user_type'] && $user['user_name'] == $_POST['user_name'] && $user['password'] == $_POST['password']) {
                        $valid_user = true;
                        break;
                    }
                }

                if($valid_user == true) {
                    echo '
                        <div class="alert alert-success alert-dismissible fade show col-4 offset-4 mt-5" role="alert">
                            <strong>Welcome to the System</strong> ' . $_POST['user_type'] . '.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    ';                  
                }
                else {
                    echo '
                        <div class="alert alert-danger alert-dismissible fade show col-4 offset-4 mt-5" role="alert">
                            <strong>Invalid User Name/Password.</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    ';  
                }
            }
        ?>
       

        <div class="card card-container">            
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" method="post">
                <select name="user_type" id="user_type" class="form-control">
                    <?php
                        if(isset($user_types)) {
                            foreach($user_types as $user_type) {
                                echo '<option value="' . $user_type . '">' . $user_type . '</option>';
                            }
                        }
                    ?>
                </select>
                <input type="text" name="user_name" id="user_name" class="form-control" placeholder="User Name" required autofocus>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>                
                <button name="btn_login" class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
            </form><!-- /form -->            
        </div><!-- /card-container -->
    </div><!-- /container -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js" integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>