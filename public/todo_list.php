<!DOCTYPE html>
<html>
<head>
	<title>TODO List</title>
</head>
<body>
	<?php  
		var_dump($_GET);
		var_dump($_POST);
	?>
	<h1>TODO List:</h1>
	<ul>
	<?php
		$todo_list = [
			"Pick-up dry cleaning",
			"Feed the dogs",
			"Go buy grocery"
		];

		$length = count($todo_list);

		for ($i = 0; $i < $length; $i++) {
			echo "<li>$todo_list[$i]</li>\n";
		}
	?>
	</ul>
	<!-- <h1>TODO List:</h1>
	<ul>
		<li>Pick-up dry cleaning</li>
		<li>Feed the dogs</li>
		<li>Go buy groceries</li>
	</ul> -->
	<form method="GET">
        <p>
            <label for="add_item">Please add a todo item:</label>
            <input id="add_item" name="add_item" method="post" type="text" placeholder="add_item">
        </p>
        <p>
            <input type=submit name=”submit”>
        </p>
    </form>
</body>
</html>