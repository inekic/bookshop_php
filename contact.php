<?php 
	print '
	<div class="contact-container">
	<h1>Contact Form</h1>
	
	<div class="contact-center">
	
	<div class="row">
		<div class="column">
			<iframe src="https://maps.google.com/maps?q=zagreb&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>	
	<div class="column">
		<form action="/action_page.php" id="contact_form" name="contact_form" method="POST">
				<label for="fname">First Name *</label>
				<input type="text" id="fname" name="firstname" placeholder="Your first name.." required>

				<label for="lname">Last Name *</label>
				<input type="text" id="lname" name="lastname" placeholder="Your last name.." required>
				
				<label for="lname">Your E-mail *</label>
				<input type="email" id="email" name="email" placeholder="Your e-mail.." required>
			
				<label for="subject">Subject</label>
				<textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>

				<input type="submit" value="Submit">
		</form>
	</div>
			
	</div>
	</div>
';
?>