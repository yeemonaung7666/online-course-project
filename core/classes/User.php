<?php
class User{
    //auth
    public static function auth(){
        if(isset($_SESSION['user_id'])){
            $user_id=$_SESSION['user_id'];
            return DB::table("users")->where('id',$user_id)->getOne();
        }
        return false;
    }
    public function login($request){
        $error =[];
        $email=Helper::filter($request["email"]);
        $password=$request["password"];
        //check email
        $user=DB::table("users")->where('email',$email)->getOne();
        print_r($user);
        //check password
        if($user){
            $db_password=$user->password;//hash
            if(password_verify($password,$db_password)){
                $_SESSION['user_id']=$user->id;
                return "success";
            }else{
                //wrong password
                $error[]="Wrong Password";
            }
        }else{
            //email not found
            $error[]="Wrong Email";

        }
        return $error;
    }

    public function register($request){
        if(isset($request)){
            $error = [];
            if(empty($request['name'])){
                $error[]="Name Field is required";
            }
            if(empty($request['email'])){
                $error[]="Email Field is required";
            }
            if(!filter_var($request['email'],FILTER_VALIDATE_EMAIL)){
                $error[]="Invalid Format";
            }
            if(empty($request['password'])){
                $error[]="Password Field is required";
            }
            // check email already exist
            $user=DB::table('users')->where("email",$request['email'])->getOne();


            if($user){
                $error[]= "Email already exist";
            }
            if(count($error)){
                return $error;
            }else{
                //insert into database
                $user=DB::create("users",[
                    "name"=>Helper::filter($request['name']),
                    "slug"=>Helper::slug($request['name']),
                    "email"=>Helper::filter($request["email"]),
                    "password"=>password_hash($request["password"],PASSWORD_BCRYPT)
                ]);
                //session user_id
                $_SESSION['user_id']=$user->id;

                
                
                return "success";
            }
            
        }
    }

    public static function update($request){
        $user=DB::table('users')->where('slug',$request['slug'])->getOne();
        
        if($request['password']){
            //new password
            $password=password_hash($request['password'],PASSWORD_BCRYPT);
        }else{
            //old password
            $password=$user->password;
        }

        if(isset($_FILES['image'])){
            //new image
            $image=$_FILES['image'];
            $image_name=$image['name'];
            $path="assets/edit/$image_name";
            $tmp_name=$image['tmp_name'];
            move_uploaded_file($tmp_name,$path);
        }else{
            $path=$user->image;
        }
        DB::update("users",[
            "name"=>$request['name'],
            "slug"=>Helper::slug($request['name']),
            "image"=>$path,
            "email"=>$request['email'],
            "password"=>$password
        ],$user->id);
        return 'success';
    }

    
}

?>