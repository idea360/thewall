<?php
    session_start();
    //Make sure user HAS logged in!
    //If not, then don't let them access the page.
    if(!isset($_SESSION['user'])){
    	header('location: index.php');
    }
    require 'calctimedate.php';
    require 'new-connection.php';
	
    // Get all messages to display to the user that logged in.
    $get_message_query = "SELECT messages.*, users.first_name, users.last_name
                          FROM messages
                          LEFT JOIN users on users.id = messages.users_id";
    $messages = fetch_all($get_message_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome!</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    <link rel="stylesheet" type="text/css" href="main.css">
    <script type="text/javascript" src="bootstrap.css"></script>
    <script type="text/javascript" src="jq.js"></script>
</head>
<body>
	<?php 
		if(isset($_SESSION['success_del'])){ ?>
			<p class='green-text'> <?= $_SESSION['success_del'] ?> </p>
	<?php 	unset($_SESSION['success_del']);
	 	} ?>
    <div class='container'>
    	<div class='jumbotron'>
    		<a class='pull-right' role='button' class='btn btn-primary btn-lg' href="process.php">
    			<span id='signout-text'>Sign Out</span>
    		</a>
    		<h1>Welcome to MyWall!</h1>
    		<p>Welcome back <span id='username-text'><?= $_SESSION['user']  ?></span>. To get started leave a message!</p>
    		<?php 
				$num_messages = 0;
   				for($i =0; $i < count($messages); $i++){
					if($_SESSION['user_id'] == $messages[$i]['users_id']){
						$num_messages++;
					}
   				} ?>
   			<p>You made <?= $num_messages ?> posts so far. Keep it up!</p>
    	</div> <!-- End jumbotron -->    	
    </div> <!-- End  container -->
    <div class='container'>
        <div class='well well-lg'>
            <form action='process.php' method='post'>
                <input type='hidden' name='action' value='post_message'>
                    <h4>Post a message!</h4>
                    <textarea class="form-control" rows="3" name='contents' placeholder="Enter text here."></textarea>
                <input type='submit' value='Post'>
            </form>
        </div> <!-- End post_message -->
  	</div>
       	<?php
        	foreach ($messages as $message){ ?>
        	<div class='container'>
          		<div class="panel panel-default panel-primary">
               		<div class="panel-heading ">
               			<h3 class="panel-title">
               				<?= $message['first_name'] ?> <?= $message['last_name'] ?> @<?= $message['created_at'] ?>
               			</h3>
               		</div>
               		<div class="panel-body">
               			<?= $message['comment'] ?>
               			<?php 
               			//Call to caluate the diff between now and created at!
   						$diff_minutes_message = calcTimeDiff($message['created_at']);
               			//Only show the delete button if the post is from the same user AND happened less then 30 minutes ago.
               			if($_SESSION['user_id'] == $message['users_id'] && $diff_minutes_message < 30 ) { ?>
               				<form class="btn-group btn-group-xs" action='process.php' method='post'>
                    			<input type='hidden' name='action' value="del_message">
                    			<input type='hidden' name='message_id' value='<?= $message['id'] ?>'>
                    			<input type ='submit' value='Delete'>
                    		</form>
                    	<?php } ?>
						<!-- Get all reply messages to display  --> 
						<?php
                    		$get_reply_query = "SELECT  comments.id, comments.messages_id, comments.users_id, comments.comment, comments.created_at, 
												users.first_name, users.last_name, users.email 
                    							FROM comments
                    							left join users on users.id = comments.users_id 
                    							WHERE messages_id = {$message['id']}";
                    		$comments = fetch_all($get_reply_query);
                    	 ?>
                    	<?php foreach($comments as $comment){   ?>
                    		<div class="panel panel-default panel-info">
                    			<div class="panel-heading ">
                    				<h3 class="panel-title">
                        				<?=  $comment['first_name'] ?> <?= $comment['last_name'] ?> @<?= $comment['created_at'] ?>
                        			</h3>
                        		</div>
                        		<div class="panel-body">
                        			<?= $comment['comment'] ?>
                        			<?php
                        			//Call to calculate the diff between now and created at
                        			$diff_minutes_comment = calcTimeDiff($comment['created_at']);
                        			// Only display the delete button for a users own comments!
                        			if($_SESSION['user_id'] == $comment['users_id'] && $diff_minutes_comment < 30 ) { ?>
                        				<form action='process.php' method='post'>
                    						<input type='hidden' name='action' value="del_reply">
                    						<input type='hidden' name='reply_id' value='<?= $comment['id'] ?>'>
                    						<input type ='submit' value='Delete'>
                    					</form>
                    				<?php } ?>
                        		</div>
                        	</div> <!-- End reply panel -->
                    	<?php } ?>
                   		<form action='process.php' method='post'>
                    		<input type='hidden' name='action' value="reply_messages" placeholder="reply" >
                    		<input type='hidden' name='reply_to' value='<?= $message['id'] ?>'>
                    		<textarea id='text-area' class="form-control" rows='4' name='post_reply' placeholder="Post a reply!"></textarea>
                    		<input type ='submit' value='Reply'>
                    	</form>
              	</div> <!-- End Panel Body -->
     		</div> <!-- End panel -->
    	</div> <!-- end container -->
  		<?php } ?>
</body>
</html>