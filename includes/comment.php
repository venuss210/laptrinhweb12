<?php
class blogs_comment{

    private $conn ; 
    private $table = "blog_comment"; 

    public $n_blog_comment_id ; 
    public $n_blog_comment_parent_id; 
    public $n_blog_post_id; 
    public $v_comment_author; 
    public $v_comment_author_email; 
    public $v_comment;  
    public $d_date_created; 
    public $d_time_created; 
  

    public function __construct($db)
    {
        $this->conn = $db ;
    }

    public function read_single(){
        $sql = "Select * from $this->table where n_blog_comment_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id',$this->n_blog_comment_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->n_blog_comment_id = $row['n_blog_comment_id']; 
        $this->n_blog_comment_parent_id = $row['n_blog_comment_parent_id']; 
        $this->n_blog_post_id = $row['n_blog_post_id']; 
        $this->v_comment_author = $row['v_comment_author']; 
        $this->v_comment_author_email = $row['v_comment_author_email']; 
        $this->v_comment = $row['v_comment']; 
        $this->d_date_created = $row['d_date_created'];  
        $this->d_time_created = $row['d_time_created']; 
           
    }

    public function read(){
        $sql = "Select * from $this->table";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt ; 
    }

    public function delete(){
        $sql = "Delete from $this->table Where n_blog_comment_id = :id" ;
        
        $stmt = $this->conn->prepare($sql);

        $this->n_blog_comment_id = htmlspecialchars(strip_tags($this->n_blog_comment_id));

        $stmt->bindParam(':id',$this->n_blog_comment_id);
        $stmt->execute();

        if($stmt->execute()){
            return true ; 
        }
        printf("Error : %s" , $stmt->error);
        
        return false;
    }
}
