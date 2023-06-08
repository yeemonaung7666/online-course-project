<?php
    require_once "core/autoload.php";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $d=Post::create($_POST);
    }
?>
<?php
    require_once "include/header.php";
?>
    <div class="card card-dark">
                                        <div class="card-header">
                                                <h3>Create New Article</h3>
                                        </div>
                                        <div class="card-body">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                <?php
                                                if(isset($d) and $d=='success'){
                                                ?>
                                                        <div class="alert alert-success">Article Create Success!</div>
                                                <?php
                                                }
                                                ?>
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Enter Title</label>
                                                                <input type="text" name="title" class="form-control text-white"
                                                                        placeholder="enter title">
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Choose Category</label>
                                                                <select name="category_id" id="" class="form-control text-white">
                                                                <?php
                                                                $category=DB::table("category")->get();
                                                                foreach($category as $c){
                                                                ?>
                                                                        <option value="<?php echo $c->id;?>"><?php echo $c->name;?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                                
                                                                </select>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                        <?php 
                                                        $languages=DB::table("languages")->get();
                                                        foreach($languages as $l){
                                                        ?>
                                                                <span class="mr-2">
                                                                        <input class="form-check-input text-white" type="checkbox"
                                                                                name="language_id[]" value="<?php echo $l->id;?>">
                                                                        <label class="form-check-label text-white"
                                                                                for="inlineCheckbox1"><?php echo $l->name;?></label>
                                                                </span>
                                                        <?php
                                                        }
                                                        ?>
                                                                
                                                        </div>
                                                        <br><br>
                                                        <div class="form-group">
                                                                <label for="">Choose Image</label>
                                                                <input type="file" class="form-control text-white" name="image">
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="" class="text-white">Enter Articles</label>
                                                                <textarea name="description" class="form-control text-white" id=""
                                                                        cols="30" rows="10"></textarea>
                                                        </div>
                                                        <input type="submit" value="Create"
                                                                class="btn  btn-outline-warning">
                                                </form>
                                        </div>
                                </div>
<?php
    require_once "include/footer.php";
?>
