<?php 
	
	# Update user profile
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'edit_user') {
		$query  = "UPDATE user SET first_name='" . $_POST['firstname'] . "', last_name='" . $_POST['lastname'] . "', email='" . $_POST['email'] . "', username='" . $_POST['username'] . "', id_country='" . $_POST['country'] . "', archive='" . $_POST['archive'] . "', role='" . $_POST['role'] . "'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
		# Close MySQL connection
		@mysqli_close($MySQL);
		
		$_SESSION['message'] = '<p>You successfully changed user profile!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=1");
	}
	# End update user profile
	
	# Delete user profile
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
	
		$query  = "DELETE FROM user";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($MySQL, $query);
		$_SESSION['message'] = '<p>You successfully deleted user profile!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=1");
	}
	# End delete user profile
	
	
	#Show user info
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM user";
		$query .= " WHERE id=".$_GET['id'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<div style=" align-items: center;   width: 70%;   margin: auto;">
		<h2>User profile</h2>
		<p><b>First name:</b> ' . $row['first_name'] . '</p>
		<p><b>Last name:</b> ' . $row['last_name'] . '</p>
		<p><b>Username:</b> ' . $row['username'] . '</p>
		</div>';
		$_query  = "SELECT * FROM countries";
		$_query .= " WHERE id='" . $row['id_country'] . "'";
		$_result = @mysqli_query($MySQL, $_query);
		$_row = @mysqli_fetch_array($_result);
		print '
		<p><b>Country:</b> ' .$_row['country_name'] . '</p>
		<p><b>Date:</b> ' .$row['date'] .'</p>
		<p><a href="index.php?menu=8'.'&amp;action='.$action.'">Back</a></p>';
	}
	#Edit user profile
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query  = "SELECT * FROM user";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		$checked_archive = false;
		
		print '
		<h2>Edit user profile</h2>
		<form action="" id="registration_form" name="registration_form" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="edit_user">
			<input type="hidden" id="edit" name="edit" value="' . $_GET['edit'] . '">
			
			<label for="fname">First Name *</label>
			<input type="text" id="fname" name="firstname" value="' . $row['first_name'] . '" placeholder="Your name.." required>
			<label for="lname">Last Name *</label>
			<input type="text" id="lname" name="lastname" value="' . $row['last_name'] . '" placeholder="Your last natme.." required>
				
			<label for="email">Your E-mail *</label>
			<input type="email" id="email" name="email"  value="' . $row['email'] . '" placeholder="Your e-mail.." required>
			
			<label for="username">Username *<small>(Username must have min 5 and max 10 char)</small></label>
			<input type="text" id="username" name="username" value="' . $row['username'] . '" pattern=".{5,10}" placeholder="Username.." required><br>
			
			<label for="country">Country</label>
			<select name="country" id="country">
				<option value="">molimo odaberite</option>';
				#Select all countries from database webprog, table countries
				$_query  = "SELECT * FROM countries";
				$_result = @mysqli_query($MySQL, $_query);
				while($_row = @mysqli_fetch_array($_result)) {
					print '<option value="' . $_row['id'] . '"';
					if ($row['id_country'] == $_row['id']) { print ' selected'; }
					print '>' . $_row['country_name'] . '</option>';
				}
			print '
			</select>
			
			<label for="role">Role:</label><br />
            <input type="radio" name="role" value="admin"'; if($row['role'] == 'admin') { echo ' checked="checked"'; } echo ' /> Admin &nbsp;&nbsp;
            <input type="radio" name="role" value="user"'; if($row['role'] == 'user') { echo ' checked="checked"'; } echo ' /> User &nbsp;&nbsp;
			<input type="radio" name="role" value="editor"'; if($row['role'] == 'editor') { echo ' checked="checked"'; } echo ' /> Editor &nbsp;&nbsp;
			<br><hr>
			<label for="archive">Archive:</label><br />
            <input type="radio" name="archive" value="Y"'; if($row['archive'] == 'Y') { echo ' checked="checked"'; $checked_archive = true; } echo ' /> YES &nbsp;&nbsp;
			<input type="radio" name="archive" value="N"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> NO
			
			<hr>
			
			<input type="submit" value="Submit">
		</form>
		<p><a href="index.php?menu=8'.'&amp;action='.$action.'">Back</a></p>';
	}
	else {
		print '
		<div style="align-items: center; width: 70%; margin: auto;">
		
		<h2>List of users</h2>
		
		
		
			<table style="border-collapse: collapse; width: 100%;border: 1px solid #ddd; text-align: left; ">
				<thead>
					<tr>
						<th width="16"></th>
						<th width="16"></th>
						<th width="16"></th>
						<th>First name</th>
						<th>Last name</th>
						<th>E mail</th>
						<th>Država</th>
						<th width="16"></th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM user";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
						<td><a href="index.php?menu=8'.'&amp;action='.$action.'&amp;id=' .$row['id']. '"><img src="img/user.png" alt="user"></a></td>
						<td><a href="index.php?menu=8'.'&amp;action='.$action.'&amp;edit=' .$row['id']. '"><img src="img/edit.png" alt="uredi"></a></td>
						<td><a href="index.php?menu=8'.'&amp;action='.$action.'&amp;delete=' .$row['id']. '"><img src="img/delete.png" alt="obriši"></a></td>
						<td><strong>' . $row['first_name'] . '</strong></td>
						<td><strong>' . $row['last_name'] . '</strong></td>
						<td>' . $row['email'] . '</td>
						<td>';
							$_query  = "SELECT * FROM countries";
							$_query .= " WHERE id='" . $row['id_country'] . "'";
							$_result = @mysqli_query($MySQL, $_query);
							$_row = @mysqli_fetch_array($_result, MYSQLI_ASSOC);
							print $_row['country_name'] . '
						</td>
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
		</div>';
	}
	
	# Close MySQL connection
	@mysqli_close($MySQL);
?>