<!DOCTYPE html>
<html>
<head>
	<title>TODO List</title>
</head>
<body>
	<?php  
		var_dump($_GET);
		var_dump($_POST);

		$filename = "data/list.txt";

		function read_file($filename){
		    $filesize  = filesize($filename);
		    $handle = fopen($filename, "r");
		    $file_contents = fread($handle, $filesize);
		    fclose($handle); 
		    return $file_contents;
		}

		function save_file($todo_list, $filename){
				if (is_writeable($filename)){
					$todo_string = implode(PHP_EOL, $todo_list);
					$handle = fopen($filename, 'w');
					fwrite($handle, $todo_string);
					fclose($handle);
					return;
				}
			}
	?>
	<h1>TODO List:</h1>
	<ul>
		<?php
			// assigns the file contents/string to a variable
			$file_contents = read_file($filename);

			// explodes the string into an array and assigns it to variable
	        $todo_list = explode(PHP_EOL, $file_contents);
	        
	        
	        // determines if POST is empty and assigns result to variable
	        $empty_check = empty($_POST);

	        // if the variable is not empty, asks it to execute
	        if (!$empty_check) {
	        	$new_item = $_POST['add_new_item']; // takes the input of POST name/$key and assigns it to variable
	        	$todo_list[] = $new_item;
	        	save_file($todo_list, $filename);
	        }
	        




			// foreach($_POST as $key => $value) {
		 //        echo "<p>{$key} => ${value}</p>";
		 //    }

			foreach ($todo_list as $todo_item) {
				echo "<li>$todo_item</li>\n";
			}

			// for ($i = 0; $i < $length; $i++) {
			// 	echo "<li>$list_items[$i]</li>\n";
			// }


//load file

// add new item to file if it exists

// save the file

	        // // #5
	        // if (isset($_GET['removeIndex'])) {
	        // 	 . $_GET['removeIndex'] . ;
	        // }

	        // foreach($item as $items) {
	        // 	echo  "<li>{$item} <a href=\"sample_post.php?removeIndex+{$key}\">Remove Item</a>"
	        // }
		?>
	</ul>
	<!-- <h1>TODO List:</h1>
	<ul>
		<li>Pick-up dry cleaning</li>
		<li>Feed the dogs</li>
		<li>Go buy groceries</li>
	</ul> -->
	<form method="POST" action="">
        <p>
            <label for="add_item">Please add a todo item:</label>
            <input id="add_item" name="add_new_item" type="text" placeholder="enter new item">
        </p>
        <p>
            <input type=submit name=”submit”>
        </p>
    </form>
</body>
</html>