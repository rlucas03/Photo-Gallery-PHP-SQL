<?php 
// my one
class connection {

	private $config = array();
	private $link;
	private $result;

	// a construxtor that takes the config array as an argument

	public function __construct($dbconfig) {
		$this->config = $dbconfig; 
	}

	public function connect() {
		$this->link = mysqli_connect(
		$this->config['db_host'],
		$this->config['db_user'],
		$this->config['db_pass'],
		$this->config['db_name']
		);

		if (mysqli_connect_errno()) {
			throw new mysqli_sql_exception((new Message())->getDbError()); 
		}
	return $this->link; 
	} 

	// this below disconections from the db
	public function disconnect() {
		mysqli_close($this->link);
	}
?>