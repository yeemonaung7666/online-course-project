<?php
require_once("core/autoload.php");

if(User::auth()){
        Helper::redirect("index.php");
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
        $login=new User();
        $login=$login->login($_POST);
        if($login=='success'){
                Helper::redirect("index.php");
        }
}

    require_once "include/header.php";
?>
<div class="card card-dark">
        <div class="card-header bg-warning">
                <h3>Login</h3>
        </div>
        <div class="card-body">
        <?php
                if(isset($login) and is_array($login)){
                        foreach($login as $l){
        ?>
                <div class="alert alert-danger"><?php echo $l; ?></div>
        <?php
                        }
                }
        ?>
                <form action="" method="post">
                        <div class="form-group">
                                <label for="" class="text-white">Enter Email</label>
                                <input type="name" name="email" class="form-control"
                                        placeholder="enter email">
                        </div>
                        <div class="form-group">
                                <label for="" class="text-white">Enter Password</label>
                                <input type="password" name="password" class="form-control"
                                        placeholder="enter password">
                        </div>
                        <input type="submit" value="Login"
                                class="btn  btn-outline-warning">
                </form>
        </div>
</div>
</div>
<?php
    require_once "include/footer.php";
?>