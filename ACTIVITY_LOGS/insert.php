<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add New Applicant</title>
	<link rel="stylesheet" href="styles/styles.css">
</head>
<body>
	<div class="container">
		<a href="index.php" class="back-link">Back</a>
		<h1 class="form-title">Complete this form to add a new psychologist applicant</h1>
		
		<form action="core/handleForms.php" method="POST" class="applicant-form">
			<div class="form-group">
				<label for="first_name">First Name</label>
				<input type="text" name="first_name" id="first_name" required class="form-input">
			</div>
			<div class="form-group">
				<label for="last_name">Last Name</label>
				<input type="text" name="last_name" id="last_name" required class="form-input">
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" name="email" id="email" required class="form-input">
			</div>
			<div class="form-group">
				<label for="gender">Gender</label>
				<input type="text" name="gender" id="gender" required class="form-input">
			</div>
			<div class="form-group">
				<label for="license_number">License Number</label>
				<input type="text" name="license_number" id="license_number" required class="form-input">
			</div>
			<div class="form-group">
				<label for="license_type">License Type</label>
				<input type="text" name="license_type" id="license_type" required class="form-input">
			</div>
			<div class="form-group">
				<label for="position_applied">Position Applied</label>
				<input type="text" name="position_applied" id="position_applied" required class="form-input">
			</div>
			<div class="form-group">
				<label for="specialization">Specialization</label>
				<input type="text" name="specialization" id="specialization" required class="form-input">
			</div>
			<div class="form-group">
				<input type="submit" name="insertApplicantBtn" value="Submit" class="submit-btn">
			</div>
		</form>
	</div>
</body>
</html>
