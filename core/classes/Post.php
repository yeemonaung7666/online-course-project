<?php
class Post{
    public static function all(){
        $data=DB::table("articles")->orderBy("id","DESC")->paginate(3);
        foreach($data['data'] as $k=>$d){
            $data['data'][$k]->comment_count=DB::table("article_comments")->where("article_id",$d->id)->count();
            $data['data'][$k]->like_count=DB::table("article_likes")->where("article_id",$d->id)->count();

        }
        return $data;
    }

    public static function detail($slug){
        $data=DB::table("articles")->where('slug',$slug)->getOne();
        //try to get language
        $data->languages=DB::raw("SELECT languages.id, languages.slug, languages.name  FROM article_language 
        left join languages
        on languages.id=article_language.language_id
        WHERE articles_id={$data->id}")->get();
        //try to get comments
        $data->comments=DB::table("article_comments")->where("article_id",$data->id)->get();
        //try to get category
        $data->category=DB::table("category")->where('id',$data->category_id)->getOne();
        //try to get like_count
        $data->like_count=DB::table("article_likes")->where("article_id",$data->id)->count();
        //try to get comment_count
        $data->comment_count=DB::table("article_comments")->where("article_id",$data->id)->count();
        return $data;
        
    }

    public static function articleByCategory($slug){
        $category_id=DB::table('category')->where('slug',$slug)->getOne()->id;
        $data=DB::table("articles")->where('category_id',$category_id)->orderBy("id","DESC")->paginate(3,"category=$slug");
        foreach($data['data'] as $k=>$d){
            $data['data'][$k]->comment_count=DB::table("article_comments")->where("article_id",$d->id)->count();
            $data['data'][$k]->like_count=DB::table("article_likes")->where("article_id",$d->id)->count();

        }
        return $data;
    }

    public static function articleByLanguage($slug){
        $language_id=DB::table('languages')->where('slug',$slug)->getOne()->id;
        $data=DB::raw("
        select * from article_language
        inner JOIN articles
        on articles.id=article_language.articles_id
        where article_language.language_id = $language_id
        ")->orderBy("articles.id","DESC")->paginate(3,"language=$slug");

        foreach($data['data'] as $k=>$d){
            $data['data'][$k]->comment_count=DB::table("article_comments")->where("article_id",$d->id)->count();
            $data['data'][$k]->like_count=DB::table("article_likes")->where("article_id",$d->id)->count();

        }
        return $data;
    }
    
    public static function create($request){
           
        //image upload
        $image=$_FILES['image'];
        $image_name=$image['name'];
        $path="assets/article/$image_name";
        $tmp_name=$image['tmp_name'];
        if(move_uploaded_file($tmp_name,$path)){
            $article=DB::create('articles',[
                "user_id"=>User::auth()->id,
                "category_id"=>$request['category_id'],
                "slug"=>Helper::slug($request["title"]),
                "user_slug"=>User::auth()->slug,
                "title"=>$request["title"],
                "image"=>$path,
                "description"=>$request["description"]
            ]);

            if($article){
                foreach($request['language_id'] as $lan_id){
                    $data=DB::create("article_language",[
                        "articles_id"=>$article->id,
                        "language_id"=>$lan_id
                    ]);
                    return "success";
                }
                
            }else{
                return false;
            }
        }else{
            return false;
        }


    }

    public static function search($search){
        $data=DB::table("articles")->where('title','like',"%$search%")->orderBy("id","DESC")->paginate(4,"search=$search");
        
        foreach($data['data'] as $k=>$d){
            $data['data'][$k]->comment_count=DB::table("article_comments")->where("article_id",$d->id)->count();
            $data['data'][$k]->like_count=DB::table("article_likes")->where("article_id",$d->id)->count();

        }
        return $data;
    }

    public static function yourpost($slug){
        $data=DB::table('articles')->where('user_slug',$slug)->paginate(3,"slug=$slug");
        foreach($data['data'] as $k=>$d){
            $data['data'][$k]->comment_count=DB::table("article_comments")->where("article_id",$d->id)->count();
            $data['data'][$k]->like_count=DB::table("article_likes")->where("article_id",$d->id)->count();

        }
        return $data;
    }

    public static function delete($slug){
        DB::delete("articles","slug",$slug);
    }

    public static function update($slug){
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $title=$_POST['title'];
            $update_slug=Helper::slug($title);
            $description=$_POST['description'];
            $image=$_FILES['image'];
            $image_name=$image['name'];
            $path="assets/update/$image_name";
            $tmp_name=$image['tmp_name'];
            if(move_uploaded_file($tmp_name,$path))
            {
            $update=DB::raw("UPDATE articles set title='$title',
                                        slug='$update_slug',
                                        image='$path',
                                        description='$description'
                                        WHERE slug='$slug'")->get();
                    
                    return "success";
            }
            else{
                return false;
            }
    }

    }
}

?>
