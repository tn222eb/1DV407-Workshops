<?php

abstract class Repository {

	protected $dbUsername = "root";
	protected $dbPassword = "";
	protected $dbConnectionString = "mysql:host=127.0.0.1;dbname=198897-workshop";
	protected $dbConnection;
    protected $dbTable;

    protected function connection() {
    	if($this->dbConnection == null) {
            $this->dbConnection = new \PDO($this->dbConnectionString, $this->dbUsername, $this->dbPassword);
        
        $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $this->dbConnection;
    }
  }
}