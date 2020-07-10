<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
    public function __construct(){
        parent::__construct();
    }
public function index(){
        $this->load->model('question_model');
        $nots = $this->question_model->get_notifications();
        $title='ريفو - تسجيل دخول';
        $this->load->view('header',array('nots'=>$nots,'title'=>$title));
        $this->load->view('login');
	}
    public function signup(){
        $this->load->model('question_model');
        $nots = $this->question_model->get_notifications();
        $this->load->view('header',array('nots'=>$nots));
        $this->load->view('signup');
    }
    public function check_email(){
        $this->load->model('user_model');
        $email = $this->input->post('email');
        if($this->user_model->check_used_email($email) == true){
            echo json_encode('used');return;
        }else{echo json_encode('not');}
    }
    public function check_login_email(){
        $res='';
        $this->load->model('user_model');
        $data = $this->input->post('data');
        $email=$data['email'];
        $res = $this->user_model->check_login_email($email);
        if(sizeof($res[0]) > 0){
            if($res[0]->activated == 0){
                echo json_encode('not-activated');
                return;
            }else{
                $this->session->set_userdata('username',$res[0]->username);
                $this->session->set_userdata('user',$email);
                $this->session->set_userdata('user_id',$res[0]->id);
                echo json_encode('activated');
                return;
            }
        }else if($this->user_model->create_social_account($data) == true){
            $this->session->set_userdata('user',$email);
            echo json_encode('new_account_created');
        }else{echo json_encode('no');
        }
    }
    public function unverified_signup(){
        $this->load->model('user_model');
        $user_data = $this->input->post('user_data');
        $email=$user_data[2];
        $token=md5($email.time());


        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_crypto']  = 'ssl';
        $config['smtp_user'] = 'hassanshams43@gmail.com';
        $config['smtp_pass'] = '12345_12345';
        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from('hassanshams43@gmail.com', 'from:sudanoverflow team');
        $this->email->to($email);
        $this->email->subject('Account Activation');
        $this->email->message('https://localhost/sudanoverflow.com/main/verify_email/'.$token);
        if ($this->email->send()) {
            if($this->user_model->unverified_signup($user_data,$token) == true){
                echo json_encode('ok');
                return;
            }
            else{
                echo json_encode('not-inserted-to-db');
                return;
            }
        }else{
            $e=$this->email->print_debugger();
            echo json_encode($e);
        }
    }
 
    public function verify_email($token=null){
        if(isset($token)){
        $this->load->model('user_model');
        if($this->user_model->check_activation_token($token) == true){
            $this->user_model->activate_account($token);
            redirect('/main/edit_profile');
            return;
        }else{
            echo 'account allready activated or not found';
            return;
        }
        }echo 'something went wrong';
        
    }
    public function account_recovery($email=null){
        $this->load->model('question_model');
        $nots = $this->question_model->get_notifications();
        $this->load->model('user_model');
        $this->load->view('header',array('nots'=>$nots));
        $this->load->view('account_recovery');
    }
    public function forgot_password(){
        $this->load->model('question_model');
        $nots = $this->question_model->get_notifications();
        $this->load->view('header',array('nots'=>$nots));
        $this->load->view('forgot_password');
    }
    public function send_recovery_mail(){ 
        $email = $this->input->post('email');
        $this->load->model('user_model');
        $token=mt_rand(10000000,99999999);
        if($this->user_model->insert_recovery_token($email,$token) == true){
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'smtp.gmail.com';
            $config['smtp_port'] = '465';
            $config['smtp_crypto']  = 'ssl';
            $config['smtp_user'] = 'hassanshams43@gmail.com';
            $config['smtp_pass'] = '12345_12345';
            $this->load->library('email', $config);
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->from('hassanshams43@gmail.com', 'from:sudanoverflow team');
            $this->email->to($email);
            $this->email->subject('password recovery');
            $this->email->message($token);
            if ($this->email->send()) {
                echo json_encode('ok');
            } else {
                $e=$this->email->print_debugger();
                echo json_encode($e);
            }
    }else{echo json_encode('not-inserted-to-db');}

    }
