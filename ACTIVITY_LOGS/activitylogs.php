<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

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
	<?php include 'navbar.php'; ?>
    <a href="index.php"class="back-link">Back</a>
    <h1>Activity Log</h1>
	<div class="tableClass">
		<table style="width: 100%;" cellpadding="20">
			<tr>
				<th>Activity Log ID</th>
				<th>Operation</th>
				<th>Applicant ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Gender</th>
				<th>License Number</th>
                <th>License Type</th>
                <th>Position Applied</th>
                <th>Specialization</th>
                <th>Username</th>
                <th>Date Added</th>
			</tr>
			<?php $getAllActivityLogs = getAllActivityLogs($pdo); ?>
			<?php foreach ($getAllActivityLogs as $row) { ?>
			<tr>
				<td><?php echo $row['activity_log_id']; ?></td>
				<td><?php echo $row['operation']; ?></td>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['first_name']; ?></td>
				<td><?php echo $row['last_name']; ?></td>
				<td><?php echo $row['email']; ?></td>
				<td><?php echo $row['gender']; ?></td>
				<td><?php echo $row['license_number']; ?></td>
                <td><?php echo $row['license_type']; ?></td>
                <td><?php echo $row['position_applied']; ?></td>
                <td><?php echo $row['specialization']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['date_added']; ?></td>
			</tr>
			<?php } ?>
		</table>
</body>
</html>