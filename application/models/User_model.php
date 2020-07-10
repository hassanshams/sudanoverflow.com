<?php
class User_model extends CI_Model{
    public function __construct(){}

public function check_used_email($email){
        $sql="SELECT * FROM users WHERE email='$email'";
         if($this->db->query($sql)->num_rows() > 0){
             return true;
         }else{return false;}
    }
public function check_login_email($email){
        $sql="SELECT * FROM users WHERE email='$email'";
         if($this->db->query($sql)->num_rows() > 0){
             return $this->db->query($sql)->result();;
         }else{return false;}
    }
 public function unverified_signup($user_data,$token){     
     $username = $user_data[0];
     $password = $user_data[1];
     $email = $user_data[2];
     $data = array('username'=>$username,'password'=>md5($password),'email'=>$email,'activated'=>'0','token'=>$token,'profile_pic'=>'defult.png');
     $this->db->insert('users',$data);
     $id=$this->db->insert_id();
     $this->session->set_userdata('user',$username);
     $this->session->set_userdata('user_id',$id);
     return true;
     }
public function insert_recovery_token($email,$token){
    $sql=("update users set recovery_token='$token' where email='$email'");
    if($this->db->query($sql)){
        return true;
    }else{
        return false;
    }
}
public function check_recovery_token($email,$token){
    $sql=("select * from users where email='$email' and recovery_token='$token'");
    if($this->db->query($sql)->num_rows() > 0){
        return true;
    }else{
        return false;
    }
}
public function check_activation_token($token){
    $sql=("select token,activated from users where token='$token' and activated='0'");
    if($this->db->query($sql)->num_rows() > 0){
        return true;
    }else{
        return flase;
    }
}
public function activate_Account($token){
    $sql=("update users set activated='1' where token='$token'");
    $this->db->query($sql);
    $query = $this->db->query("SELECT * FROM users WHERE token='$token'");
       $row = $query->row();
       if($row){
           $user = $row->email;
           $username = $row->username;
           $id = $row->id;
       }
    $this->session->set_userdata('user',$user);
    $this->session->set_userdata('username',$username);
    $this->session->set_userdata('user_id',$id);
    return true;
}
public function create_social_account($data){
    $username=$data['name'];
    $email=$data['email'];
    $sql = ("insert into users(username,email,social,activated) values('$username','$email','1','1')");
    if($this->db->query($sql)){return true;}else{return false;}
}
 public function validate_login($data){
       $email = $data[0];
       $password = md5($data[1]);
       $sql = ("SELECT * FROM users WHERE email='$email' AND password='$password'");
       if($this->db->query($sql)->num_rows() > 0){
           $user = $this->db->query($sql)->row()->username;
           $user = $this->db->query($sql)->row()->email;
           $id = $this->db->query($sql)->row()->id;
           $this->session->set_userdata('username',$user);
           $this->session->set_userdata('user',$email);
           $this->session->set_userdata('user_id',$id);
           return true;
       }else{
           return false;
        }
    } 
    public function send_recovery_mail($email,$token){
        $sql="update users set recovery_token='$token' where email='$email' ";
        if($this->db->query($sql)){
            return true;
        }else{
            return false;
        }
    }
 public function insert_profile_img($pic){
     $user = $this->session->userdata('user');
     $sql=("UPDATE users SET profile_pic='$pic' WHERE email='$user'");
     $this->db->query($sql);
     return true;
 }
 public function insert_profile_data($data){
     $user = $this->session->userdata('user');
     $location = $data[0];
     $job=$data[1];
     $college=$data[2];
     $bio=$data[3];
     $sql=("UPDATE users SET location='$location', bio='$bio', college='$college', job='$job' WHERE email='$user'");
     if($this->db->query($sql)){
         return true;
     }else{
         return false;
    }
 }
public function get_user_info($id){
    $sql=("SELECT * FROM users WHERE id='$id'");
    return $this->db->query($sql)->result();
}
public function all_users(){
    $sql=("SELECT * FROM users");
    return $this->db->query($sql)->result();
}
public function recent_users(){
    $sql=("SELECT * FROM users order by created_at");
    return $this->db->query($sql)->result();
}
public function most_points_users(){
    $sql=("SELECT * FROM users order by points DESC");
    return $this->db->query($sql)->result();
}
    }
?> 