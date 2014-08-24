<?php
class Database {
    private static $_instance = null;

    private function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=dbName', 'dbuser', 'dbpass');            
    }
    
    
    public static function getInstance() {
        if (!$this->_instance) {
            $this->_instance = new PDO('mysql:host=localhost;dbname=dbName', 'dbuser', 'dbpass');
        }
        return $this->_instance;
    }
    
    
    
    public function select($table, $criteria=array(), $order='', $limit='') {
        
    }
    
    public function update($table, $criteria = array(), $data = array()) {
        
    }
    
    public function insert($table, $data = array()) {
        
    }
    
    public function delete($table, $criteria = array()) {
        
    }
    
}

