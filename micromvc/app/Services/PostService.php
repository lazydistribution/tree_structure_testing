<?php


class PostService extends Service 
{
    public function index() {
        //$this->loadModel('User');

        $posts = $this->Post->all();
        $content = new Collection($posts->fields(['fields' => 'response']));
        
        $sql_time = $posts->fields(['fields' => 'sql_time']);
        $rows = $posts->fields(['fields' => 'rows']);
        $output = [];
        $topic_id = null;
        $index = -1;
        foreach(current($content->data()) as $key => $row) {
            //tapa($row);
            if($topic_id != $row['topic_id']) {
                $topic_id = $row['topic_id'];
                $output[] = [];
                $index++;
            }
            $tmp = array_merge([
                'template' => 'template-post',
            ], $row);

            $tmp['body_text'] = '<article class="message">' . BBCode::decode($tmp['body_text']) . '</article>';
            $output[$index][] = $tmp;
        }
        //tapa($output);
        return array_merge($sql_time, $rows, ['response' => $output]);
    }
}