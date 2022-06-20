<?php
class blogs_subs{

    private $conn ; 
    private $table = "blog_subscriber"; 

    public $n_sub_id  ; 
    public $v_sub_email; 
    public $d_date_created; 
    public $d_time_created	; 
    public $f_sub_status; 
  

    public function __construct($db)
    {
        $this->conn = $db ;
    }

    public function read_single(){
        $sql = "Select * from $this->table where n_sub_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id',$this->n_sub_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->n_sub_id = $row['n_sub_id']; 
        $this->v_sub_email = $row['v_sub_email']; 
        $this->d_date_created = $row['d_date_created'];  
        $this->d_time_created = $row['d_time_created']; 
        $this->f_sub_status = $row['f_sub_status']; 
       
    }

    public function read(){
        $sql = "Select * from $this->table";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt ; 
    }

    public function delete(){
        $sql = "Delete from $this->table Where n_sub_id = :id" ;
        
        $stmt = $this->conn->prepare($sql);

        $this->n_sub_id = htmlspecialchars(strip_tags($this->n_sub_id));

        $stmt->bindParam(':id',$this->n_sub_id);
        $stmt->execute();

        if($stmt->execute()){
            return true ; 
        }
        printf("Error : %s" , $stmt->error);
        
        return false;
    }
}
