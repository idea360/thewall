<?php
    session_start();
    require('new-connection.php');

    if(isset($_POST['action']) && $_POST['action'] == 'register'){
        //cal to function
        register_user($_POST);
     }
    elseif(isset($_POST['action']) && $_POST['action'] == 'login'){
        login_user($_POST);
     }
    elseif(isset($_POST['action']) && $_POST['action'] == 'post_message'){
        post_new_message($_POST);
    }
    elseif(isset($_POST['action']) && $_POST['action'] == 'reply_messages' ){
        post_reply_message($_POST);
    }
    elseif(isset($_POST['action']) && $_POST['action'] == 'del_message'){
    	delete_message($_POST);
    }
    elseif(isset($_POST['action']) && $_POST['action'] == 'del_reply'){
    	delete_comment($_POST);
    }
    else{
        session_destroy();
        header('location: index.php');
    }

function register_user($post)
{
    //--------------- Begin validatin checks. ----------------//
    $_SESSION['errors'] = array();
    if(empty($post['first_name'])){
        $_SESSION['errors'][] = 'Firstname cannot be empty!';
    }
    if(is_numeric($post['first_name']) || is_numeric($post['first_name'])) {
    	$_SESSION['errors'][] = 'Name cannot be numeric!';
    }
    if(empty($post['last_name'])){
        $_SESSION['errors'][] = 'Lastname cannot be empty!';
    }
    if(empty($post['password'])){
        $_SESSION['errors'][] = 'Password cannot be empty!';
    }
    if($post['password'] != $post['confirm_password']){
        $_SESSION['errors'][] = 'Passwords do not match!';
    }
    if(! filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
        $_SESSION['errors'][] = 'Please use a valid email address!';
    }
    //-------------- End of validation Checks! -----------------//
   	if(count($_SESSION['errors']) > 0)
  	{
  		header('location: index.php');
   	} 
   	else 
   	{
    	$esc_fname = escape_this_string($post['first_name']);
    	$esc_lname = escape_this_string($post['last_name']);
       	$esc_email = escape_this_string($post['email']);
       	$esc_pass  = escape_this_string($post['password']);
       	$query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) 
       	values('{$esc_fname}', '{$esc_lname}', '{$esc_email}', '{$esc_pass}', NOW(), NOW())";
        run_mysql_query($query);
        $_SESSION['success_message'] = 'The user ' . $esc_email . ' has been created! Please log in.';
        header('location: index.php');
   	}
}

function login_user($post)
{
	$esc_email = escape_this_string($post['email']);
   	$esc_pass = escape_this_string($post['password']);
   	$query = "SELECT * from users
              WHERE users.password = '{$esc_pass}' && users.email = '{$esc_email}'";
   	$user = fetch_all($query); //Attempt to grab user!

    if(count($user) > 0 )
    {
     	$_SESSION['user_id'] = $user[0]['id'];
       	$_SESSION['user'] = $user[0]['email'];
       	$_SESSION['logged_in'] = true;
		header('location: success.php');
   	}
   	else
   	{
   		$_SESSION['errors'][] = "Password or username is wrong. Please try again.";
      	header('location: index.php');
  	}
}

function post_new_message($post){
    $esc_message_contents = escape_this_string($post['contents']);
    $add_post_query = "INSERT INTO messages
                        (users_id, comment, created_at, updated_at)
                        values('{$_SESSION['user_id']}', '{$esc_message_contents}', NOW(), NOW())";
    run_mysql_query($add_post_query);
    header('location: success.php');
}

function post_reply_message($post){
    $esc_reply_contents = escape_this_string($post['post_reply']);
    $add_reply_query = "INSERT INTO comments
                        (messages_id, users_id, comment, created_at, updated_at)
                        values('{$post['reply_to']}', '{$_SESSION['user_id']}', '$esc_reply_contents', NOW(), NOW())";
	run_mysql_query($add_reply_query);
    header('location: success.php');
}
function delete_message($post){
	//Delete replies first, then the actual message.
	$del_reply_querry = "DELETE FROM comments
						WHERE messages_id = '{$post['message_id']}'";
	run_mysql_query($del_reply_querry);
	$del_message_querry = "DELETE FROM messages
							WHERE id = '{$post['message_id']}'";
	run_mysql_query($del_message_querry);
	$_SESSION['success_del'] = "Message was deleted.";
	header('location: success.php');
}
function delete_comment($post){
	$del_comment_querry = "DELETE FROM comments
							WHERE id = '{$post['reply_id']}'";
	run_mysql_query($del_comment_querry);
	$_SESSION['success_del'] = "Comment was deleted.";
	header('location: success.php');
}
?>