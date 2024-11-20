<?php



class ResultController {    
    public $result;

    public function __construct() {
        $this->result = new Result();
    }

    public function view_result()
    {
 
        $search = $_GET['search'] ?? ''; 
    
       
        if ($search) {
            $results = $this->result->search_products($search); 
        } else {
            $results = $this->result->get_result(); 
        }
    

        require_once './clients/views/result.php';
    }


}

?>