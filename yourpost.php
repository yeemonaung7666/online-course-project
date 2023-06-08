<?php 
        require_once "include/header.php";
        if(isset($_GET['slug']) and !empty($_GET['slug'])){
                $slug=$_GET['slug'];
                $post=Post::yourpost($slug);               
        }
        else{
                              
                $post=Post::all();
                
        }
        if(isset($_GET['delete'])){
                $slug=$_GET['slug'];
                Post::delete($slug);
                Helper::redirect("index.php?id=".User::auth()->id);
        }
        
?>

        
                                <div class="card card-dark">
                                        <div class="card-body">
                                                <a href="<?php echo $post['prev_page']?>" class="btn btn-danger">Prev Posts</a>
                                                <a href="<?php echo $post['next_page']?>" class="btn btn-danger float-right">Next Posts</a>
                                        </div>
                                </div>
                                <div class="card card-dark">
                                        <div class="card-body">
                                                <div class="row">
                                                        <!-- Loop this -->
                                                        <?php
                                                        
                                                        foreach($post['data'] as $a){
                                                        ?>
                                                                <div class="col-md-4 mt-2">
                                                                <div class="card" style="width: 18rem;">
                                                                        <img class="card-img-top"
                                                                                src="<?php echo $a->image;?>"
                                                                                alt="Card image cap">
                                                                        <div class="card-body">
                                                                                <h5 class="text-dark"><?php echo $a->title;?></h5>
                                                                        </div>
                                                                        <div class="card-footer">
                                                                                <div class="row">
                                                                                        <div
                                                                                                class="col-md-4 text-center">
                                                                                                <i
                                                                                                        class="fas fa-heart text-warning">
                                                                                                </i>
                                                                                                <small
                                                                                                        class="text-muted"><?php echo $a->like_count;?></small>
                                                                                        </div>
                                                                                        <div
                                                                                                class="col-md-4 text-center">
                                                                                                <i
                                                                                                        class="far fa-comment text-dark"></i>
                                                                                                <small
                                                                                                        class="text-muted"><?php echo $a->comment_count;?></small>
                                                                                        </div>
                                                                                        <div
                                                                                                class="col-md-4 text-center">
                                                                                                <a href="<?php echo "detail.php?slug=$a->slug"?>"
                                                                                                        class="badge badge-warning p-1">View</a>
                                                                                                
                                                                                                        
                                                                                                <a href="index.php?delete=true&slug=<?php echo $a->slug;?>"
                                                                                                                class="badge badge-warning p-1">Delete</a>
                                                                                                
                                                                                                <a href="update.php?update=true&slug=<?php echo $a->slug;?>"
                                                                                                                class="badge badge-warning p-1">Update</a>
                                                                                                        
                                                                                                
                                                                                        </div>
                                                                                </div>

                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        
                                                </div>
                                        </div>
                                </div>
<?php 
require_once "include/footer.php";
?>