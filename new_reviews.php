	
	<?php
	
	if (isset($_GET['action']) && $_GET['action'] != '') {
		/* $query  = "SELECT * FROM review";
		#$query .= " WHERE id=" . $_GET['id'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
			echo "Hello world!1";
			print '
			<div class="new">
				<img src="review/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
				<h2>' . $row['title'] . '</h2>
				<p>'  . $row['content'] . '</p>
				<time>'. $row['date_created'] . '</time>
				<hr>
			</div>'; */
	}
	else {
		
		
		$query  = "SELECT * FROM review";
		$query .= " WHERE archive='N'";
		$query .= " ORDER BY date_created DESC";
		$result = @mysqli_query($MySQL, $query);
		while($row = @mysqli_fetch_array($result)) {
			print '
			<div class="about">
			<h1>Reviews</h1>
				<img src="review/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
				<h2>' . $row['title'] . '</h2>';
				if(strlen($row['content']) > 300) {
					echo substr(strip_tags($row['content']), 0, 300).'... <a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '">More</a>';
				} else {
					echo strip_tags($row['content']);
				}
				 
				#echo date("F j, Y, g:i a", $row['date_created']);
				#<p id="novi_red"></p>
				echo date('Y-m-d, G:i', strtotime(str_replace('-','/',$row['date_created'])));
				print';
				<hr>
			</div>';
		}
	}
?>
