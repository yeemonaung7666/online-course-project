<?php
require_once "core/autoload.php";
$request=$_GET;
if(isset($request['like'])){
    $user_id=$request['user_id'];
    $article_id=$request['article_id'];
    $u=DB::table("article_likes")->where("user_id",$user_id)->andwhere("article_id",$article_id)->getOne();
    if($u){
        echo "Already Like";
    }else{
        $user=DB::create("article_likes",[
            "user_id"=>$user_id,
            "article_id"=>$article_id
        ]);
        if($user){
            $count=DB::table("article_likes")->where("article_id",$article_id)->count();
            echo $count;
        }
    }
    
}

//comment
if($_POST['comment']){
    $user_id=User::auth()->id;
    $article_id=$_POST['article_id'];
    $comment=$_POST['comment'];
    $user_comment=DB::create("article_comments",[
        "user_id"=>$user_id,
        "article_id"=>$article_id,
        "comment"=>$comment
    ]);
    if($user_comment){
        $cmt=DB::table("article_comments")->where("article_id",$article_id)->orderBy('id','DESC')->get();
        $html="";       
        foreach($cmt as $c){
            $users=DB::table('users')->where("id",$c->user_id)->get();
            
            $html.="
            <div class='card-dark mt-1 w-100'>
            <div class='card-body'>                                                                        
                    <div class='row'>
                            <div class='col-md-1'>
                                    <img src='{$users[0]->name}' style='width:50px;border-radius:50%' alt=''>
                            </div>
                            <div class='col-md-11 d-flex align-items-center'>
                                    {$users[0]->name}
                            </div>
                    </div>
                    <hr>
                    <div class='col-md-12'>
                            <p>{$c->comment}</p>
                    </div>
                                                                                                
            </div>
    </div>
           "; 
            
            
        }
        echo $html;
    }
}

