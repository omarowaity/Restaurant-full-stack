<?php
    //Set page title
    $pageTitle = 'Table Reservation';
	include("..\\Includes\\functions\\database-connection.php");
?>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="../CSS/reserve.css"> 
</head>
<body>
	<section id="book">
		<nav id="main_nav">
			<a href="../HTML/Main.html#header_div">Home</a>
			<a href="../HTML/Main.html#feature">Service</a>
			<a href="../PHP/View.php">Menu</a>
			<a href="../PHP/order_food.php">Order</a>
			<a href="../HTML/Main.html#footer">About</a>  
		</nav> 
	
        <div class="layer">
             <h1>Reserve a Table</h1>
        </div>
        
    </section>
	
	<section id="form">
		<div class="container">
		<?php

            if(isset($_POST['reservation_form']))
            {
				/*$server="localhost";
				$username="Ibrahim";
				$pass="bob1234";
				$db="restaurant";*/

				$mysqli_connect= connect();

				if($mysqli_connect->connect_error){
					exit('Error in connection');
				}

                // Selected Date and Time

                $date = $_POST['date'];
                $time = $_POST['time'];

                $selected_time = $date." ".$time;

                //Nbr of Guests
				if(!isset($_POST['guestNumber'])){
					die('adfGVD');
				}
                $nb_guests = $_POST['guestNumber'];

                //Table Type
                //$table_type = $_POST['table_type'];

                //Client Details
                $user_first_name = $_POST['firstName'];
				$user_last_name = $_POST['lastName'];
                $user_phone_number = $_POST['phone'];
                $user_email = $_POST['email'];

				$query = "SELECT CLIENT_ID,COUNT(*) FROM clients WHERE EMAIL = ?";
				$stmt = $mysqli_connect->prepare($query);
				$stmt->bind_param("s",$user_email);
				$stmt->execute();
				$stmt->bind_result($id,$count);
				$stmt->fetch();
				if($count > 1){
					//the customer is found before
					//so take his id
					$client_id = $id;
				}
				unset($stmt);
                try
                {
					//else enter the client into database
					//if we didn't find him
					if(!isset($client_id)){
						$sqlUser = "INSERT INTO `clients` (`CLIENT_ID`, `FIRST_NAME`, `LAST_NAME`, `PHONE`, `EMAIL`) VALUES (NULL ,?,?,?,?)";
						$stmtUser = $mysqli_connect->prepare($sqlUser);
						//print ($sqlUser);
						$stmtUser->bind_param("ssss",$user_first_name,$user_last_name,$user_phone_number,$user_email);
						$stmtUser->execute();	

						unset($stmtUser);
						//then get the client's id
						$query = "SELECT CLIENT_ID FROM clients WHERE EMAIL = ?";
						$stmt = $mysqli_connect->prepare($query);
						$stmt->bind_param("s",$user_email);
						$stmt->execute();
						$stmt->bind_result($id);
						$stmt->fetch();	
						
						$client_id = $id;
						unset($stmt);
					} 


					//echo "$user_first_name";
					//echo "$user_first_name";
					
					/*$sql = "SELECT USER_ID FROM users WHERE users.email=?";
					$stmt = $mysqli_connect->prepare($sql);
					$stmt->bind_param("s",$user_email);
					$stmt->execute();
                    $user_id = $stmt->fetch();
					echo "$user_id";
					echo "$user_email";*/
					
                    $sqlReservation = "insert into reservation(client_id,selected_time, nb_guests) values(?,?, ?)";
                    $stmt_reservation = $mysqli_connect->prepare($sqlReservation);
					$stmt_reservation->bind_param("isi",$client_id,$selected_time,$nb_guests);
                    $stmt_reservation->execute();
                    
                    echo "<div class = 'alert alert-success p-3 mt-3'>";
                        echo "Great! Your Reservation has been created successfully.";
                    echo "</div>";

                    $mysqli_connect->commit();
                }
                catch(Exception $e)
                {
                    $con->rollBack();
                    echo "<div class = 'alert alert-danger'>"; 
                        echo $e->getMessage();
                    echo "</div>";
                }
            }

        ?>
			<div class="form-wrapper">
				<form method="POST" action="Reservation.php">
				<div class="row">
						<div class="col-6 form-floating mb-3 mt-3">
							<input type="text" id="firstName" name="firstName" class="form-control" placeholder="first name" required="required">
							<label for="firstName">First Name</label>
						</div>
						<div class="col-6 form-floating mb-3 mt-3">
							<input type="text" id="lastName" name="lastName" class="form-control" placeholder="last name" required="required">
							<label for="lastName">Last Name</label>
						</div>
					</div>
					<div class="row">
						<div class="col-6 form-floating mb-3 mt-3">
							<input type="email" id="email" name="email" class="form-control" placeholder="Email" required="required">
							<label for="email">Email</label>
						</div>
						<div class="col-6 form-floating mb-3 mt-3">
							<input type="tel" id="phone" name="phone" class="form-control" placeholder="phone" required="required">
							<label for="phone">Telephone Number</label>
						</div>
					</div>
					<div class="row">
						<div class="col-6 form-floating mb-3 mt-3">
							<select class="form-select" name="tableType" id="tableType" required="required">
								<option selected disabled>Choose</option>
								<option value="small">Small (2 persons)</option>
								<option value="medium">Medium (4 persons)</option>
								<option value="large">Large (6 persons)</option>
							</select>
							<label for="tableType">Table Type</label>
						</div>
						<div class="col-6 form-floating mb-3 mt-3">
							<select class="form-select" name="guestNumber" id="guestNumber" required="required">
								<option selected disabled>Choose</option>
								<option value="1" <?php echo (isset($_POST['guestNumber']))?"selected":"";  ?>>One person</option>
								<option value="2" <?php echo (isset($_POST['guestNumber']))?"selected":"";  ?>>Two people</option>
								<option value="3" <?php echo (isset($_POST['guestNumber']))?"selected":"";  ?>>Three people</option>
								<option value="4" <?php echo (isset($_POST['guestNumber']))?"selected":"";  ?>>Four people</option>
							</select>
							<label for="guestNumber">Guest Number</label>
						</div>
					</div>
					<div class="row">
						<div class="col-6 form-floating mb-3 mt-3">
							<input type="date" id="date" value=<?php echo (isset($_POST['date']))?$_POST['date']:date('Y-m-d',strtotime("+1day"));  ?> name="date" class="form-control" placeholder="date" required="required">
							<label for="date">Date</label>
						</div>
						<div class="col-6 form-floating mb-3 mt-3">
							<input type="time" value=<?php echo (isset($_POST['time']))?$_POST['time']:date('H:i');  ?> id="time" name="time" class="form-control" placeholder="time" required="required">
							<label for="time">Time</label>
						</div>
					</div>
					<div class="form-floating mb-3 mt-3">
							<textarea type="note" id="note" rows="3" name="note" class="form-control" placeholder="note" ></textarea>
							<label for="note">Note</label>
					</div>
								
					<div class="d-flex justify-content-end mt-3">
						<button type="submit" name="reservation_form" class="btn btn-lg btn-outline-secondary "> Make a Reservation </button>
					</div>

				</form>
			</div>
		</div>		
	</section>
</body>