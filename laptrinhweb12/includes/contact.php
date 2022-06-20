<?php
class blogs_contact{

    private $conn ; 
    private $table = "blog_contact"; 

    public $n_contact_id ; 
    public $v_fullname; 
    public $v_email; 
    public $v_phone	; 
    public $v_message; 
    public $d_date_created;  
    public $d_time_created; 
    public $f_contact_status; 
  

    public function __construct($db)
    {
        $this->conn = $db ;
    }

    public function read_single(){
        $sql = "Select * from $this->table where n_contact_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id',$this->n_contact_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->n_contact_id = $row['n_contact_id']; 
        $this->v_fullname = $row['v_fullname']; 
        $this->v_email = $row['v_email']; 
        $this->v_phone = $row['v_phone']; 
        $this->v_message = $row['v_message']; 
        $this->d_date_created = $row['d_date_created'];  
        $this->d_time_created = $row['d_time_created']; 
        $this->f_contact_status = $row['f_contact_status']; 
       
    }

    public function read(){
        $sql = "Select * from $this->table";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt ; 
    }

    public function delete(){
        $sql = "Delete from $this->table Where n_contact_id = :id" ;
        
        $stmt = $this->conn->prepare($sql);

        $this->n_contact_id = htmlspecialchars(strip_tags($this->n_contact_id));

        $stmt->bindParam(':id',$this->n_contact_id);
        $stmt->execute();

        if($stmt->execute()){
            return true ; 
        }
        printf("Error : %s" , $stmt->error);
        
        return false;
    }
}
