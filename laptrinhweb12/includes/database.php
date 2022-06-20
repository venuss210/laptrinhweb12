<?php
class database
{
    private $dns = "mysql:host=bftxcgyr6qvwl54q2myj-mysql.services.clever-cloud.com;dbname=bftxcgyr6qvwl54q2myj";
    private $user = "uwv0stnobifop2x2";
    private $pass = "uIipHWQ869klIsuMCme4";
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO($this->dns, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            echo "Connect failed" . $e->getMessage();
        }
        return $this->conn;
    }
}


?>