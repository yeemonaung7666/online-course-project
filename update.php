<?php
require_once "core/autoload.php";

if(isset($_GET['update']) and !empty($_GET['slug'])){
        $slug=$_GET['slug'];
        $update=Post::update($slug);        
}

?>
<?php
require_once "include/header.php";
?>
<div class="card card-dark">
                                        <div class="card-header">
                                                <h3>Update Your Post</h3>
                                        </div>
                                        <div class="card-body">
                                                <?php
                                                if(isset($update) and $update=='success'){
                                                        Helper::redirect("yourpost.php?slug=".User::auth()->slug);
                                                ?>
                                                <?php
                                                }
                                                ?>
                                                <form action="" method="post" enctype="multipart/form-data">
                                                <?php
                                                $post=DB::table("articles")->where('slug',$slug)->getOne();
                                                ?>
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Enter Title</label>
                                                                <input type="text" name="title" class="form-control text-white mt-2" value="<?php echo $post->title;?>">
                                                        </div>
                                                        <br><br>
                                                        <div class="form-group">
                                                                <label for="">Choose Image</label>
                                                                <input type="file" class="form-control text-white" name="image">
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="" class="text-white"><h6>Enter Articles</h6></label>
                                                                <textarea name="description" class="form-control text-white mt-2"
                                                                        cols="30" rows="10"><?php echo $post->description;?></textarea>
                                                        </div>
                                                        <input type="submit" value="Create"
                                                                class="btn  btn-outline-warning">
                                                </form>
                                        </div>
                                </div>
<?php
require_once "include/footer.php";
?>
