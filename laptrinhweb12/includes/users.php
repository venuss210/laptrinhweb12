<?php
class user{

    private $conn ; 
    private $table = "blog_user"; 

    public $n_user_id; 
    public $v_username; 
    public $v_password; 
    public $v_fullname; 
    public $v_phone; 
    public $v_email;  
    public $v_image; 
    public $v_message; 
    public $d_date_updated; 
    public $d_time_updated; 
 

    public function __construct($db)
    {
        $this->conn = $db ;
    }

    public function read_single(){
        $sql = "Select * from $this->table where n_user_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id',$this->n_user_id);
        $stmt->execute();

        return $stmt ;
    }

    public function create(){
        $sql = "insert into $this->table set 
        v_username = :username, 
        v_password = :password, 
        v_fullname = :fullname,
        v_phone = :phone,
        v_email = :email,
        v_image = :image,
        v_message = :message,
        d_date_updated = :date,
        d_time_updated = :time";

        $stmt = $this->conn->prepare($sql) ;
        
        $this->v_username = htmlspecialchars(strip_tags($this->v_username));
        $this->v_password = htmlspecialchars(strip_tags($this->v_password));
        $this->v_fullname = htmlspecialchars(strip_tags($this->v_fullname));
        $this->v_phone = htmlspecialchars(strip_tags($this->v_phone));
        $this->v_email = htmlspecialchars(strip_tags($this->v_email));
        $this->v_message = htmlspecialchars(strip_tags($this->v_message));

        $stmt->bindParam(':username' , $this->v_username); 
        $stmt->bindParam(':password' , $this->v_password); 
        $stmt->bindParam(':fullname' , $this->v_fullname); 
        $stmt->bindParam(':phone' , $this->v_phone); 
        $stmt->bindParam(':email' , $this->v_email); 
        $stmt->bindParam(':image' , $this->v_image); 
        $stmt->bindParam(':message' , $this->v_message); 
        $stmt->bindParam(':date' , $this->d_date_updated); 
        $stmt->bindParam(':time' , $this->d_time_updated);
        
        if($stmt->execute()){
            return true ;
        }
        printf("Error: %s", $stmt->error);
        
        return false ;
    }

    public function update(){
        $sql = "Update $this->table 
    SET 
        v_username = :user , 
        v_password = :pass , 
        v_fullname = :fullname , 
        v_phone = :phone , 
        v_email = :email ,  
        v_image = :image , 
        v_message = :message , 
        d_date_updated = :d_up , 
        d_time_updated = :t_up  
    WHERE
        n_user_id = :id "; 

        $stmt = $this->conn->prepare($sql); 

        $this->v_username = htmlspecialchars(strip_tags($this->v_username));
        $this->v_password = htmlspecialchars(strip_tags($this->v_password));
        $this->v_fullname = htmlspecialchars(strip_tags($this->v_fullname));
        $this->v_phone = htmlspecialchars(strip_tags($this->v_phone));
        $this->v_email = htmlspecialchars(strip_tags($this->v_email));
        $this->v_message = htmlspecialchars(strip_tags($this->v_message));

        $stmt->bindParam(':id',$this->n_user_id);
        $stmt->bindParam(':user',$this->v_username);
        $stmt->bindParam(':pass',$this->v_password);
        $stmt->bindParam(':fullname',$this->v_fullname);
        $stmt->bindParam(':phone',$this->v_phone);
        $stmt->bindParam(':email',$this->v_email);
        $stmt->bindParam(':image',$this->v_image);
        $stmt->bindParam(':message',$this->v_message);
        $stmt->bindParam(':d_up',$this->d_date_updated);
        $stmt->bindParam(':t_up',$this->d_time_updated);

    
        if($stmt->execute()){
            return true; 
        }
        printf("Error : %s" ,$stmt->error);
       
        return false;
    }

    public function delete(){
        $sql = "Delete from $this->table Where n_user_id = :id" ;
        
        $stmt = $this->conn->prepare($sql);

        $this->n_user_id = htmlspecialchars(strip_tags($this->n_user_id));

        $stmt->bindParam(':id',$this->n_user_id);
        $stmt->execute();

        if($stmt->execute()){
            return true ; 
        }
        printf("Error : %s" , $stmt->error);
        
        return false;
    }
    
    //check login from database
    public function login(){
        $sql = "SELECT * FROM $this->table 
                WHERE v_email =:email 
                AND v_password =:password";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email',$this->v_email);
        $stmt->bindParam(':password',$this->v_password);
        $stmt->execute();
        
        return $stmt;
    }
}
