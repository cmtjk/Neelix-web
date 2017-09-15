<?php

	if(!isset($_SESSION)) {
			session_start();
	}

	if(isset($_POST['RequestType']) && isset($_POST['OperatingSystem'])  ) {
		saveRequest();
		header("Location: ../index.php?content=requests&success=".urlencode("Anfrage erfolgreich gespeichert!"));
	} else if(isset($_POST['RequestToDelete'])) {
		deleteRequest();
		header("Location: ../index.php?content=requests&success=".urlencode("Anfrage erfolgreich gelöscht!"));
	} else if(isset($_POST['Login'])) {
		login();
		header("Location: ../index.php?content=requests&success=".urlencode("Login erfolgreich!"));
	} else if(isset($_POST['NewNote'])) {
		saveNote();
		header("Location: ../index.php?content=requests&success=".urlencode("Notiz erfolgreich gespeichert!"));
	} else if(isset($_POST['NoteToDelete'])) {
		deleteNote();
		header("Location: ../index.php?content=requests&success=".urlencode("Notiz erfolgreich gelöscht!"));
	} else if(isset($_POST['EventDate'])) {
		saveEvent();
		header("Location: ../index.php?content=requests&success=".urlencode("Event erfolgreich gespeichert!"));
	} else if(isset($_POST['EventToDelete'])) {
		deleteEvent();
		header("Location: ../index.php?content=requests&success=".urlencode("Event erfolgreich gelöscht!"));
	} else if(isset($_POST['NotebookEntryNote'])) {
		saveNotebookEntry();
		header("Location: ../index.php?content=notebook&success=".urlencode("Eintrag erfolgreich gespeichert!"));
	} else if(isset($_POST['NotebookEntryToDelete'])) {
		deleteNotebookEntry();
		header("Location: ../index.php?content=notebook&success=".urlencode("Eintrag erfolgreich gelöscht!"));
	} else if(isset($_POST['NotebookEntryToEdit'])) {
		editNotebookEntry();
		header("Location: ../index.php?content=notebook&success=".urlencode("Eintrag erfolgreich geändert!"));
	}


	function saveNote() {
		$sql_handler = new MySqlHandler;
		$sql_handler->saveNote();
	}


	function saveRequest() {
		$sql_handler = new MySqlHandler;
		$sql_handler->saveRequest();
	}

	function deleteRequest() {
		$sql_handler = new MySqlHandler;
		$sql_handler->deleteRequest();
	}

	function deleteNote() {
		$sql_handler = new MySqlHandler;
		$sql_handler->deleteNote();
	}

	function saveEvent() {
		$sql_handler = new MySqlHandler;
		$sql_handler->saveEvent();
	}

	function deleteEvent() {
		$sql_handler = new MySqlHandler;
		$sql_handler->deleteEvent();
	}

	function saveNotebookEntry() {
		$sql_handler = new MySqlHandler;
		$sql_handler->saveNotebookEntry();
	}

	function deleteNotebookEntry() {
		$sql_handler = new MySqlHandler;
		$sql_handler->deleteNotebookEntry();
	}

	function editNotebookEntry() {
		$sql_handler = new MySqlHandler;
		$sql_handler->editNotebookEntry();
	}


	function login() {
		$sql_handler = new MySqlHandler;
		if($sql_handler->validate()) {
			$_SESSION['user'] = 'it-support';
		}
	}


class MySqlHandler {

	private static $connection;

	function __construct() {
		$this->db_connect();
	}

	private function db_connect() {
		if(!isset($this->connection)) {
			$this->connection = mysqli_connect("localhost", "neelix", "123456", "neelix");
			mysqli_set_charset($this->connection,  "utf8");
		}
		if($this->connection === false) {
			error_log("Unable to establish connection!\n", 3, "./error.log");
			die("ERROR: Could not connect: " . mysqli_connect_error());
		}
	}

	private function db_query($query) {
		$result = mysqli_query($this->connection, $query);
		$myResult = array();
		while($row = mysqli_fetch_object($result)) {
			$myResult[] = $row;
		}
		return $myResult;
	}

 	function validate() {
		$givenUsername = mysqli_real_escape_string($this->connection, $_POST['Username']);
		$givenPassword = $_POST['Password'];
		$query = "SELECT * FROM `neelix`.`Users` WHERE `Users`.`Username` = '".$givenUsername."';";
		$result = mysqli_query($this->connection, $query);
		while($row = mysqli_fetch_object($result)) {
			if(password_verify($givenPassword, $row->Password)) {
				return true;
			}
		}
		// allows all login
		return true;
		header("Location: ../index.php?failure=".urlencode("Login failed: Wrong username or password."));
		exit();
	}

	function getNotebookEntries() {
		$query = "SELECT * FROM `Notebook` ORDER BY `Id` DESC;";
		return $this->db_query($query);
	}

	function getNotes() {
		$query = "SELECT * FROM `Notes` ORDER BY `Id` DESC;";
		return $this->db_query($query);
	}

	function getEvents() {
		$query = "SELECT * FROM `Events` WHERE `Date` >= CURDATE() ORDER BY `Date` ASC;";
		return $this->db_query($query);
	}

