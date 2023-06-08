<?php
    require_once "core/autoload.php";
    if(!isset($_GET['slug'])){
        Helper::redirect("404page.php");
    }else{
        $slug=$_GET['slug'];
        $article=Post::detail($slug);
        
        
    }
?>

<?php
    require_once "include/header.php";
?>
<div class="card card-dark">
                                        <div class="card-body">
                                                <div class="row">
                                                        <div class="col-md-12">
                                                                <div class="card card-dark">
                                                                        <div class="card-body">
                                                                                <div class="row">
                                                                                        <!-- icons -->
                                                                                        <div class="col-md-4">
                                                                                                <div class="row">
                                                                                                        <div
                                                                                                                class="col-md-4 text-center">
                                                                                                                <?php
                                                                                                                $user_id=User::auth() ? User::auth()->id : 0;
                                                                                                                $article_id=$article->id;
                                                                                                                ?>
                                                                                                                <i id="like"
                                                                                                                        class="fas fa-heart text-warning" user_id="<?php echo $user_id;?>" article_id="<?php echo $article_id;?>">
                                                                                                                </i>
                                                                                                                <small id="like_count"
                                                                                                                        class="text-muted"><?php echo $article->like_count;?></small>
                                                                                                        </div>
                                                                                                        <div
                                                                                                                class="col-md-4 text-center">
                                                                                                                <i
                                                                                                                        class="far fa-comment text-dark"></i>
                                                                                                                <small
                                                                                                                        class="text-muted"><?php echo $article->comment_count;?></small>
                                                                                                        </div>

                                                                                                </div>
                                                                                        </div>
                                                                                        <!-- Icons -->

                                                                                        <!-- Category -->
                                                                                        <div class="col-md-4">
                                                                                                <div class="row">
                                                                                                        <div
                                                                                                                class="col-md-12">
                                                                                                                <a href=""
                                                                                                                        class="badge badge-primary"><?php echo $article->category->name;?></a>

                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>
                                                                                        <!-- Category -->


                                                                                        <!-- Category -->
                                                                                        <div class="col-md-4">
                                                                                                <div class="row">
                                                                                                        <?php
                                                                                                        foreach($article->languages as $l){
                                                                                                        ?>
                                                                                                        <div
                                                                                                                class="col-md-12">
                                                                                                                <a href=""
                                                                                                                        class="badge badge-success"><?php echo $l->name;?>
                                                                                                                </a>
                                                                                                                
                                                                                                        </div>
                                                                                                        <?php
                                                                                                        }
                                                                                                        ?>
                                                                                                        
                                                                                                </div>
                                                                                        </div>
                                                                                        <!-- Category -->

                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <br>
                                                <div class="col-md-12">
                                                        <h3><?php echo $article->title;?></h3>
                                                        <p>
                                                                <?php echo $article->description;?>
                                                        </p>
                                                </div>
                                                <div class="card card-dark">
                                                <div class="card-body">
                                                        <from  method="POST" id="form">
                                                                <input type="text" class="form-control" placeholder="Enter Comment" id="comment">
                                                                <input type="submit" value="Create" class="btn btn-outline-warning float-right mt-2" id="Create" >                               
                                                        </from>
                                                </div>
                                                </div>
                                                <!-- Comments -->
                                                <div class="card card-dark">
                                                        <div class="card-header">
                                                                <h4>Comments</h4>
                                                        </div>
                                                        <div class="card-body">
                                                        <div id="comment_list">
                                                                <!-- Loop Comment -->
                                                                <?php
                                                                foreach($article->comments as $c){
                                                                ?>
                                                                <div class="card-dark mt-1">
                                                                        <div class="card-body">
                                                                                <div class="row">
                                                                                        <div class="col-md-1">
                                                                                                <img src='<?php echo  DB::table('users')->where('id',$c->user_id)->getOne()->image;?>'
                                                                                                        style="width:50px;border-radius:50%"
                                                                                                        alt="">
                                                                                        </div>
                                                                                        <div
                                                                                                class="col-md-4 d-flex align-items-center">
                                                                                                <?php echo  DB::table('users')->where('id',$c->user_id)->getOne()->name; ?>
                                                                                        </div>
                                                                                </div>
                                                                                <hr>
                                                                                <p><?php echo $c->comment;?></p>
                                                                        </div>
                                                                </div>
                                                                <?php
                                                                }
                                                                ?>
                                                        </div>                                                                                                                              
                                                       </div>
                                                </div>
                                        </div>
                                </div>
<?php
    require_once "include/footer.php";
    
?>

<script>
//comment
        var form=document.getElementById('Create');
        form.addEventListener('click',function(e){
                e.preventDefault();
                var data=new FormData();
                data.append('comment',document.getElementById('comment').value);
                data.append('article_id',<?php echo $article->id;?>);
                axios.post("api.php",data)
                .then(function(res){
                        console.log(res.data);
                        document.getElementById("comment_list").innerHTML= res.data;
                        <?php $aa=DB::table('articles')->where('id',$article->id)->getOne();?>
                        location.href="detail.php?slug=<?php echo $aa->slug;?>"
                        
                })
        })

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