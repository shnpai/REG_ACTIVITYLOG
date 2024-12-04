<?php  

require_once 'dbConfig.php';


function getAllUsers($pdo) {
    $sql = "SELECT * FROM user_accounts";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}
function getAllApplicants($pdo) {
	$sql = "SELECT * FROM search_applicants_data
			ORDER BY first_name ASC";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getAllApplicantsBySearch($pdo, $search_query) {
    $sql = "SELECT * FROM search_applicants_data
            WHERE CONCAT(first_name, last_name, email, gender, license_number, license_type, position_applied, specialization, date_added, added_by, last_updated, last_updated_by) LIKE ?
            ORDER BY first_name ASC";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(["%".$search_query."%"]);
    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}


function getApplicantByID($pdo, $id) {
	$sql = "SELECT * from search_applicants_data WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function getAppliByID($pdo, $id) {
	$sql = "SELECT * from search_applicants_data WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$id]);

    if ($executeQuery) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return [];
}

function SearchQuery($pdo, $keyword, $username) {
    $sql = "INSERT INTO user_searched (keyword, username) 
            VALUES (?,?)";
    $stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$keyword, $username]);

	if ($executeQuery) {
		return true;
	}
}

function searchForAnApplicant($pdo, $keyword, $username) {
    $sql = "SELECT * FROM search_applicants_data WHERE 
            CONCAT(first_name, last_name, email, gender, license_number, license_type, position_applied, specialization, date_added) 
            LIKE ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(["%" . $keyword . "%"]);
    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getSearched($pdo) {
    $sql = "SELECT * FROM user_searched ORDER BY search_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function insertNewApplicant($pdo, $first_name, $last_name, $email, 
    $gender, $license_number, $license_type, $position_applied, $specialization, $added_by) {

    $response = array();

    $sql = "INSERT INTO search_applicants_data
            (
                first_name,
                last_name,
                email,
                gender,
                license_number,
                license_type,
                position_applied,
                specialization,
                added_by
            )
            VALUES (?,?,?,?,?,?,?,?,?)";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([
        $first_name, $last_name, $email, 
        $gender, $license_number, $license_type, 
        $position_applied, $specialization, $added_by,
    ]);

    if ($executeQuery) {
		$findInsertedItemSQL = "SELECT * FROM search_applicants_data ORDER BY date_added DESC LIMIT 1";
		$stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
		$stmtfindInsertedItemSQL->execute();
		$getApplicantID = $stmtfindInsertedItemSQL->fetch();

		$insertAnActivityLog = insertAnActivityLog($pdo, "INSERT", $getApplicantID['id'], 
			$getApplicantID['first_name'], $getApplicantID['last_name'], 
			$getApplicantID['email'], $getApplicantID['gender'], $getApplicantID['license_number'], $getApplicantID['license_type'], $getApplicantID['position_applied'], $getApplicantID['specialization'], $_SESSION['username']);

		if ($insertAnActivityLog) {
			$response = array(
				"status" =>"200",
				"message"=>"Applicant successfully inserted!"
			);
		}

		else {
			$response = array(
				"status" =>"400",
				"message"=>"Insertion of activity log failed!"
			);
		}
		
	}

	else {
		$response = array(
			"status" =>"400",
			"message"=>"An error occurred while inserting the applicant."
		);

	}

	return $response;
}


function editApplicant($pdo, $first_name, $last_name, $email, 
    $gender, $license_number, $license_type, $position_applied, $specialization, $id, $modified_by) {

    $response = array();

    $sql = "UPDATE search_applicants_data
                SET first_name = ?,
                    last_name = ?,
                    email = ?,
                    gender = ?,
                    license_number = ?,
                    license_type = ?,
                    position_applied = ?,
                    specialization = ?,
                    modified_by = ?
                WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([
        $first_name, $last_name, $email, $gender, 
        $license_number, $license_type, $position_applied, $specialization, $modified_by, $id
    ]);

    if ($executeQuery) {
		$findInsertedItemSQL = "SELECT * FROM search_applicants_data WHERE id = ?";
		$stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
		$stmtfindInsertedItemSQL->execute([$id]);
		$getApplicantID = $stmtfindInsertedItemSQL->fetch(); 

		$insertAnActivityLog = insertAnActivityLog($pdo, "UPDATE", $getApplicantID['id'], 
			$getApplicantID['first_name'], $getApplicantID['last_name'], 
			$getApplicantID['email'], $getApplicantID['gender'], $getApplicantID['license_number'], $getApplicantID['license_type'], $getApplicantID['position_applied'], $getApplicantID['specialization'], $_SESSION['username']);

		if ($insertAnActivityLog) {

			$response = array(
				"status" =>"200",
				"message"=>"Applicant successfully edited!"
			);
		}

		else {
			$response = array(
				"status" =>"400",
				"message"=>"Insertion of activity log failed!"
			);
		}

	}

	else {
		$response = array(
			"status" =>"400",
			"message"=>"An error occurred while editing the applicant."
		);
	}

	return $response;
}



