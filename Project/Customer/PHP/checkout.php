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

            if(isset($_POST['order_form']))
            {
				$mysqli_connect= connect();

				if($mysqli_connect->connect_error){
					exit('Error in connection');
				}

                // Selected Date and Time

                $date = $_POST['date'];
                $time = $_POST['time'];

                $selected_time = $date." ".$time;
				
				$address = $_POST['address'];
				
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
					
                    $sqlorder = "insert into orders(client_id,date, address) values(?,?,?)";
                    $stmt_order = $mysqli_connect->prepare($sqlorder);
					$stmt_order->bind_param("iss",$client_id,$selected_time,$address);
                    $stmt_order->execute();
                    
                    echo "<div class = 'alert alert-success p-3 mt-3'>";
                        echo "Great! Your Order has been created successfully.";
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
				<form method="POST" action="checkout.php">
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
							<input type="tel" id="phone" name="phone" class="form-control" placeholder="phone" required="required">
							<label for="phone">Telephone Number</label>
						</div>
						<div class="col-6 form-floating mb-3 mt-3">
							<input type="email" id="email" name="email" class="form-control" placeholder="Email" required="required">
							<label for="email">Email</label>
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
							<input type="text" id="address" name="address" class="form-control" placeholder="address" required="required">
							<label for="address">Address</label>
						</div>
								
					<div class="d-flex justify-content-end mt-3">
						<button type="submit" name="order_form" class="btn btn-lg btn-outline-secondary "> Order </button>
					</div>

				</form>
			</div>
		</div>		
	</section>
</body>