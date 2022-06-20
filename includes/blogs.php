<?php
class blogs{

    private $conn ; 
    private $table = "blog_post"; 

    public $n_blog_post_id; 
    public $n_category_id; 
    public $v_post_title; 
    public $v_post_meta_title; 
    public $v_post_path; 
    public $v_post_summary;  
    public $v_post_content; 
    public $v_main_image_url; 
    public $v_alt_image_url; 
    public $n_blog_post_views; 
    public $n_home_page_place; 
    public $f_post_status; 
    public $d_date_created; 
    public $d_time_created; 
    public $d_date_updated; 
    public $d_time_updated; 

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

        $this->n_blog_post_id = $row['n_blog_post_id']; 
        $this->n_category_id = $row['n_category_id']; 
        $this->v_post_title = $row['v_post_title']; 
        $this->v_post_meta_title = $row['v_post_meta_title']; 
        $this->v_post_path = $row['v_post_path']; 
        $this->v_post_summary = $row['v_post_summary'];  
        $this->v_post_content = $row['v_post_content']; 
        $this->v_main_image_url = $row['v_main_image_url']; 
        $this->v_alt_image_url = $row['v_alt_image_url']; 
        $this->n_blog_post_views = $row['n_blog_post_views']; 
        $this->n_home_page_place = $row['n_home_page_place']; 
        $this->f_post_status = $row['f_post_status']; 
        $this->d_date_created = $row['d_date_created']; 
        $this->d_time_created = $row['d_time_created']; 
        $this->d_date_updated = $row['d_date_updated']; 
        $this->d_time_updated = $row['d_time_updated'];
    }

    public function read(){
        $sql = "Select * from $this->table";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt ; 
    }

    public function create(){
        $sql = "insert into $this->table set 
        n_category_id = :c_id,
        v_post_title = :title, 
        v_post_meta_title = :meta, 
        v_post_path = :path,
        v_post_summary = :summary,
        v_post_content = :content,
        v_main_image_url = :m_img,
        v_alt_image_url = :img,
        n_blog_post_views = :view,
        n_home_page_place = :place,
        f_post_status = :status,
        d_date_created = :d_cre,
        d_time_created = :t_cre";

        $stmt = $this->conn->prepare($sql) ;

        $this->v_post_title = htmlspecialchars(strip_tags($this->v_post_title));
		$this->v_post_meta_title = htmlspecialchars(strip_tags($this->v_post_meta_title));
		$this->v_post_summary = htmlspecialchars(strip_tags($this->v_post_summary));
		$this->v_post_content = htmlspecialchars(strip_tags($this->v_post_content));
		$this->v_post_path = htmlspecialchars(strip_tags($this->v_post_path));

        $stmt->bindParam(':c_id',$this->n_category_id);
        $stmt->bindParam(':title',$this->v_post_title);
        $stmt->bindParam(':meta',$this->v_post_meta_title);
        $stmt->bindParam(':path',$this->v_post_path);
        $stmt->bindParam(':summary',$this->v_post_summary);
        $stmt->bindParam(':content',$this->v_post_content);
        $stmt->bindParam(':m_img',$this->v_main_image_url);
        $stmt->bindParam(':img',$this->v_alt_image_url);
        $stmt->bindParam(':view',$this->n_blog_post_views);
        $stmt->bindParam(':place',$this->n_home_page_place);
        $stmt->bindParam(':status',$this->f_post_status);
        $stmt->bindParam(':d_cre',$this->d_date_created);
        $stmt->bindParam(':t_cre',$this->d_time_created);

        
        if($stmt->execute()){
            return true ;
        }
        printf("Error: %s", $stmt->error);
        
        return false ;
    }

    public function update(){
        $sql = "Update $this->table 
    SET 
        n_category_id = :c_id , 
        v_post_title = :title , 
        v_post_meta_title = :meta , 
        v_post_path = :path , 
        v_post_summary = :summary ,  
        v_post_content = :content , 
        v_main_image_url = :m_img , 
        v_alt_image_url = :img , 
        n_blog_post_views = :view , 
        n_home_page_place = :place , 
        f_post_status = :status , 
        d_date_created = :d_cre , 
        d_time_created = :t_cre , 
        d_date_updated = :d_up,
        d_time_updated = :t_up 
    WHERE
        n_blog_post_id = :b_id "; 

        $stmt = $this->conn->prepare($sql); 

        $this->v_post_title = htmlspecialchars(strip_tags($this->v_post_title));
		$this->v_post_meta_title = htmlspecialchars(strip_tags($this->v_post_meta_title));
		$this->v_post_path = htmlspecialchars(strip_tags($this->v_post_path));
        $this->v_post_summary = htmlspecialchars(strip_tags($this->v_post_summary));
		$this->v_post_content = htmlspecialchars(strip_tags($this->v_post_content));
		$this->v_main_image_url = htmlspecialchars(strip_tags($this->v_main_image_url));
		$this->v_alt_image_url = htmlspecialchars(strip_tags($this->v_alt_image_url));


        $stmt->bindParam(':b_id',$this->n_blog_post_id);
        $stmt->bindParam(':c_id',$this->n_category_id);
        $stmt->bindParam(':title',$this->v_post_title);
        $stmt->bindParam(':meta',$this->v_post_meta_title);
        $stmt->bindParam(':path',$this->v_post_path);
        $stmt->bindParam(':summary',$this->v_post_summary);
        $stmt->bindParam(':content',$this->v_post_content);
        $stmt->bindParam(':m_img',$this->v_main_image_url);
        $stmt->bindParam(':img',$this->v_alt_image_url);
        $stmt->bindParam(':view',$this->n_blog_post_views);
        $stmt->bindParam(':place',$this->n_home_page_place);
        $stmt->bindParam(':status',$this->f_post_status);
        $stmt->bindParam(':d_cre',$this->d_date_created);
        $stmt->bindParam(':t_cre',$this->d_time_created);
        $stmt->bindParam(':d_up',$this->d_date_updated);
        $stmt->bindParam(':t_up',$this->d_time_updated);
    
        if($stmt->execute()){
            return true; 
        }
        printf("Error : %s" ,$stmt->error);
       
        return false;
    }

    public function delete(){
        $sql = "Delete from $this->table Where n_blog_post_id = :id" ;
        
        $stmt = $this->conn->prepare($sql);

        $this->n_blog_post_id = htmlspecialchars(strip_tags($this->n_blog_post_id));

        $stmt->bindParam(':id',$this->n_blog_post_id);
        $stmt->execute();

        if($stmt->execute()){
            return true ; 
        }
        printf("Error : %s" , $stmt->error);
        
        return false;
    }

    public function last_id(){
        $sql = "select MAX(n_blog_post_id) from $this->table" ;
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        if($stmt->execute()){
            
            return $stmt; 
        }
        printf("Error : %s" , $stmt->error);
        
        return false;
    }
}
