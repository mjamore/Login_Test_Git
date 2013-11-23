<?php
	echo 	'<h3 id="dbTitle">Usernames and passwords in the database</h3>
			<div class="centeringDIV">
				<div id="currentDB">
				<table>
					<thead>
						<tr>
							<td>id</td>
							<td>username</td>
							<td>password</td>
						</tr>
					</thead>
					<tbody>';
	?>
						<?php

							// Get the entire contents of the users table from the DB
							$queryGetAllDBInfo = "SELECT * FROM users";	
							$queryGetAllDBInfoResult = mysqli_query($dbConnection, $queryGetAllDBInfo);

							// Iterate through the results and print each database row in a new table row
							while($dbRow = mysqli_fetch_assoc($queryGetAllDBInfoResult)) {
								echo "<tr>";
								echo "<td>" . $dbRow["id"] . "</td>";
								echo "<td>" . $dbRow["email"] . "</td>";
								echo "<td>" . $dbRow["password"] . "</td>";
								echo "</tr>";
							}
						?>
<?php
	echo
					'</tbody>
				</table>

			</div><!--close #currentDB-->
			</div><!--close #currentDBContainer-->
		<div class="clearFloat"></div>';
?>