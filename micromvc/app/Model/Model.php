<?php


class Model 
{
    protected $request;
    
    public function __construct($request = null) {
        $this->request = $request;
        $model_name = str_replace('Model', 's', get_class($this));
        $this->table_name = strtolower($model_name);
    }

    public function get($id, $params = []) {
        $conn = Connection::get();
		
        if(isset($params['fields']) && !empty($params['fields'])) {
            $fields = $params['fields'];
        } else {
            $fields = ['*'];
        }
        $sql = "SELECT " . join(', ', $fields) . " FROM {$this->table_name} WHERE id = :id";
		$sth = $conn->prepare($sql);
		$sth->prepare(':id', $id, PDO::PARAM_INT);
        $res = $sth->execute();
        $results = [];
        foreach($res as $row) {
			$results[] = $row;
		}
        
        return new Collection($results);
    }

    public function all() {
        $conn = Connection::get();
        
        $start_sql_time = microtime(true);
        
        $sql = "SELECT * FROM {$this->table_name}";
        $res = $conn->query($sql, PDO::FETCH_ASSOC);
        
        $end_sql_time = microtime(true);
        
        $results = [];
        $index = 0;
        foreach($res as $row) {
			$results[] = $row;
            $index++;
		}
        $output = ['rows' => $index, 'sql_time' => ($end_sql_time - $start_sql_time), 'response' => $results];
        return new Collection($output);
    }

    public static function init($model_name) {
        return new ($model_name . 'Model')();
    }
}