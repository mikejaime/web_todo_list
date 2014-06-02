<?php  
// var_dump($_GET);
// var_dump($_POST);
// var_dump($_FILES);

$filename = "data/list.txt";
$todo_list = read_file($filename);

// determines if POST is empty and assigns result to variable
$empty_check = empty($_POST);

// Read File & explode to array
function read_file($filename){
	$todo_array = [];
	if (is_readable($filename) && filesize($filename) > 0){	
	    $filesize = filesize($filename);
	    $handle = fopen($filename, "r");
	    $file_contents = fread($handle, $filesize);
	    $todo_array = explode(PHP_EOL, $file_contents);
	    fclose($handle); 
		}
	return $todo_array;
}	

// Save File - implode array back to string 
function save_file($todo_list, $filename){
	if (is_writeable($filename)){
		$todo_string = implode(PHP_EOL, $todo_list);
		$handle = fopen($filename, 'w');
		fwrite($handle, $todo_string);
		fclose($handle);
		return;
	}
}

// Remove Todo Item
if (isset($_GET['remove_index'])) {
	$remove_index = $_GET['remove_index'];
	unset($todo_list[$remove_index]);
	save_file($todo_list, $filename);
}

// Add New Item
if (!$empty_check) {
	$new_item = $_POST['add_new_item']; // takes the input of POST name/$key and assigns it to variable
	$todo_list[] = $new_item;
	save_file($todo_list, $filename);
}

// UPLOAD FILE
// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {
    // Set the destination directory for uploads
    $upload_dir = '/vagrant/sites/todo.dev/public/uploads/';
    // Grab the filename from the uploaded file by using basename
    $up_filename = basename($_FILES['file1']['name']);
    // Create the saved filename using the file's original name and our upload directory
    $saved_filename = $upload_dir . $up_filename;
    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
    // load the new list
    $uploaded_list = read_file($saved_filename);

    // merge
    $todo_list = array_merge($todo_list, $uploaded_list);

    save_file($todo_list, $filename);
}

// SAVE FILE LINK: Check if we saved a file
if (isset($saved_filename)) {
    // If we did, show a link to the uploaded file
    echo "<p>You can download your file <a href='/uploads/{$up_filename}'>here</a>.</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>TODO List</title>
</head>
<body>

	<h1>TODO List:</h1>
	<ul>
		<?php
		// list each item in the file on the web browser 
		foreach ($todo_list as $index => $todo_item) {
			echo "<li>$todo_item <a href=\"todo_list.php?remove_index={$index}\">remove</a></li>";
		}
		?>
	</ul>
	<form method="POST" action="/todo_list.php">
        <p>
            <label for="add_item">Please add a todo item:</label>
            <input id="add_item" name="add_new_item" type="text" placeholder="enter new item">
        </p>
        <p>
            <input type=submit name=”submit”>
        </p>
    </form>
    <br>
    <h1>Upload a File:</h1>
    <form method="POST" enctype="multipart/form-data" action="/todo_list.php">
	    <p>
	        <label for="file1"></label>
	        <input type="file" id="file1" name="file1">
	    </p>
	    <p>
	        <input type="submit" value="upload">
	    </p>
	</form>
</body>
</html>