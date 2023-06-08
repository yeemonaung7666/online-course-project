<?php
class DB
{
    private static $dbh;
    private static $res,$data,$count,$sql;
    public function __construct(){
        self::$dbh = new PDO("mysql:host = localhost/phpmyadmin;dbname=php_project","root","");
        //echo "connected"."<br>";
    }
    public function query($parameter=[]){
        self::$res =self::$dbh->prepare(self::$sql);
        self::$res->execute($parameter);
        return $this;
        
    }   
    public function get(){
        $this->query();
        self::$data = self::$res->fetchAll(PDO::FETCH_OBJ);
        return self::$data;
    }
    public function getOne(){
        $this->query();
        self::$data = self::$res->fetch(PDO::FETCH_OBJ);
        return self::$data;
    }

    public function count()
    {
        $this->query();
        self::$count = self::$res->rowcount();
        return self::$count;
    }
    public static function table($table){
        $sql= "select* from $table";
        self::$sql=$sql;
        $db =new DB();
        $db->query($parameter=[]);
        return $db;
    }
    public function orderBy($col,$value){
        self::$sql.=" order by $col $value";
        
        $this->query();
        return $this;
    }
    public function where($col,$operator,$value=''){
        if(func_num_args()==2){
            self::$sql.=" where $col='$operator' ";
        }else{
            self::$sql.=" where $col $operator '$value' ";
        }        
        
        $this->query();
        return $this;
    }
    public function andwhere($col,$operator,$value=''){
        if(func_num_args()==2){
            self::$sql.=" and $col=$operator";
        }else{
            self::$sql.=" and $col $operator $value";
        }        
        
        $this->query();
        return $this;
    }
    public function or($col,$operator,$value=''){
        if(func_num_args()==2){
            self::$sql.=" or $col=$operator";
        }
        else{
            self::$sql.=" or $col $operator $value";
        }
        
        $this->query();
        return $this;
    }
     public static function create($table,$data){
      
        $db= new DB();
        $str_col=implode(',',array_keys($data));//implode is  array to change string
        
        $v='';
        $x=1;
        foreach($data as $d){
            $v.= "?";
            if($x < count($data))
            {
                $v.=",";
                $x++;
            }
        }
        $sql="insert into $table($str_col) values ($v)";
        self::$sql=$sql;
        $value=array_values($data);
        $db->query($value);
        $id=self::$dbh->lastinsertid();
        return DB::table($table)->where('id',$id)->getOne();
    }
    
    public function update($table,$data,$id){
        $db= new  DB();
        $sql= "update $table set ";
        
        $value ="";
        $x =1;
        
        $value ="";
        foreach ($data as $k=> $v){
            $value.= "$k =?";
            if($x < count($data)){
                $value.= ",";
                $x++;
            }
        }
        
        $sql.="$value where id= $id";
        self::$sql= $sql;
        $db->query(array_values($data));
        return DB::table($table)->where('id',$id)->getone();
        
        
    }
    public static function delete($table,$col,$data){
        $sql="delete from $table where $col='$data'";
        echo self::$sql=$sql;
        $db= new DB();
        $db->query();
        return true;
        echo self::$sql;
    }
    public function raw($sql){
        $db= new DB();
        self::$sql=$sql;
        $db->query();
        return $db;
        echo self::$sql;

    }
    public function select($sql){
        $db= new DB();
        echo self::$sql.=$sql;
        $db->query();
        return $db;
        echo self::$sql;

    }
    
    public function paginate($record_par_page,$append=""){
        if(isset($_GET['page'])){
            $page_no= $_GET['page'];
        }
        else{
            $page_no= $_GET['page']=1;
        }
        if(!isset($_GET['page'])){
            $page_no = 1;
        }
        if(isset($_GET['page']) and $_GET['page']<1){
            $page_no =1;
        }
        //to get total why use before limit because want get all table row number 
        $this->query();
        $count = self::$res->rowcount();
        //echo $count;
        //echo"<br>";


        // 0,3  page number=1  (1-1)*3=0
        // 5,3  page number=2  (2-1)*3=3
        //10,3  page number=3  (3-1)*3=6
        $index= ($page_no - 1)* $record_par_page;
        //select * from user limit 0,3;
        self::$sql.=" limit $index,$record_par_page";
        //echo self::$sql;
        $this->query();
        self::$data = self::$res->fetchAll(PDO::FETCH_OBJ);
        //echo "<pre>";
        //var_dump(self::$data);

        // to move prev page and next page
        $prev_no= $page_no-1;
        $next_no= $page_no+1;
        $prev_page= "?page=".$prev_no;
        $next_page= "?page=".$next_no;

        $data = [
            "data"=>self::$data,
            "total"=>$count,
            
            "prev_page"=>"$prev_page&$append",
            "next_page"=>"$next_page&$append",
        ];
        return $data;
    }
}
