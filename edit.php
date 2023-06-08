<?php
require_once "core/autoload.php";
if(isset($_GET['user'])){
    $slug=$_GET['user'];
    $user=DB::table('users')->where('slug',$slug)->getOne();
    if(!$user){
        Helper::redirect("404page.php");
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $res=User::update($_POST);
    }
}else{
    Helper::redirect("404page.php");
}

?>

<?php
        require_once "include/header.php";
?>   

    <div class="card card-dark">
                                        <div class="card-header bg-warning">
                                                <h3>Edit User Account</h3>
                                        </div>
                                        <div class="card-body">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                <?php
                                                if(isset($res) and $res=='success'){
                                                ?>
                                                        <div class="alert alert-success">Update Success!</div>
                                                <?php
                                                }
                                                ?>
                                                <input type="hidden" name="slug" value="<?php echo $user->slug;?>">                                               
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Enter Username</label>
                                                                <input type="name" name="name" class="form-control"
                                                                        value="<?php echo $user->name;?>" require>
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Enter Email</label>
                                                                <input type="name" name="email" class="form-control"
                                                                        value="<?php echo $user->email;?>">
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Enter Password</label>
                                                                <input type="password" class="form-control"
                                                                         name="password">
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Choose Image</label>
                                                                <input type="file" class="form-control"
                                                                         name="image" >
                                                                         <img class="card-img-top"
                                                                                src="<?php echo $user->image;?>"
                                                                                style="width:200px;border-radius:20px;"
                                                                                alt="Card image cap">
                                                        </div>
                                                        <input type="submit" value="Update"
                                                                class="btn  btn-outline-warning">
                                                </form>
                                        </div>
                                </div>
<?php 
    require_once "include/footer.php";
?>