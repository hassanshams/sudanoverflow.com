<?php
class Question_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
    }
    public function get_tags($tag){
        $sql=("SELECT name FROM tags WHERE name='$tag'");
        return $this->db->query($sql)->result();
    }
    public function all_tags(){
        $sql=("SELECT * FROM tags");
        return $this->db->query($sql)->result();
    }
    public function tag_questions(){
        $sql=("SELECT tags FROM questions");
        return $this->db->query($sql)->result();
    }
    public function tag_answers(){
        $sql=("SELECT tags FROM answers");
        return $this->db->query($sql)->result();
    }
    public function questions_for_tag($tag){
        $sql=("SELECT * FROM questions where tags like '%$tag%' ");
        return $this->db->query($sql)->result();
    }
    public function add_question($data){
        $title=$data[0];
        $tags=$data[1];
        $tags=implode(",",$tags);
        $content=$data[2];
        $user=$this->session->userdata('user');
        $user_id=$this->session->userdata('user_id');
        $username=$this->session->userdata('username');
        $sql=("insert into questions(title,tags,body,asker,asker_id,asker_username) values('$title','$tags','$content','$user','$user_id','$username')");
        if($this->db->query($sql)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    public function get_question($id){
        $sql=("SELECT * FROM questions WHERE id='$id' ");
        return $this->db->query($sql)->row();
    }
    public function get_answers_count($answer_id){
        $sql=("SELECT * FROM answers WHERE question_id=$answer_id");
        return $this->db->query($sql)->num_rows();
    }
    public function get_question_views($id){
        $sql=("UPDATE questions SET views=(views+1) WHERE id='$id'");
        $this->db->query($sql);
        $sql=("SELECT views FROM questions WHERE id='$id'");
        return $this->db->query($sql)->result();
    }   
    public function get_tag($tag){
        $sql=("SELECT * FROM tags WHERE name='$tag' ");
        return $this->db->query($sql)->row();
    } 
    public function get_comment($id){
        $sql=("SELECT * FROM comments WHERE question_id='$id' ");
        return $this->db->query($sql)->result();
    }    
    public function get_answer_comments($question_id){
        $sql=("SELECT * FROM answers_comments WHERE question_id='$question_id' ");
        return $this->db->query($sql)->result();
    }
    public function get_recent_questions(){
        $sql=('SELECT * FROM questions');
        return $this->db->query($sql)->result();
    }    
    public function get_recent_questions_for_tag($tag){
        $sql = ("SELECT * FROM questions where tags like '%$tag%' order by at ASC");
        return $this->db->query($sql)->result();
    }    
    public function get_most_votes_questions(){
        $sql=('SELECT * FROM questions ORDER BY votes');
        return $this->db->query($sql)->result();
    }
    public function get_most_votes_questions_for_tag($tag){
        $sql=("SELECT * FROM questions where tags like '%$tag%' ORDER BY votes DESC");
        return $this->db->query($sql)->result();
    }
    public function get_most_answers_questions(){
        $sql=('SELECT * FROM questions ORDER BY answers');
        return $this->db->query($sql)->result();
    }
    public function get_most_answers_questions_for_tag($tag){
        $sql=("SELECT * FROM questions where tags like '%$tag%' ORDER BY answers DESC");
        return $this->db->query($sql)->result();
    }
    public function get_not_answered_questions(){
        $sql=('SELECT * FROM questions where answers="0" order by at');
        return $this->db->query($sql)->result();
    }
    public function get_not_answered_questions_for_tag($tag){
        $sql=("SELECT * FROM questions where answers='0' and tags like '%$tag%' order by at ASC");
        return $this->db->query($sql)->result();
    }
    public function searched_recent_questions($text){
        $sql=("select * from questions where title like '%$text%' order by at ASC");
        return $this->db->query($sql)->result();
    }
    public function searched_most_votes_questions($text){
        $sql=("select * from questions where title like '%$text%' order by votes DESC");
        return $this->db->query($sql)->result();
    }
    public function searched_most_answers_questions($text){
        $sql=("select * from questions where title like '%$text%' order by answers DESC");
        return $this->db->query($sql)->result();
    }
    public function searched_not_answered_questions($text){
        $sql=("select * from questions where title like '%$text%' and answers='0' order by at ASC");
        return $this->db->query($sql)->result();
    }
    public function add_comment($data){
        $q_id=$data[0];
        $comment=$data[1];
        $q_owner=$data[2];
        $user=$this->session->userdata('user');
        $username=$this->session->userdata('username');
        $user_id=$this->session->userdata('user_id');
        $sql=("INSERT INTO comments(question_id,comment,commentor,commentor_username,commentor_id) VALUES('$q_id','$comment','$user','$username','$user_id')");
        if($this->db->query($sql)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    public function add_answer_comment($data){
        $q_id=$data[0];
        $comment=$data[1];
        $answer_id=$data[2];
        $a_owner=$data[3];
        $q_owner=$data[4];
        $user=$this->session->userdata('user');
        $username=$this->session->userdata('username');
        $user_id=$this->session->userdata('user_id');
        $sql=("INSERT INTO answers_comments(question_id,comment,commentor,answer_id,commentor_username,commentor_id) VALUES('$q_id','$comment','$user','$answer_id','$username','$user_id')");
        if($this->db->query($sql) == true){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    public function load_votes($q_id){
        $sql=("SELECT votes FROM questions WHERE id='$q_id'");
        return $query=$this->db->query($sql)->row();
    }
    public function has_voted($q_id){
        $user=$this->session->userdata('user');
        $sql=("SELECT voter FROM votes WHERE question_id='$q_id' and voter='$user'");
        $query=$this->db->query($sql);
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function add_vote($data){
        $q_owner = $data[2];
        $link = $data[0]*62488426;
        $section = $data[0];
        $q_id = $data[0];
        $vote=$data[1];
        $user=$this->session->userdata('user');
        $sql1=("UPDATE questions SET votes=(votes+'$vote') WHERE id='$q_id' ");
        $sql2=("INSERT INTO votes(question_id,voter,down_up) VALUES('$q_id','$user','$vote')");
        $sql3=("INSERT INTO points(count,user,type_,question_id) VALUES(5,'$user','vote_q','$q_id')");
        $sql4=("INSERT INTO points(count,user,type_,question_id) VALUES(5,'$q_owner','vote_own_q','$q_id')");
        $this->db->trans_Start();
        $this->db->query($sql1);
        $this->db->query($sql2);
        $id = $this->db->insert_id();
        $this->db->query($sql3);
        $this->db->query($sql4);
        $this->db->trans_Complete();
        if($this->db->trans_Status() === FALSE){
            $this->db->transRollback();
            return false;
        }else{
            return $id;
        }
    }
    public function check_q_owner($q_id){
        $user = $this->session->userdata('user');
        $sql=("SELECT asker FROM questions WHERE asker='$user' AND id='$q_id'");
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return true;
        }else{return false;}
    }   
    public function delete_question($q_id){
        $user = $this->session->userdata('user');
        $sql=("DELETE FROM questions WHERE id='$q_id' ");
        $sql2=("DELETE FROM answers WHERE question_id='$q_id'");
        $sql3=("DELETE FROM votes WHERE question_id='$q_id'");
        $sql4=("DELETE FROM comments WHERE question_id='$q_id'");
        $sql5=("DELETE FROM answer_votes WHERE question_id='$q_id'");
        $sql6=("DELETE FROM answers_comments WHERE question_id='$q_id'");
        $sql7=("UPDATE users SET points=(points-5) WHERE email='$user'");
        // $sql8=("DELETE FROM points WHERE question_id='$q_id'");
        $sql8=("DELETE FROM notifications WHERE question_id='$q_id'");
        $this->db->trans_Start();
        $this->db->query($sql);
        $this->db->query($sql2);
        $this->db->query($sql3);
        $this->db->query($sql4);
        $this->db->query($sql5);
        $this->db->query($sql6);
        $this->db->query($sql7);
        $this->db->query($sql8);
        // $this->db->query($sql9);
        $this->db->trans_Complete();
        if($this->db->trans_Status() === FALSE){
            $this->db->transRollback();
            return false;
        }else{
            return true;
        }
    }
    public function delete_comment($comment_id,$q_id){
        $sql1=("DELETE FROM comments WHERE id='$comment_id' ");
        $sql2=("DELETE FROM notifications WHERE question_id='$q_id' and type='commented' ");
        $this->db->query($sql1);
        $this->db->query($sql2);
        $this->db->trans_Complete();
        if($this->db->trans_Status() === FALSE){
            $this->db->transRollback();
            return false;
        }else{
        return true;
        }
    }
    public function delete_answer($data){
        $answer_id=$data[0];
        $q_id=$data[1];
        $sql=("DELETE FROM answers WHERE id='$answer_id'");
        $sql2=("UPDATE questions SET answers=(answers-1) WHERE id='$q_id'");
        $sql3=("DELETE FROM answer_votes WHERE question_id='$q_id'");
        $sql4=("DELETE FROM answers_comments WHERE question_id='$q_id'");
        $sql5=("DELETE FROM notifications WHERE answer_id='$answer_id' ");
        $this->db->trans_Start();
        $this->db->query($sql);
        $this->db->query($sql2);
        $this->db->query($sql3);
        $this->db->query($sql4);
        $this->db->query($sql5);
        $this->db->trans_Complete();
        if($this->db->trans_Status() === FALSE){
            $this->db->transRollback();
            return false;
        }else{
            return true;
        }
    }    
    public function delete_answer_comment($data){
        $answer_id=$data[0];
        $comment_id=$data[1];
        $sql1=("DELETE FROM answers_comments WHERE id='$comment_id' AND answer_id='$answer_id'");
        $sql2=("DELETE FROM notifications WHERE delete_id='$comment_id' AND answer_id='$answer_id' and type='answer_commented'");
        $this->db->query($sql1);
        $this->db->query($sql2);
        $this->db->trans_Complete();
        if($this->db->trans_Status() === FALSE){
            $this->db->transRollback();
            return false;
        }else{
            return true;
        }
    }
    public function get_pre_edit_question($id){
        $sql=("SELECT body,tags,title FROM questions WHERE id='$id' ");
        return $this->db->query($sql)->row();
    } 
        public function add_edited_question($data){
        $title=$data[0];
        $tags=$data[1];
        $tags=implode(" ",$tags);
        $content=$data[2];
        $q_id=$data[3];
        $data=array('title'=>$title,'tags'=>$tags,'body'=>$content);
        $this->db->update('questions',$data,array('id'=>$q_id));
        return $q_id;            
    }
    public function check_user_answered($q_id){
        $user = $this->session->userdata('user');
        $sql=("SELECT answerer FROM answers WHERE answerer='$user' AND question_id='$q_id'");
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return true;
        }else{return false;}
    }    
    public function add_answer($answer_data){
        $q_id = $answer_data[0];
        $answer_body = $answer_data[1];
        $tags = $answer_data[2];
        $user = $this->session->userdata('user');
        $username = $this->session->userdata('username');
        $user_id = $this->session->userdata('user_id');
        $sql1=("UPDATE questions SET answers=(answers+1) WHERE id='$q_id'");
        $sql2=("INSERT INTO answers(body,question_id,answerer,tags,answerer_id,answerer_username) VALUES(".$this->db->escape($answer_body).",'$q_id','$user','$tags','$user_id','$username')");
        $this->db->trans_Start();
        $this->db->query($sql1);
        $this->db->query($sql2);
        $id = $this->db->insert_id();
        $this->db->trans_Complete();
        if($this->db->trans_Status() === FALSE){
            $this->db->transRollback();
            return false;
        }else{
            return $id;
    }
    }
    public function get_answers($id){
        $sql=("SELECT * FROM answers WHERE question_id='$id' ORDER BY accepted DESC,votes DESC");
        return $this->db->query($sql)->result();
    }
    public function check_answer_owner($answer_id){
        $user = $this->session->userdata('user');
        $sql=("SELECT answerer FROM answers WHERE answerer='$user' AND id='$answer_id'");
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return true;
        }else{return false;}
    }     
    public function check_answer_comment_owner($comment_id){
        $user = $this->session->userdata('user');
        $sql=("SELECT commentor FROM answers_comments WHERE commentor='$user' AND id='$comment_id'");
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return true;
        }else{return false;}
    }    
    public function check_comment_owner($comment_id){
        $user = $this->session->userdata('user');
        $sql=("SELECT commentor FROM comments WHERE commentor='$user' AND id='$comment_id'");
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return true;
        }else{return false;}
    }
    public function check_user_voted_answer($answer_id){
        $user = $this->session->userdata('user');
        $sql=("SELECT voter FROM answer_votes WHERE voter='$user' AND answer_id='$answer_id'");
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return true;
        }else{return false;}
    }
    public function answer_update_votes_and_points($answer_id,$vote,$q_id,$down_up,$a_owner){
        $user = $this->session->userdata('user');
        $this->db->trans_Start();
        $this->db->query("UPDATE answers SET votes=(votes+'$vote') WHERE id='$answer_id' ");
        $this->db->query("INSERT INTO answer_votes(voter,answer_id,down_up,question_id) VALUES('$user','$answer_id','$down_up','$q_id')");
        $this->db->trans_Complete();
        if($this->db->trans_Status() === FALSE){
            $this->db->transRollback();
            return false;
        }else{
            return true;
    }
    }
    public function accept_answer($data){
        $answer_id=$data[0];
        $answerer=$data[1];
        $user = $this->session->userdata('user');
        $sql=("UPDATE answers SET accepted=1 WHERE id='$answer_id'");
        $query = $this->db->query($sql);
        return true;
    }
    public function add_q_vote_points($data){
        $q_id=$data[0];
        $q_owner=$data[3];
        $user = $this->session->userdata('user');
        $sql=("INSERT INTO points(count,user,type,question_id) VALUES(5,'$user','vote_q','$q_id')");
        $sql2=("INSERT INTO points(count,user,type,question_id) VALUES(5,'$q_owner','vote_own_q','$q_id')");
        if(!$this->db->query($sql) || !$this->db->query($sql2)){
            return false;
        }else{
            return true;
        }
    }
        public function add_a_vote_points($answer_id,$q_id,$a_owner){
        $user = $this->session->userdata('user');
        $sql=("INSERT INTO points(count,user,type,answer_id,question_id) VALUES(5,'$user','vote_a','$answer_id','$q_id')");
        $sql2=("INSERT INTO points(count,user,type,answer_id,question_id) VALUES(5,'$a_owner','vote_own_a','$answer_id','$q_id')");
        $this->db->query($sql);
        $this->db->query($sql2);
    }
    
public function make_notifications($from,$type,$section,$q_id,$link,$delete_id,$answer_id=null){
        $notify_to=("SELECT DISTINCT asker FROM questions
        WHERE id='$q_id'
        UNION ALL
        SELECT DISTINCT answerer FROM answers
        WHERE question_id='$q_id'
        UNION ALL
        SELECT DISTINCT commentor FROM comments
        WHERE question_id='$q_id'
        UNION ALL
        SELECT DISTINCT commentor FROM answers_comments
        WHERE question_id='$q_id'
        ");
        $result = $this->db->query($notify_to)->result();
        $users = array();foreach($result as $k => $v){foreach($v as $nk => $nv){array_push($users,$nv);}}
        for($x=0;$x<sizeof($users);$x++){
            $user=$users[$x];
            if($user != $from){   
            $sql=("INSERT INTO notifications(to_,from_,type,link_,section,question_id,delete_id,answer_id) VALUES('$user','$from','$type','$link','$section','$q_id','$delete_id','$answer_id')");
            if($this->db->query($sql)){
                return true;
            }else{
                return false;
            }
            }
        }
    }
    public function get_notifications(){
        $user = $this->session->userdata('user');
        $sql=("SELECT * FROM notifications WHERE to_='$user' AND seen=0 ORDER BY at ASC");
        return $this->db->query($sql)->result();
    }
    public function delete_notifications($type,$id){
        if($type == 'question'){
            $sql=("DELETE FROM notifications WHERE question_id='$id'");
        }
        if($type == 'answer'){
            $sql=("DELETE FROM notifications WHERE type='answered' AND delete_id='$id'");
        } 
        if($type == 'comment'){
            $sql=("DELETE FROM notifications WHERE type='commented' AND delete_id='$id'");
        }
        if($type == 'answer_comment'){
            $sql=("DELETE FROM notifications WHERE type='answer_commented' AND delete_id='$id'");
        }
        $this->db->query($sql);
        return true;
    }
    public function user_profile_activity($user){
        $questions = $this->db->query("select title,id,votes,at from questions where asker='$user'")->result();
        $questions_comments = $this->db->query("select questions.title,questions.id as id,questions.votes,comments.at,comments.id as comment_id from questions 
        inner join comments where comments.question_id=questions.id and commentor='$user'")->result();
        $questions_votes = $this->db->query("select questions.title,questions.id,questions.votes,votes.at from questions 
        inner join votes where votes.question_id=questions.id and voter='$user'")->result();
        $answers = $this->db->query("select questions.title,questions.id,answers.at,answers.votes from questions 
        inner join answers where answers.question_id=questions.id and answerer='$user'")->result();
        $answer_votes = $this->db->query("select questions.title,questions.id,questions.votes,answer_votes.at,answer_votes.down_up from questions 
        inner join answer_votes where answer_votes.question_id=questions.id and voter='$user'")->result();
        $answer_comments = $this->db->query("select questions.title,questions.id as id,questions.votes,answers_comments.at,answers_comments.id as comment_id from questions 
        inner join answers_comments where answers_comments.question_id=questions.id and commentor='$user'")->result();
        $answer_votes = $this->db->query("select questions.title,questions.id,questions.votes,answer_votes.at from questions 
        inner join answer_votes where answer_votes.question_id=questions.id and voter='$user'")->result();
        $result = array();
        array_push($result,$questions,$questions_comments,$questions_votes,$answers,$answer_comments,$answer_votes);
        return $result;
    }
    public function seen_link($id){
        $sql=("UPDATE notifications SET seen=(1) WHERE id='$id'");
        $this->db->query($sql);
        return true;
    }
    public function search_question($text){
        $sql=("select * from questions where title like '$text'");
        $this->db->query($sql);
        return true;
    }
    public function all_stats(){
        $sql1=("select count(*) as questions from questions");
        $sql2=("select count(*) as answers from answers");
        $result = $this->db->query($sql1)->result();
        $result2 = $this->db->query($sql2)->result();
        $all = array();
        array_push($all,$result,$result2);
        return $all;
    }

}
?>