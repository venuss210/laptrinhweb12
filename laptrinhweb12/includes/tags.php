<?php
class tags{

    private $conn ; 
    private $table = "blog_tags"; 

    public $n_tag_id; 
    public $n_blog_post_id; 
    public $v_tag; 
    
    public function __construct($db)
    {
        $this->conn = $db ;
    }

    public function read_single(){
        $sql = "Select * from $this->table where n_blog_post_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id',$this->n_blog_post_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row < 1){
            return ;
        }
        $this->n_tag_id = $row['n_tag_id']; 
        $this->n_blog_post_id = $row['n_blog_post_id']; 
        $this->v_tag = $row['v_tag']; 
        
    }

    public function read(){
        $sql = "Select * from $this->table";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt ; 
    }

    public function create(){
        $sql = "insert into $this->table set 
        n_blog_post_id = :id , 
        v_tag = :tag ";

        $stmt = $this->conn->prepare($sql) ;

        $this->v_tag = htmlspecialchars(strip_tags($this->v_tag));

        $stmt->bindParam(':id' , $this->n_blog_post_id); 
        $stmt->bindParam(':tag' , $this->v_tag); 
        
        if($stmt->execute()){
            return true ;
        }
        printf("Error: %s", $stmt->error);
        
        return false ;
    }

    public function update(){
        $sql = "Update $this->table
    SET 
        v_tag = :tag, 
    WHERE   
        n_tag_id = :tag_id "; 

        $stmt = $this->conn->prepare($sql); 

        $this->v_tag = htmlspecialchars(strip_tags($this->v_tag));

        $stmt->bindParam(':tag',$this->v_tag);
        $stmt->bindParam(':tag_id',$this->n_tag_id);
    
        if($stmt->execute()){
            return true; 
        }
        printf("Error : %s" ,$stmt->error);
       
        return false;
    }

    public function delete(){
        $sql = "Delete from $this->table Where n_tag_id = :id" ;
        
        $stmt = $this->conn->prepare($sql);

        $this->v_tag = htmlspecialchars(strip_tags($this->n_tag_id));

        $stmt->bindParam(':id',$this->n_tag_id);
        $stmt->execute();

        if($stmt->execute()){
            return true ; 
        }
        printf("Error : %s" , $stmt->error);
        
        return false;
    }

}
?>