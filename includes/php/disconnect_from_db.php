<?php
	// 3. Use returned MySQL data (if any)
		// No data currently being returned; only inserting values into database.

	// 4. Release returned data from memory
		// Since we are not returning any information from the database, there is nothing to release from memory in this case

	// 5. Close database connection
	mysqli_close($dbConnection);
?>