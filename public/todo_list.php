<?  

require_once('classes/filestore.php');

// instantiates class
$file = new Filestore('data/list.txt');

// calls read function within class for $file
$todo_list = $file->read();

// determines if POST is empty and assigns result to variable
$empty_check = empty($_POST);


// Remove Todo Item
if (isset($_GET['remove_index'])) {
	$remove_index = $_GET['remove_index'];
	unset($todo_list[$remove_index]);
	$file->write($todo_list);			// write function within class for $file
	header('Location: /todo_list.php');
}

// Add New Item
if (!$empty_check) {
	$new_item = $_POST['add_new_item']; // takes the input of POST name/$key and assigns it to variable
	if (strlen($new_item) > 240 || strlen($new_item) == 0){
		throw new Exception('New Item must not be empty or exceed 240 characters');
	} else {
	$todo_list[] = $new_item;
	$file->write($todo_list);
	header('Location: /todo_list.php');
	}
}

// UPLOAD FILE
// Verify there were uploaded files and no errors
//if ($_FILES)
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
	    $uploaded_list = $file->read($saved_filename);

	    // merge
	    $todo_list = array_merge($todo_list, $uploaded_list);

	    $file->write($todo_list);
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
	<link rel="stylesheet" href="/css/site.css">
	<link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
</head>
<body id='container'>
	<!-- <p><img src="/images/apple_logo.png"/ class='apple_img' opacity></p> -->
	<h1><img src="/images/apple_logo.png"/ class='apple_img' opacity>iDO List:</h1>
	<ul>
		<!-- list each item in the file on the web browser  --> 
		<? foreach ($todo_list as $index => $todo_item) : ?>
			<li><?= htmlspecialchars(strip_tags($todo_item)) . " " ?><?= "<a href=\"todo_list.php?remove_index={$index}\">"; ?>remove</a> </li>
		<? endforeach; ?>
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