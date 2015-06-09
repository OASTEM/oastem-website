<?php
	require_once "common.php";
	
	$db = connect_db("nfd");
	
	if(isset($_GET['delete'])){ //when ?delete
		if(isset($_POST['pid'])){
			$pid = $_POST['pid'];
			$data = $db->query("SELECT uid FROM posts WHERE pid=$pid")->fetch_assoc();
			$uid = $data['uid'];
			if($logged_in && ($_SESSION['uid'] == $uid || $_SESSION['sa'] == 1)){ //check permissions
				$sql = "UPDATE posts SET deleted=1 WHERE pid=$pid";
				
				$db->query($sql);
				if($db->affected_rows == 1) echo 'deleted';
				else echo 'delete error';
			}else{
				echo 'no permission';
			}
		}else{
			echo 'no pid';
		}
	}elseif(isset($_GET['undelete'])){ //when ?undelete
		if(isset($_POST['pid'])){
			$pid = $_POST['pid'];
			if($logged_in && $_SESSION['sa'] == 1){
				$sql = "UPDATE posts SET deleted=0 WHERE pid=$pid";
				
				$db->query($sql);
				if($db->affected_rows == 1) echo 'undeleted';
				else echo 'undelete error';
			}else{
				echo 'no permission';
			}
		}else{
			echo 'no pid';
		}
	}elseif(isset($_GET['modify'])){
		if(isset($_POST['pid'])){
			$pid = $_POST['pid'];
			$data = $db->query("SELECT uid FROM posts WHERE pid=$pid")->fetch_assoc();
			$uid = $data['uid'];
			if($logged_in && ($_SESSION['uid'] == $uid || $_SESSION['sa'] == 1)){
				if(isset($_POST['ntitle']) && isset($_POST['ncontent'])){
					$ntitle = $db->real_escape_string($_POST['ntitle']);
					$ncontent = $db->real_escape_string($_POST['ncontent']);
					
					$sql = "UPDATE posts SET title='$ntitle', content='$ncontent' WHERE pid=$pid";
					
					$db->query($sql);
					
					if($db->affected_rows == 1) echo 'modified';
					else echo 'modify error';
				}else{
					echo 'bad data';
				}
			}else{
				echo 'no permission';
			}
		}else{
			echo 'no pid';
		}
		
	}elseif(isset($_GET['new'])){
		if($logged_in){
			if(isset($_POST['title']) && isset($_POST['content'])){				
				$uid = $_SESSION['uid'];
				$title = $db->real_escape_string($_POST['title']);
				$content = $db->real_escape_string($_POST['content']);
				
				$sql = "INSERT INTO posts (uid, title, content) VALUES ($uid, '$title', '$content')";
							
				$db->query($sql);
							
				if($db->affected_rows == 1) echo 'success';
				else echo 'db error';
			} else echo 'bad data';
		}else echo 'not logged in';
	}elseif(isset($_GET['get'])){
		$sql = "";
		if(isset($_POST['lim'])){
			$lim = $_POST['lim'];
			$sql = "SELECT * FROM (
				SELECT * FROM posts WHERE deleted = 0 ORDER BY pid DESC LIMIT $lim, 24
			) sub
			ORDER BY pid DESC";
		}else{
			$sql = "SELECT * FROM (
				SELECT * FROM posts WHERE deleted = 0 ORDER BY pid DESC LIMIT 24
			) sub
			ORDER BY pid DESC";
		}
		
		listPosts($sql,$db);
		
	}elseif(isset($_GET['getall'])){
		$sql = "SELECT * FROM posts ORDER BY pid DESC";
		listPosts($sql,$db);
	}else{
		echo 'no action';
	}
	
	function listPosts($sql,$db){ //print posts based on $sql given
		global $logged_in;
		$result = $db->query($sql);
			
		if($result->num_rows < 1){ //make sure there are actual results
			echo 'No more.';
		}else{
			while($row = $result->fetch_assoc()){ //for each result from db
				$op = getData($row['uid'],$db);
				$tstring = strtotime($row['time']);
				$cat = getCat($op['cid'],$db);
				
				echo "
				<div id='post" . $row['pid'] . "' class='post-wrapper' data-pid='" . $row['pid'] . "' data-cid='" . $op['cid'] . "'>
					<div class='post-header' style='background-color:" . $cat['color1'] . "'>";
				if($logged_in && ($row['uid'] == $_SESSION['uid'] || $_SESSION['sa'] == 1)){ //check permissions
					echo "<h2 class='edit-button'>Edit</h2> 
						<p class='delete-button'>X</h2>";
				}else{
						echo"
							<h2 class='category'>" . $cat['name'] . "</h2>
							<p class='timestamp'>" . date('D',$tstring) . ", <time class='post-time' datetime='" . $row['time']
							 . "'>" . date('D, M d, Y g:i A',$tstring)
							 . "</time></p>";
				}
						echo"
					</div>
					<div class='content-wrapper'>
						<h3 class='title'>" . $row['title'] . "</h3>
						<p class='content'>" . $row['content'] . "</p>
                        <br /> <br />
                        <p class='author'><em>Posted by " . $op['first_name'] . " " . $op['last_name'] . ", " . $op['position'] . "</em></p>
					</div>
				</div>";
			}
		}
	}
	
	$db->close();

?>