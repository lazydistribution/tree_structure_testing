<?php


class PostService extends Service 
{
    public function index() {

        $posts = $this->Post->all();
        
        $output = [];
        $topic_id = null;
        $index = -1;
        foreach($posts->data() as $key => $row) {
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
        return $output;
    }
}