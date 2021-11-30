<?php


class Connection {
	public static $host = 'localhost';
	public static $name = 'skepsis_test_1';
	public static $user = 'root';
	public static $pass = '';
	
	public static function get() {
		
		try {
			$dbh = new PDO("mysql:host=".self::$host.";dbname=".self::$name, self::$user, self::$pass);
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		return $dbh;
	}

	public static function autoincrement($table_name) {
		$conn = self::get();
		$sql = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".self::$name."' AND TABLE_NAME = '{$table_name}';";
		
		foreach($conn->query($sql) as $row) {
			return $row['AUTO_INCREMENT'];
		}
	}	
}