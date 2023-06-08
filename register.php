<?php
require_once "core/autoload.php";

if(User::auth()){
        Helper::redirect("index.php");
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
        $users=new User();
        $users=$users->register($_POST);
        if($users == "success"){
                Helper::redirect("index.php");
        }
}
?>

<?php
        require_once "include/header.php";
?>   

    <div class="card card-dark">
                                        <div class="card-header bg-warning">
                                                <h3>Register</h3>
                                        </div>
                                        <div class="card-body">
                                                <form action="" method="post">
                                                <?php
                                                if(isset($user) and is_array($user)){
                                                        foreach($user as $u){
                                                                ?>
                                                                <div class="alert alert-danger"><?php echo $u; ?></div>
                                                                <?php
                                                        }
                                                }
                                                ?>
                                                
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Enter Username</label>
                                                                <input type="name" name="name" class="form-control"
                                                                        placeholder="enter username" require>
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Enter Email</label>
                                                                <input type="name" name="email" class="form-control"
                                                                        placeholder="enter email">
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Enter Password</label>
                                                                <input type="password" class="form-control"
                                                                        placeholder="enter password" name="password">
                                                        </div>
                                                        <input type="submit" value="Register"
                                                                class="btn  btn-outline-warning">
                                                </form>
                                        </div>
                                </div>
<?php 
    require_once "include/footer.php";
?>