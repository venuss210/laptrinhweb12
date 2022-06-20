<?php
class categories{

    private $conn ; 
    private $table = "blog_category"; 

    public $n_category_id; 
    public $v_category_title; 
    public $v_category_meta_title; 
    public $v_category_path; 
    public $d_date_created; 
    public $d_time_created;

    public function __construct($db)
    {
        $this->conn = $db ;
    }

    public function read_single(){
        $sql = "Select * from $this->table where n_category_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id',$this->n_category_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->n_category_id = $row['n_category_id']; 
        $this->v_category_title = $row['v_category_title']; 
        $this->v_category_meta_title = $row['v_category_meta_title']; 
        $this->v_category_path = $row['v_category_path']; 
        $this->d_date_created = $row['d_date_created']; 
        $this->d_time_created = $row['d_time_created'];
    }

    public function read(){
        $sql = "Select * from $this->table";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt ; 
    }

    public function create(){
        $sql = "insert into $this->table set 
        n_category_id = :id , 
        v_category_title = :title, 
        v_category_meta_title = :meta, 
        v_category_path = :path,
        d_date_created = :date,
        d_time_created = :time";

        $this->v_category_title = htmlspecialchars(strip_tags($this->v_category_title));
		$this->v_category_meta_title = htmlspecialchars(strip_tags($this->v_category_meta_title));
		$this->v_category_path = htmlspecialchars(strip_tags($this->v_category_path));

        $stmt = $this->conn->prepare($sql) ;
        $stmt->bindParam(':id' , $this->n_category_id); 
        $stmt->bindParam(':title' , $this->v_category_title); 
        $stmt->bindParam(':meta' , $this->v_category_meta_title); 
        $stmt->bindParam(':path' , $this->v_category_path); 
        $stmt->bindParam(':date' , $this->d_date_created); 
        $stmt->bindParam(':time' , $this->d_time_created);
        
        if($stmt->execute()){
            return true ;
        }
        printf("Error: %s", $stmt->error);
        
        return false ;
    }

    public function update(){
        $sql = "Update $this->table set 

        v_category_title = :title, 
        v_category_meta_title = :meta,
        v_category_path = :path,     
        d_date_created = :date,
        d_time_created = :time
        where n_category_id = :id"; 

        $this->v_category_title = htmlspecialchars(strip_tags($this->v_category_title));
		$this->v_category_meta_title = htmlspecialchars(strip_tags($this->v_category_meta_title));
		$this->v_category_path = htmlspecialchars(strip_tags($this->v_category_path));


        $stmt = $this->conn->prepare($sql); 
        $stmt->bindParam(':id',$this->n_category_id);
        $stmt->bindParam(':title',$this->v_category_title);
        $stmt->bindParam(':meta',$this->v_category_meta_title);
        $stmt->bindParam(':path',$this->v_category_path);
        $stmt->bindParam(':date',$this->d_date_created);
        $stmt->bindParam(':time',$this->d_time_created);
    
        if($stmt->execute()){
            return true; 
        }
        printf("Error : %s" ,$stmt->error);
       
        return false;
    }

    public function delete(){
        $sql = "Delete from $this->table Where n_category_id = :id" ;
        
        $stmt = $this->conn->prepare($sql);
        $this->n_category_id = htmlspecialchars(strip_tags($this->n_category_id));
        $stmt->bindParam(':id',$this->n_category_id);
        $stmt->execute();

        if($stmt->execute()){
            return true ; 
        }
        printf("Error : %s" , $stmt->error);
        
        return false;
    }

}
?>