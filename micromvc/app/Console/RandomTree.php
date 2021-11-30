<?php

$faker = Faker\Factory::create('fi_FI');


/**
 * usage:
 * 
 * ADD posts in 10 trheads witn random number of posts where maximum number of posts in thread is 20
 * ..\app\Console> php shell RandomTree add 10 20
 * 
 * TRUNCATE and ADD posts in 10 trheads witn random number of posts where maximum number of posts in thread is 20
 * ..\app\Console> php shell RandomTree refresh 10 20
 * 
 * CLEAR posts
 * ..\app\Console> php shell RandomTree clear
 * 
 */

class RandomTree extends Shell
{
    public function main($args) {
        print_r($args);
        $method = $args[0];
        $params = [...$args];
        unset($params[0]);
        $this->$method(...$params);
    }

    public function add($threads = 1, $postsMax = 1) {
        $data = $this->createData($threads, $postsMax);
        $queries = $this->array2MySQLArray($data);
        $conn = Connection::get();
        foreach($queries as $sql) {
            $conn->query($sql);
        }
    }

    public function refresh($threads = 1, $postsMax = 1) {
        $this->clear();
        $this->add($threads, $postsMax);
    }

    public function clear($caller_data = []) {
        $conn = Connection::get();
	    $sql = 'TRUNCATE TABLE posts';
	    $conn->query($sql);
    }

    public function array2MySQLArray($data){
        $queries = [];
        foreach($data as $topic) {
            $sql = "INSERT INTO posts (" . join(', ', array_keys($topic[0])) . ") VALUES ";
            $index = 0;
            foreach($topic as $row) {
                $sql .= ($index++ > 0 ? ",\n" : "\n");
                $values = array_values($row);
                $sql .= "(";
                $jindex = 0;
                foreach($values as $value) {
                    $sql .= ($jindex++ > 0 ? ',':'');
                    if(is_int($value)) {
                        $sql .= $value;
                    } elseif($value == null) {
                        $sql .= 'NULL';
                    } else {
                        $sql .= "'". $value . "'";
                    }
                }
                $sql .= ')';
            }
            $queries[] = $sql;
        }
        return $queries;
    }

    public function createData($trees = 5, $postsMax = 1) {
        $faker = Faker\Factory::create('fi_FI');
        $topic_raw_text = $faker->word();
        $topic_text = ucfirst(strtolower(alphanumerical($topic_raw_text)));
    
        $threads = [];
        $offset = Connection::autoincrement('posts') - 1;
        for($i = 1; $i <= $trees; $i++) {
            $posts = rand(1, $postsMax);
            $threads[] = (new Tree($i, $topic_text, $posts, $offset, 20))->gen();
            $offset += $posts;
        }
        return $threads;
    }

}

class user
{
    public static $_list = [];

    public static function add($count = 1, $refresh = false) {
        if(empty(self::$_list) || $refresh) {
            self::$_list = [];
            $faker = Faker\Factory::create('fi_FI');
            $user_name = $faker->username();
            for($i = 0; $i < $count; $i++) {
                self::$_list[] = [
                    'id' => $i + 1,
                    'username' => strtolower($faker->firstname()) . str_replace(['.', ' '], ['',''], $faker->buildingNumber),
                    'listing_pattern_id' => rand(1,2),
                ];
            }
        }
    }

    public static function random($count = 1) {
        $output = [];
        for($i = 0; $i < $count; $i++) {
            $output[] = self::$_list[array_rand(self::$_list)];
        }
        return count($output) == 1 ? $output[0] : $output;
    }

    public static function get($id) {
        foreach(self::$_list as $user) {
            if($user['id'] == $id) return $user;
        }
        return null;
    }

    public static function all($id) {
        return self::$_list;
    }
}

class Tree
{
    public $faker;

    public function __construct($topic_id, $topic_text, $posts, $id_offset, $users) {
		$this->topic_id = $topic_id;
		$this->topic_text = $topic_text;
		$this->posts = $posts;
		$this->id_offset = $id_offset;
        $this->faker = Faker\Factory::create('fi_FI');
        User::add($users);
	}
	
	public function gen() {		
		return $this->topic($this->topic_id, $this->topic_text, $this->posts, $this->id_offset);
	}
	
	public function topic($topic_id, $topic_text, $posts, $id_offset) {
		$times = [];
		for($i = 0; $i < $posts; $i++) {
			$start_timestamp = strtotime('2020-01-01 00:00:00'); 
			$end_timestamp = strtotime('2021-11-28 00:00:00');
			$current = rand($start_timestamp, $end_timestamp);
			$times[] = date('Y-m-d H:i:s', $current);
		}
		sort($times);
		$output = [];
		$pool = [];
        
		$headline_raw_text = $this->faker->realText($maxNbChars = 40);
        $headline_text = ucfirst(strtolower(alphanumerical($headline_raw_text)));
		
		$endfixes = '';
		$mark = (bool)rand(0,1) ? '?' : '!';
		for($i = 0; $i < 3; $i++) {
			$endfixes .= (in_array(rand(0, 6), [1, 2]) ? $mark : '');
		}
		$headline_text = $headline_text . $endfixes;
        
        for($i = 0; $i < $posts; $i++) {
			$body_text = str_replace("'", '', $this->faker->realText($maxNbChars = 200));
            $user = User::random();

			$id = $i + 1 + $id_offset;
			$parent_id = $id == (1 + $id_offset) ? null : $pool[array_rand($pool)];
			$pool[] = $id;
			$obj = [
				'id' => $id,
				'parent_id' => $parent_id,
				'created' => $times[$i],
				'modified' => null,
				'user_id' => $user['id'],
				'topic_id' => $topic_id,
				'headline_text' => $headline_text,
				'body_text' => $body_text,
			];
			$output[] = $obj;
		}
		return $output;
	}
}