public function check_recovery_token(){
    $data=$this->input->post('data');
    $email=$data[0];
    $token=$data[1];
    $this->load->model('user_model');
    if($this->user_model->check_recovery_token($email,$token) == true){
        echo json_encode('ok');
    }else{
        echo json_encode('no');
    }
}
    public function profile(){
        $this->load->model('question_model');
        $questions = $this->question_model->user_profile_questions();
        $nots = $this->question_model->get_notifications();
        $this->load->model('user_model');
        $title='';
        $this->load->view('header',array('nots'=>$nots,'title'=>$title));
        $id=$this->session->userdata('user_id');
        $user_info = $this->user_model->get_user_info($id);
        $this->load->view('profile',array('user_info'=>$user_info,'questions'=>$questions));
    }
    public function upload_profile_pic(){
        $this->load->model('user_model');
        $user = $this->session->userdata('user_id');
        if(isset($_FILES["profile_pic"])){
        $details['upload_path']="./images/profiles/";
        $details['allowed_types']="jpg|jpeg|png|gif";
        $details['max_size']='2048';
        $details['file_name'] = $user;
        $details['overwrite']=TRUE;
        $this->load->library('upload',$details);
        if ( ! $this->upload->do_upload('profile_pic')){
            $error = $this->upload->display_errors();
            echo json_encode($error);
        }
        else{
            $this->upload->do_upload('profile_pic');
            $image = $this->upload->data();
            if($this->user_model->insert_profile_img($image['file_name'])){
                echo json_encode($image['file_name']);
            }else{echo json_encode('something-went-wrong');
            }
        }
        }
    }
    public function insert_profile_data(){
        $this->load->model('user_model');
        $data=$this->input->post('data');
        if($this->user_model->insert_profile_data($data)){
            echo json_encode('ok');
        }else{
            echo json_encode('no');
        }
    }
    public function edit_profile(){
        $this->load->model('question_model');
        $nots = $this->question_model->get_notifications();
        $this->load->model('user_model');
        $id=$this->session->userdata('user_id');
        $user_info = $this->user_model->get_user_info($id);
        $this->load->view('header',array('nots'=>$nots));
        $this->load->view('edit_profile',array('user_info'=>$user_info));
    }
    public function login(){
        $this->load->model('question_model');
        $nots = $this->question_model->get_notifications();
        $this->load->view('header',array('nots'=>$nots));
        $this->load->view('login');
    }
    public function validate_login(){
        $data = $this->input->post('data');
        $this->load->model('user_model');
        if($this->user_model->validate_login($data) == true){
            echo json_encode('ok');
        }else{
            echo json_encode('no');
        }
    }
    public function signout(){
        $this->session->unset_userdata('user');
        $title='تسجيل دخول';
        $this->load->view('header',array('title'=>$title));
        $this->load->view('login');
    }
    public function ask(){
        $title='اضافة دواء جديد';
        $this->load->view('header',array('title'=>$title));
        $this->load->view('ask');
    }
    public function get_tags(){
        $tag = $this->input->post('tag');
        $this->load->model('question_model');
        $result = $this->question_model->get_tags($tag);
        echo json_encode($result);
    }
    public function add_question(){
        $this->load->model('question_model');
        $data = $this->input->post('question_data');
        $insert_id = $this->question_model->add_question($data);
        echo json_encode($insert_id);
    }
    public function home($filter='recent'){
        $this->load->model('question_model');
        $nots = $this->question_model->get_notifications();
        $recent_questions = $this->question_model->get_recent_questions();
        $most_votes_questions = $this->question_model->get_most_votes_questions();
        $most_answers_questions = $this->question_model->get_most_answers_questions();
        $not_answered_questions = $this->question_model->get_not_answered_questions();
        if($filter=='recent'){
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('home',array('questions'=>$recent_questions));
        }else if($filter == 'most-votes'){
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('home',array('questions'=>$most_votes_questions));
        }else if($filter == 'most-answers'){
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('home',array('questions'=>$most_answers_questions));
        }else if($filter == 'not-answered'){
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('home',array('questions'=>$not_answered_questions));
        }
    }
    public function tag($tag,$filter=null){
        $this->load->model('question_model');
        $nots = $this->question_model->get_notifications();
        $recent_questions_for_tag = $this->question_model->get_recent_questions_for_tag($tag);
        $most_votes_questions_for_tag = $this->question_model->get_most_votes_questions_for_tag($tag);
        $most_answers_questions_for_tag = $this->question_model->get_most_answers_questions_for_tag($tag);
        $not_answered_questions_for_tag = $this->question_model->get_not_answered_questions_for_tag($tag);
        if($filter=='recent'){
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('home',array('questions'=>$recent_questions_for_tag,'tag'=>$tag));
        }else if($filter == 'most-votes'){
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('home',array('questions'=>$most_votes_questions_for_tag,'tag'=>$tag));
        }else if($filter == 'most-answers'){
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('home',array('questions'=>$most_answers_questions_for_tag,'tag'=>$tag));
        }else if($filter == 'not-answered'){
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('home',array('questions'=>$not_answered_questions_for_tag,'tag'=>$tag));
        }else{
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('home',array('questions'=>$recent_questions_for_tag,'tag'=>$tag));
        }
    }
    public function search(){
        $text = $this->input->post('text');
        $this->load->model('question_model');
        $nots = $this->question_model->get_notifications();
        $searched_recent_questions = $this->question_model->searched_recent_questions($text);
        $searched_most_votes_questions = $this->question_model->searched_most_votes_questions($text);
        $searched_most_answers_questions = $this->question_model->searched_most_answers_questions($text);
        $searched_not_answered_questions = $this->question_model->searched_not_answered_questions($text);
        if($text=='recent'){
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('home',array('questions'=>$searched_recent_questions,'searched_text'=>$text));
        }else if($text == 'most-votes'){
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('home',array('questions'=>$searched_most_votes_questions,'searched_text'=>$text));
        }else if($text == 'most-answers'){
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('home',array('questions'=>$searched_most_answers_questions,'searched_text'=>$text));
        }else if($text == 'not-answered'){
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('home',array('questions'=>$searched_not_answered_questions,'searched_text'=>$text));
        }else{
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('home',array('questions'=>$searched_recent_questions,'searched_text'=>$text));
        }
    }
    public function question($id){
        $this->load->model('question_model');
        $nots = $this->question_model->get_notifications();
        $this->load->model('question_model');
        $id=$id/62488426;
        $answers = $this->question_model->get_answers($id);
        $question = $this->question_model->get_question($id);
        $comments = $this->question_model->get_comment($id);
        $answer_comments = $this->question_model->get_answer_comments($id);
        $this->load->view('header',array('nots'=>$nots));
        $this->load->view('question',array('question'=>$question,'comments'=>$comments,'answers'=>$answers,'answer_comments'=>$answer_comments));
    } 
    public function user($id){
        $this->load->model('question_model');
        $nots = $this->question_model->get_notifications();
        $this->load->model('user_model');
        $id=$id/62488426;
        $user_info = $this->user_model->get_user_info($id);
        $user_activity = $this->question_model->user_profile_activity($user_info[0]->email);
        $this->load->view('header',array('nots'=>$nots));
        $this->load->view('profile',array('user_info'=>$user_info,'user_activity'=>$user_activity));
    }
    public function tags(){
        $this->load->model('question_model');
        $nots = $this->question_model->get_notifications();
        $tags = $this->question_model->all_tags();
        $tag_questions = $this->question_model->tag_questions();
        $tag_answers = $this->question_model->tag_answers();
        $this->load->view('header',array('nots'=>$nots,'tags'=>$tags,'tag_questions'=>$tag_questions,'tag_answers'=>$tag_answers));
        $this->load->view('tags');
    }

    public function users($filter=null){
        $this->load->model('question_model');
        $this->load->model('user_model');
        $nots = $this->question_model->get_notifications();
        $recent_users = $this->user_model->recent_users();
        $most_points_users = $this->user_model->most_points_users();
        if($filter=='recent'){
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('users',array('users'=>$recent_users));
        }else{
            $this->load->view('header',array('nots'=>$nots));
            $this->load->view('users',array('users'=>$most_points_users));
        }
    }
    public function add_comment(){
        $data = $this->input->post('data');
        $this->load->model('question_model');
        if($insert_id = $this->question_model->add_comment($data)){
            $q_id=$data[0];
            $section=$q_id;
            $link=$q_id*62488426;
            $user=$this->session->userdata('user');
            if($this->question_model->make_notifications($user,'commented',$section,$q_id,$link,$insert_id) == true){
                echo json_encode('commented');
            }else{
                echo json_encode('no');
            }
        }
        
    } 
    public function add_answer_comment(){
        $data = $this->input->post('data');
        $this->load->model('question_model');
        if($answer_comment_id = $this->question_model->add_answer_comment($data)){
            $q_id = $data[0];
            $qu_owner=$data[3];
            $link=$q_id*62488426;
            $section=$data[2];
            $user = $this->session->userdata('user');
            $this->question_model->make_notifications($user,'answer_commented',$section,$q_id,$link,$answer_comment_id);
            echo json_encode('added');
        }
    }   
    public function get_answer_comments(){
        $answer_id = $this->input->post('answer_id');
        $this->load->model('question_model');
        $comments = $this->question_model->get_answer_comments($question_id);
        echo json_encode($comments);
    }
    public function load_votes(){
        $this->load->model('question_model');
        $q_id = $this->input->post('q_id');
        $result = $this->question_model->load_votes($q_id);
        echo json_encode($result);
    }
    public function has_voted(){
        $this->load->model('question_model');
        $q_id = $this->input->post('q_id');
        $result = $this->question_model->has_voted($q_id);
        if($result){
            echo json_encode('voted');
        }else{echo json_encode('not voted');}
    }
    public function add_vote(){
        $data = $this->input->post('data');
        $this->load->model('question_model');
        $q_id = $this->question_model->add_vote($data);
        $this->question_model->add_q_vote_points($data);
    }
    public function if_q_owner(){
        $q_id = $this->input->post('q_id');
        $this->load->model('question_model');
        if($this->question_model->check_q_owner($q_id)){
            echo json_encode('owner');
        }else{echo json_encode('not');}
    }    
    public function delete_question(){
        $q_id = $this->input->post('q_id');
        $this->load->model('question_model');
        if($this->question_model->delete_question($q_id)){
            $this->question_model->delete_notifications('question',$q_id);
            echo json_encode('deleted');
        }
        else{echo json_encode('not');}
    } 
    public function delete_answer(){
        $data = $this->input->post('data');
        $answer_id=$data[0];
        $this->load->model('question_model');
        if($this->question_model->delete_answer($data)){
            $this->question_model->delete_notifications('answer',$answer_id);
            echo json_encode('deleted');
        }
        else{echo json_encode('not');}
    } 
    public function delete_answer_comment(){
        $data = $this->input->post('data');
        $this->load->model('question_model');
        if($this->question_model->delete_answer_comment($data)){
            $comment_id=$data[1];
            $this->question_model->delete_notifications('answer_comment',$comment_id);
            echo json_encode('deleted');
        }
        else{echo json_encode('not');}
    }
    public function delete_comment(){
        $comment_id = $this->input->post('comment_id');
        $this->load->model('question_model');
        if($this->question_model->delete_comment($comment_id)){
            $this->question_model->delete_notifications('comment',$comment_id);
            echo json_encode('deleted');
        }
        else{echo json_encode('not');}
    }
    public function edit_question($q_id){
        $this->load->model('question_model');
        $nots = $this->question_model->get_notifications();
        $q_id=$q_id/62488426;
        $this->load->view('header',array('nots'=>$nots));
        $this->load->view('edit_question',array('q_id'=>$q_id));
    }
    public function get_pre_edit_question(){
        $this->load->model('question_model');
        $q_id = $this->input->post('q_id');
        $data = $this->question_model->get_pre_edit_question($q_id);
        echo json_encode($data);
    }
    public function add_edited_question(){
        $this->load->model('question_model');
        $data = $this->input->post('question_data');
        $insert_id = $this->question_model->add_edited_question($data);
        echo json_encode($insert_id);
    }
    public function check_user_answered(){
        $this->load->model('question_model');
        $q_id = $this->input->post('q_id');
        if(!$this->question_model->check_user_answered($q_id)){
            echo json_encode('not');
        }else{echo json_encode('answered');}
    }    
    public function add_answer(){
        $this->load->model('question_model');
        $answer_data = $this->input->post('answer_data');
        $insert_id = $this->question_model->add_answer($answer_data);
        $q_id = $answer_data[0];
        $qu_owner=$answer_data[3];
        $link=$q_id*62488426;
        $section=$insert_id;
        $user = $this->session->userdata('user');
        $this->question_model->make_notifications($user,'answered',$section,$q_id,$link,$insert_id);
    }
    public function if_answer_owner(){
        $this->load->model('question_model');
        $answer_id = $this->input->post('answer_id');
        if($this->question_model->check_answer_owner($answer_id)){
            echo json_encode('owner');
        }else{echo json_encode('not');}
    }     
    public function if_answer_comment_owner(){
        $this->load->model('question_model');
        $comment_id = $this->input->post('comment_id');
        if($this->question_model->check_answer_comment_owner($comment_id)){
            echo json_encode('owner');
        }else{echo json_encode('not');}
    }   
    public function check_comment_owner(){
        $this->load->model('question_model');
        $comment_id = $this->input->post('comment_id');
        if($this->question_model->check_comment_owner($comment_id)){
            echo json_encode('owner');
        }else{echo json_encode('not');}
    }
    public function get_answers_count(){
        $this->load->model('question_model');
        $answer_id = $this->input->post('id');
        $count = $this->question_model->get_answers_count($answer_id);
        echo json_encode($count);
    }
    public function get_questions_views(){
        $this->load->model('question_model');
        $question_id = $this->input->post('id');
        $count = $this->question_model->get_question_views($question_id);
        echo json_encode($count);
    }
    public function check_user_voted_answer(){
        $this->load->model('question_model');
        $answer_id = $this->input->post('answer_id');
        if(!$this->question_model->check_user_voted_answer($answer_id)){
            echo json_encode('not');
        }else{echo json_encode('voted');}
    }
        public function answer_update_votes(){
        $this->load->model('question_model');
        $answer_data = $this->input->post('answer_data');
        $answer_id = $answer_data[0];
        $vote = $answer_data[1];
        if($vote == 1){$down_up='up';}else if($vote == -1){$down_up='down';}
        $q_id = $answer_data[2];
        $a_owner = $answer_data[3];
        $this->question_model->answer_update_votes($answer_id,$vote,$q_id,$down_up);
        $this->question_model->add_a_vote_points($answer_id,$q_id,$a_owner);
    }
    public function accept_answer(){
        $this->load->model('question_model');
        $data = $this->input->post('data');
        $this->question_model->accept_answer($data);
        $user = $this->session->userdata('user');
        $section=$data[0];
        $q_id=$data[2];
        $link=$q_id*62488426;
        $this->question_model->make_notifications($user,'accepted',$section,$q_id,$link,$section);
        return true;
    }
    public function seen_link(){
        $this->load->model('question_model');
        $id = $this->input->post('id');
        if($this->question_model->seen_link($id)){
            echo json_encode('seen');
        }
    }
    public function guide(){
        $this->load->model('question_model');
        $nots = $this->question_model->get_notifications();
        $this->load->view('header',array('nots'=>$nots));
        $this->load->view('guide');
    } 
    public function logout(){
        $this->session->unset_userdata('user');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('user_id');
        redirect('/main/home');
    }
}

    