function deleteApplicant($pdo, $id) {
	$response = array();
	$sql = "SELECT * FROM search_applicants_data WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$id]);
	$getApplicantID = $stmt->fetch();

	$insertAnActivityLog = insertAnActivityLog($pdo, "DELETE", $getApplicantID['id'], 
			$getApplicantID['first_name'], $getApplicantID['last_name'], 
			$getApplicantID['email'], $getApplicantID['gender'], $getApplicantID['license_number'], $getApplicantID['license_type'], $getApplicantID['position_applied'], $getApplicantID['specialization'], $_SESSION['username']);

	if ($insertAnActivityLog) {
		$deleteSql = "DELETE FROM search_applicants_data WHERE id = ?";
		$deleteStmt = $pdo->prepare($deleteSql);
		$deleteQuery = $deleteStmt->execute([$id]);

		if ($deleteQuery) {
			$response = array(
				"status" =>"200",
				"message"=>"Applicant successfully deleted!"
			);
		}
		else {
			$response = array(
				"status" =>"400",
				"message"=>"Insertion of activity log failed!"
			);
		}
	}
	else {
		$response = array(
			"status" =>"400",
			"message"=>"An error occurred while deleting the applicant."
		);
	}

	return $response;
}



function checkIfUserExists($pdo, $username) {
	$response = array();
	$sql = "SELECT * FROM user_accounts WHERE username = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt->execute([$username])) {

		$userInfoArray = $stmt->fetch();

		if ($stmt->rowCount() > 0) {
			$response = array(
				"result"=> true,
				"status" => "200",
				"userInfoArray" => $userInfoArray
			);
		}

		else {
			$response = array(
                "result"=> false,
				"status" => "400",
				"message"=> "User doesn't exist from the database"
			);
		}
	}

	return $response;

}

function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $username); 

	if (!$checkIfUserExists['result']) {

		$sql = "INSERT INTO user_accounts (username, first_name, last_name, password) 
		VALUES (?,?,?,?)";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute([$username, $first_name, $last_name, $password])) {
			$response = array(
				"status" => "200",
				"message" => "User successfully inserted!"
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message" => "An error occured with the query!"
			);
		}
	}

	else {
		$response = array(
			"status" => "400",
			"message" => "User already exists!"
		);
	}

	return $response;
}

function getUserIDByUsername($pdo, $username) {
	$sql = "SELECT user_id FROM user_accounts WHERE username =?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$username]); 
	$row = $stmt->fetch();
	return $row ? $row['user_id'] : null;
}

function validatePassword($password) {
    if (strlen($password) >= 8) {
        $hasLower = false;
        $hasUpper = false;
        $hasNumber = false;

        for ($i = 0; $i < strlen($password); $i++) {
            if (ctype_lower($password[$i])) {
                $hasLower = true;
            } elseif (ctype_upper($password[$i])) {
                $hasUpper = true;
            } elseif (ctype_digit($password[$i])) {
                $hasNumber = true;
            }

            if ($hasLower && $hasUpper && $hasNumber) {
                return true;
            }
        }
    }

    return false;
}

function insertAnActivityLog($pdo, $operation, $id, $first_name, 
		$last_name, $email, $gender, $license_number, $license_type, $position_applied, $specialization, $username) {

	$sql = "INSERT INTO activity_logs (operation, id, first_name, 
		last_name, email, gender, license_number, license_type, position_applied, specialization, username) VALUES(?,?,?,?,?,?,?,?,?,?,?)";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$operation, $id, $first_name, 
		$last_name, $email, $gender, $license_number, $license_type, $position_applied, $specialization, $username]);

	if ($executeQuery) {
		return true;
	}

}

function getAllActivityLogs($pdo) {
	$sql = "SELECT * FROM activity_logs";
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		return $stmt->fetchAll();
	}
}

?>