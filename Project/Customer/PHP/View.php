<html>
<head>
<link rel="stylesheet" href="../CSS/menu.css">
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
             <h1>Menu</h1>
        </div>
        
    </section>
<?php

include("..\\Includes\\functions\\database-connection.php");
/*$server="localhost";
$username="root";
$pass="";
$db="food";*/

$mysqli_connect= connect();

if($mysqli_connect->connect_error){
	exit('Error in connection');
}
?>

<div id="menu">
	<h1 id="section">Ramadan's Menu</h1>
	<div id="menu_row">

<?php
	$table = "drinks";
	$query = "SELECT * FROM drinks WHERE MENU_ID = '1'";
	$stmt = $mysqli_connect->prepare($query);
	$stmt->execute();
	$stmt->bind_result($id,$menuId,$name,$sprice,$mprice,$lprice);
	
		echo"<div id=\"menu_col\">";
			echo"<h2>Drinks</h2>";
	while($stmt->fetch()){	
			echo"<div class=\"box\">";
				echo"<div id=\"image\">";
					echo"<img src=\"../images/drinks.jpg\">";
				echo"</div>";
				echo"<div>";
					echo"<h3>".$name."</h3>";
					echo"<h4> S:".$sprice." M:".$mprice." L:".$lprice."</h4>";
				echo"</div>";
			echo"</div>";//close box
}
			
		echo"</div>";//close column
//close the form
echo "</form>";
//open a form
echo "<form method=\"post\" action = \"view.php\">";//method=\"post\" action = \"view.php\"

	//read the meals
	//then check if empty table don't view it 
	//else view the table 
	$table = "meals";
	$query = "SELECT * FROM meals WHERE MENU_ID = '1'";
	$stmt = $mysqli_connect->prepare($query);
	$stmt->execute();
	$stmt->bind_result($id,$menuId,$name,$sprice,$mprice,$lprice);
	echo"<div id=\"menu_col\">";
		echo"<h2>Meals</h2>";
	while($stmt->fetch()){
		echo"<div class=\"box\">";
					echo"<div id=\"image\">";
						echo"<img src=\"../images/meal.png\">";
					echo"</div>";
					echo"<div>";
						echo"<h3>".$name."</h3>";
						echo"<h4> S:".$sprice." M:".$mprice." L:".$lprice."</h4>";
					echo"</div>";
		echo"</div>";//close box
	}
				
	echo"</div>";//close column
	//close the form
	echo "</form>";
	//open a form
	echo "<form method=\"post\" action = \"view.php\">";


	//read the pizzas
	//then check if empty table don't view it 
	//else view the table 
	$table = "pizzas";
	$query = "SELECT * FROM pizzas WHERE MENU_ID = '1'";
	$stmt = $mysqli_connect->prepare($query);
	$stmt->execute();
	$stmt->bind_result($id,$menuId,$name,$sprice,$mprice,$lprice);
	echo"<div id=\"menu_col\">";
			echo"<h2>Pizzas</h2>";
	while($stmt->fetch()){
			echo"<div class=\"box\">";
						echo"<div id=\"image\">";
							echo"<img src=\"../images/pizza.jpg\">";
						echo"</div>";
						echo"<div>";
							echo"<h3>".$name."</h3>";
							echo"<h4> S:".$sprice." M:".$mprice." L:".$lprice."</h4>";
						echo"</div>";
			echo"</div>";//close box
		}
					
		echo"</div>";//close column
		//close the form
		echo "</form>";
		//open a form
		echo "<form method=\"post\" action = \"view.php\">";


//close the form
echo "</form>";
//open a form
echo "<form method=\"post\" action = \"view.php\">";


//read the salads
//then check if empty table don't view it 
//else view the table 
$table = "salads";
$query = "SELECT * FROM salads WHERE MENU_ID = '1'";
$stmt = $mysqli_connect->prepare($query);
$stmt->execute();
$stmt->bind_result($id,$menuId,$name,$sprice,$mprice,$lprice);
	echo"<div id=\"menu_col\">";
		echo"<h2>Salads</h2>";
	while($stmt->fetch()){
		echo"<div class=\"box\">";
					echo"<div id=\"image\">";
						echo"<img src=\"../images/salads.jpg\">";
					echo"</div>";
					echo"<div>";
						echo"<h3>".$name."</h3>";
						echo"<h4> S:".$sprice." M:".$mprice." L:".$lprice."</h4>";
					echo"</div>";
		echo"</div>";//close box
	}
				
	echo"</div>";//close column
//close the form
echo "</form>";
//open a form
echo "<form method=\"post\" action = \"view.php\">";


//read the sandwiches
//then check if empty table don't view it 
//else view the table 
$table = "sandwiches";
$query = "SELECT * FROM sandwiches WHERE MENU_ID = '1'";
$stmt = $mysqli_connect->prepare($query);
$stmt->execute();
$stmt->bind_result($id,$menuId,$name,$sprice,$mprice,$lprice);

	echo"<div id=\"menu_col\">";
		echo"<h2>Sandwiches</h2>";
	while($stmt->fetch()){
		echo"<div class=\"box\">";
					echo"<div id=\"image\">";
						echo"<img src=\"../images/sandwiches.jpg\">";
					echo"</div>";
					echo"<div>";
						echo"<h3>".$name."</h3>";
						echo"<h4> S:".$sprice." M:".$mprice." L:".$lprice."</h4>";
					echo"</div>";
		echo"</div>";//close box
	}
				
echo"</div>";//close column
//close the form
echo "</form>";
//open a form
echo "<form method=\"post\" action = \"view.php\">";


//read the sweets
//then check if empty table don't view it 
//else view the table 
$table = "sweets";
$query = "SELECT * FROM sweets WHERE MENU_ID = '1'";
$stmt = $mysqli_connect->prepare($query);
$stmt->execute();
$stmt->bind_result($id,$menuId,$name,$sprice,$mprice,$lprice);
echo"<div id=\"menu_col\">";
		echo"<h2>Sweets</h2>";
	while($stmt->fetch()){
		echo"<div class=\"box\">";
					echo"<div id=\"image\">";
						echo"<img src=\"../images/sweets.jpg\">";
					echo"</div>";
					echo"<div>";
						echo"<h3>".$name."</h3>";
						echo"<h4> S:".$sprice." M:".$mprice." L:".$lprice."</h4>";
					echo"</div>";
		echo"</div>";//close box
	}
				
echo"</div>";//close column
echo "</form>";

?>
	</div>
</div>
</body>
</html>