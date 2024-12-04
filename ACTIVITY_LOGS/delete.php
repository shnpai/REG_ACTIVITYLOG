<?php 
require_once 'core/models.php'; 
require_once 'core/dbConfig.php';
 
if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<a href="index.php" class="back-link">Back</a>
	<h1>Are you sure you want to delete this Applicant?</h1>
	<?php $getApplicantByID = getApplicantByID($pdo, $_GET['id']); ?>
	<div class="container">
        <h2>First Name: <?php echo $getApplicantByID['first_name']; ?></h2>
		<h2>Last Name: <?php echo $getApplicantByID['last_name']; ?></h2>
		<h2>Email: <?php echo $getApplicantByID['email']; ?></h2>
		<h2>Gender: <?php echo $getApplicantByID['gender']; ?></h2>
		<h2>License Number:: <?php echo $getApplicantByID['license_number']; ?></h2>
		<h2>License Type: <?php echo $getApplicantByID['license_type']; ?></h2>
		<h2>Position Applied: <?php echo $getApplicantByID['position_applied']; ?></h2>
		<h2>Specialization: <?php echo $getApplicantByID['specialization']; ?></h2>

		<div class="deleteBtn">
			<form action="core/handleForms.php?id=<?php echo $_GET['id']; ?>" method="POST">
				<input type="submit" name="deleteApplicantBtn" value="Delete">
			</form>			
		</div>	

	</div>
</body>
</html>