<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
	<a href="index.php"class="back-link">Back</a>
	<h1>Action History</h1>
	<table style="width:100%; margin-top: 10px; text-align: center;">
    <tr>
        <th style="background-color: #FAD5D5;">Added By User ID</th>
        <th style="background-color: #FAD5D5;">Date Added</th>
        <th style="background-color: #FAD5D5;">Modified By User ID</th>
        <th style="background-color: #FAD5D5;">Last Updated</th>
    </tr>
    <?php $getAppliByID = getAppliByID($pdo, $_GET['id']); ?>
    <?php foreach ($getAppliByID as $row) { ?>
    <tr>
        <td><?php echo $row['added_by']; ?></td>
        <td><?php echo $row['date_added']; ?></td>
        <td><?php echo $row['modified_by']; ?></td>
        <td><?php echo $row['last_updated']; ?></td>
    </tr>
    <?php } ?>
</table>
	
</body>
</html>