	function getRequestTypes() {
		$query = "SELECT * FROM `RequestTypes`;";
		return $this->db_query($query);
	}

	function getLastTenRequests() {
		$query = "SELECT * FROM (SELECT * FROM `neelix`.`Requests` ORDER BY `Id` DESC LIMIT 10) sub ORDER BY `Id` DESC;";
		return $this->db_query($query);
	}

	function saveRequest() {
		$requestType = mysqli_real_escape_string($this->connection, $_POST['RequestType']);
		$operatingSystem = mysqli_real_escape_string($this->connection, $_POST['OperatingSystem']);
		$comment = mysqli_real_escape_string($this->connection, $_POST['Comment']);
		$location = mysqli_real_escape_string($this->connection, $_POST['Location']);
		$query = "INSERT INTO `neelix`.`Requests` VALUES('', CURDATE(), CURTIME(),'".$requestType."', '".$operatingSystem."', '".$comment."', '".$location."');";
;
		if(!mysqli_query($this->connection, $query)) {
			echo $query;
			die("ERROR: Unable to save request: " . mysqli_connect_error());
		}
	}

	function deleteRequest() {
		$requestId = mysqli_real_escape_string($this->connection, $_POST['RequestToDelete']);
		$query = "DELETE FROM `neelix`.`Requests` WHERE `Requests`.`Id` =".$requestId.";";
		if(!mysqli_query($this->connection, $query)) {
			echo $query;
			die("ERROR: Unable to delete request: ". mysqli_connect_error());
		}
	}

	function saveNote() {
		$note = mysqli_real_escape_string($this->connection, $_POST['NewNote']);
		$query = "INSERT INTO `neelix`.`Notes` VALUES('', CURDATE(), CURTIME(),'".$note."');";
		if(!mysqli_query($this->connection, $query)) {
			echo $query;
			die("ERROR: Unable to save request: " . mysqli_connect_error());
		}
	}

	function deleteNote() {
		$noteId = mysqli_real_escape_string($this->connection, $_POST['NoteToDelete']);
		$query = "DELETE FROM `neelix`.`Notes` WHERE `Notes`.`Id` =".$noteId.";";
		if(!mysqli_query($this->connection, $query)) {
			echo $query;
			die("ERROR: Unable to delete request: ". mysqli_connect_error());
		}
	}

	function saveEvent() {
		$date = mysqli_real_escape_string($this->connection, $_POST['EventDate']);
		$time = mysqli_real_escape_string($this->connection, $_POST['EventTime']);
		$title = mysqli_real_escape_string($this->connection, $_POST['EventTitle']);
		$description = mysqli_real_escape_string($this->connection, $_POST['EventDescription']);
		$query = "INSERT INTO `neelix`.`Events` VALUES('','".$date."','".$time."','".$title."','".$description."');";
		if(!mysqli_query($this->connection, $query)) {
			echo $query;
			die("ERROR: Unable to save request: " . mysqli_connect_error());
		}
	}

	function deleteEvent() {
		$noteId = mysqli_real_escape_string($this->connection, $_POST['EventToDelete']);
		$query = "DELETE FROM `neelix`.`Events` WHERE `Events`.`Id` =".$noteId.";";
		if(!mysqli_query($this->connection, $query)) {
			echo $query;
			die("ERROR: Unable to delete request: ". mysqli_connect_error());
		}
	}

	function saveNotebookEntry() {
		$author = mysqli_real_escape_string($this->connection, $_POST['NotebookEntryAuthor']);
		$note = mysqli_real_escape_string($this->connection, $_POST['NotebookEntryNote']);
		$priority = mysqli_real_escape_string($this->connection, $_POST['NotebookEntryPriority']);
		$query = "INSERT INTO `neelix`.`Notebook` VALUES('','".$author."', CURDATE(),'".$note."','".$priority."');";
		if(!mysqli_query($this->connection, $query)) {
			echo $query;
			die("ERROR: Unable to save request: " . mysqli_connect_error());
		}
	}

	function deleteNotebookEntry() {
		$noteId = mysqli_real_escape_string($this->connection, $_POST['NotebookEntryToDelete']);
		$query = "DELETE FROM `neelix`.`Notebook` WHERE `Notebook`.`Id` =".$noteId.";";
		if(!mysqli_query($this->connection, $query)) {
			echo $query;
			die("ERROR: Unable to delete request: ". mysqli_connect_error());
		}
	}

	function editNotebookEntry() {
		$noteId = mysqli_real_escape_string($this->connection, $_POST['NotebookEntryToEdit']);
		$note = mysqli_real_escape_string($this->connection, $_POST['EditedNotebookEntryNote']);
		$priority = mysqli_real_escape_string($this->connection, $_POST['NotebookEntryPriority']);
		$query = "UPDATE `neelix`.`Notebook` SET `Note` = '".$note."', `Priority` = '".$priority."' WHERE `Notebook`.`Id` =".$noteId.";";
		if(!mysqli_query($this->connection, $query)) {
			echo $query;
			die("ERROR: Unable to edit request: ". mysqli_connect_error());
		}
	}

}
?>
