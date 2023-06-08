<?php 
        require_once "include/header.php";
        
        if(isset($_GET['category'])){
                $slug=$_GET['category'];
                $post=Post::articleByCategory($slug);
        }elseif(isset($_GET['language'])){
                $slug=$_GET['language'];
                $post=Post::articleByLanguage($slug);
        }elseif(isset($_GET['search'])){
                $search=$_GET['search'];
                $post=Post::search($search);
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
                                                                                                <?php
                                                                                                $user_id=User::auth() ? User::auth()->id : 0;
                                                                                                $article_id=$a->id;
                                                                                                ?>
                                                                                                <i id="like"
                                                                                                        class="fas fa-heart text-warning" user_id="<?php echo $user_id;?>" article_id="<?php echo $article_id;?>">
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
                                                                                                <?php
                                                                                                        if(isset($_GET['id'])){
                                                                                                        $id=$_GET['id'];
                                                                                                                if($id==$a->user_id){
                                                                                                                        
                                                                                                ?>
                                                                                                        
                                                                                                        <a href="index.php?delete=true&slug=<?php echo $a->slug;?>"
                                                                                                                class="badge badge-warning p-1">Delete</a>
                                                                                                        <?php
                                                                                                        
                                                                                                        ?>
                                                                                                        <a href="update.php?update=true&slug=<?php echo $a->slug;?>"
                                                                                                                class="badge badge-warning p-1">Update</a>
                                                                                                        
                                                                                                <?php 
                                                                                                                          
                                                                                                                }
                                                                                                        }
                                                                                                ?>
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
<script>


//like
        var like=document.querySelector('#like');
        var like_count=document.querySelector('#like_count');
        like.addEventListener("click",function(){
                var user_id=like.getAttribute('user_id');
                var article_id=like.getAttribute('article_id');
                if(user_id == 0){
                        location.href="login.php";
                }
                axios.get(`api.php?like&user_id=${user_id}&article_id=${article_id}`)
                .then(function(res){
                        if(res.data=='Already Like'){
                                toastr.warning("Already Like");
                        }
                        if(Number.isInteger(res.data)){
                                like_count.innerHTML=res.data;
                                toastr.success("Like Success");    
                        }
                        
                })
        })
        
</script>