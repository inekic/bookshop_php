<?php 
	
	
	
	#Add review
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'add_review') {
		$_SESSION['message'] = '';
		# htmlspecialchars — Convert special characters to HTML entities
		# http://php.net/manual/en/function.htmlspecialchars.php
		$query  = "INSERT INTO review (title, content, archive)";
		$query .= " VALUES ('" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', '" . htmlspecialchars($_POST['content'], ENT_QUOTES) . "', '" . $_POST['archive'] . "')";
		$result = @mysqli_query($MySQL, $query);
		echo 'jd' . $query;
		$ID = mysqli_insert_id($MySQL);
		
		# picture
        if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));
			
            $_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "review/".$_picture);
			
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') { # test if format is picture
				$_query  = "UPDATE review SET picture='" . $_picture . "'";
				$_query .= " WHERE id=" . $ID . " LIMIT 1";
				$_result = @mysqli_query($MySQL, $_query);
				$_SESSION['message'] .= '<p>You successfully added picture.</p>';
			}
        }
		
		
		$_SESSION['message'] .= '<p>You successfully added news!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	
	# Update review
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'edit_review') {
		$query  = "UPDATE review SET title='" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', content='" . htmlspecialchars($_POST['content'], ENT_QUOTES) . "', archive='" . $_POST['archive'] . "'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
		
		# picture
        if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));
            
			$_picture = (int)$_POST['edit'] . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "news/".$_picture);
			
			
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') { # test if format is picture
				$_query  = "UPDATE news SET picture='" . $_picture . "'";
				$_query .= " WHERE id=" . (int)$_POST['edit'] . " LIMIT 1";
				$_result = @mysqli_query($MySQL, $_query);
				$_SESSION['message'] .= '<p>You successfully added picture.</p>';
			}
        }
		
		$_SESSION['message'] = '<p>You successfully changed review!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	# End update review
	
	# Delete review
	if ((isset($_GET['delete']) && $_GET['delete'] != '') && $admin){
		
		# Delete picture
        $query  = "SELECT picture FROM review";
        $query .= " WHERE id=".(int)$_GET['delete']." LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
        $row = @mysqli_fetch_array($result);
        @unlink("review/".$row['picture']); 
		
		# Delete review
		$query  = "DELETE FROM review";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($MySQL, $query);
		$_SESSION['message'] = '<p>You successfully deleted review!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	# End delete review
	
	
	#Show review info
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM review";
		$query .= " WHERE id=".$_GET['id'];
		$query .= " ORDER BY date DESC";
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		
		
		print '
		
		<div style="align-items: center; width: 70%; margin: auto;">
		<h2>Review overview</h2>
		
			<img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
			<h2>' . $row['title'] . '</h2>
			' . $row['content'] . '
			<time datetime="' . $row['date_created'] . '">' . 'Date created '. '</time>
			<hr>
		
		<p><a href="index.php?menu=1'.'&amp;action='.$action.'">Back</a></p>
		</div>';
	}
	
	#Add review 
	else if (isset($_GET['add']) && $_GET['add'] != '') {
		
		print '
		<h2>Add review</h2>
		<form action="" id="review_form" name="review_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="add_review">
			
			<label for="title">Title *</label>
			<input type="text" id="title" name="title" placeholder="Review title.." required>
			<label for="content">Content *</label>
			<textarea id="content" name="content" placeholder="Review content.." required></textarea>
				
			<label for="picture">Picture</label>
			<input type="file" id="picture" name="picture">
						
			<label for="archive">Archive:</label><br />
            <input type="radio" name="archive" value="Y"> YES &nbsp;&nbsp;
			<input type="radio" name="archive" value="N" checked> NO
			
			<hr>
			
			<input type="submit" value="Submit">
		</form>
		<p><a href="index.php?menu=1 '.'&amp;action='.$action.'">Back</a></p>';
	}
	#Edit news
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query  = "SELECT * FROM review";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		$checked_archive = false;
		print '
		<h2>Edit review</h2>
		<form action="" id="review_form_edit" name="review_form_edit" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="edit_review">
			<input type="hidden" id="edit" name="edit" value="' . $row['id'] . '">
			
			<label for="title">Title *</label>
			<input type="text" id="title" name="title" value="' . $row['title'] . '" placeholder="News title.." required>
			<label for="content">Content *</label>
			<textarea id="content" name="content" placeholder="Review content.." required>' . $row['content'] . '</textarea>
				
			<label for="picture">Picture</label>
			<input type="file" id="picture" name="picture">
						
			<label for="archive">Archive:</label><br />
            <input type="radio" name="archive" value="Y"'; if($row['archive'] == 'Y') { echo ' checked="checked"'; $checked_archive = true; } echo ' /> YES &nbsp;&nbsp;
			<input type="radio" name="archive" value="N"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> NO
			
			<hr>
			
			<input type="submit" value="Submit">
		</form>
		<p><a href="index.php?menu=1'.'&amp;action='.$action.'">Back</a></p>';
	}
	else {
		print'
		
		<div style="align-items: center; width: 70%; margin: auto;">
		<h2>Reviews</h2>
			<table  style="border-collapse: collapse; width: 100%;border: 1px solid #ddd; text-align: left; ">
				<thead>
					<tr>
						<th width="16"></th>
						<th width="16"></th>
						<th width="16"></th>
						<th>Title</th>
						<th>Description</th>
						<th>Date</th>
						<th width="16"></th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM review";
				$query .= " ORDER BY date_created DESC";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
					';
						if ($admin)	{
						
						print'
							<td><a href="index.php?menu=8'.'&amp;action=1'.'&amp;id=' .$row['id']. '"><img src="img/user.png" alt="user"></a></td>
						';}
						
						
						print'
						<td><a href="index.php?menu=8'.'&amp;action=2'.'&amp;edit=' .$row['id']. '"><img src="img/edit.png" alt="uredi"></a></td>';
						if ($admin)	{
						
						print'
							<td><a href="index.php?menu=8'.'&amp;action=2'.'&amp;delete=' .$row['id']. '"><img src="img/delete.png" alt="obriši"></a></td>
						
						';}
						print'
						<td>' . $row['title'] . '</td>
						<td>';
						if(strlen($row['content']) > 50) {
                            echo substr(strip_tags($row['content']), 0, 50).'...';
                        } else {
                            echo strip_tags($row['content']);
                        }
						print '
						</td>
						<td>' . $row['date_created'] . '</td>
						<td>';
							if ($row['archive'] == 'Y') { print '<img src="img/inactive.png" alt="" title="" />'; }
                            else if ($row['archive'] == 'N') { print '<img src="img/active.png" alt="" title="" />'; }
						print '
						</td>
					</tr>';
				}
			print '
				</tbody>
			</table>
			<a href="index.php?menu=8'.'&amp;action=2'. '&amp;add=true" class="AddLink">Add review</a>
		</div>';
	}
	
	# Close MySQL connection
	@mysqli_close($MySQL);
?>