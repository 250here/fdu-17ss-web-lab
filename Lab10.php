<?php
//Fill this place

//****** Hint ******
//connect database and fetch data here


$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = '';          // mysql用户名密码
$dbname = 'travel';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if ( mysqli_connect_errno() ) {
    die( mysqli_connect_error() );  
}
$sql1 = 'select ContinentCode,ContinentName from continents';
$result1 = mysqli_query($conn, $sql1);
if(!$result1 )
{
    die('无法读取数据: ' . mysqli_error($conn));
}
$sql2='select ISO,CountryName from countries';
$result2 = mysqli_query($conn, $sql2);
if(!$result2 )
{
    die('无法读取数据: ' . mysqli_error($conn));
}
$sql3='select * from imagedetails';
$result3 = mysqli_query($conn, $sql3);
if(!$result3 )
{
    die('无法读取数据: ' . mysqli_error($conn));
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Chapter 14</title>

      <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    
    

    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />    

</head>

<body>
    <?php include 'header.inc.php'; ?>
    


    <!-- Page Content -->
    <main class="container">
        <div class="panel panel-default">
          <div class="panel-heading">Filters</div>
          <div class="panel-body">
            <form action="Lab10.php" method="post" class="form-horizontal">
              <div class="form-inline">
              <select name="continent" class="form-control">
                <option value="0">Select Continent</option>
                <?php
                //Fill this place
				
                //****** Hint ******
                //display the list of continents

                while($row = $result1->fetch_assoc()) {
                  echo '<option value=' . $row['ContinentCode'] . '>' . $row['ContinentName'] . '</option>';
                }

                ?>
              </select>     
              
              <select name="country" class="form-control">
                <option value="0">Select Country</option>
                <?php 
                //Fill this place
				while($row = $result2->fetch_assoc()) {
                  echo '<option value=' . $row['ISO'] . '>' . $row['CountryName'] . '</option>';
                }
                //****** Hint ******
                /* display list of countries */ 
                ?>
              </select>    
              <input type="text"  placeholder="Search title" class="form-control" name=title>
              <button type="submit" class="btn btn-primary">Filter</button>
              </div>
            </form>

          </div>
        </div>     
                                    

		<ul class="caption-style-2">
            <?php 
            //Fill this place
		    	function check($row){
					if(count($_POST)==0){
						return true;
					}
			        $continent=$_POST['continent'];
			        $country=$_POST['country'];
		        	$title=$_POST['title'];
				    $a=false;
					if(($continent === '0')||(strcmp($continent,$row['ContinentCode'])===0)){
						if(($country=== '0')||(strcmp($country,$row['CountryCodeISO'])===0)){
						if(($title == "")||(strpos($row['Title'],$title) == 1)){
								$a=true;
							}
					    }
				    }
				    return $a;
		    	}
		    	while($row = $result3->fetch_assoc()) {
		    		if(check($row)){
		    			echo '<li><a href="detail.php?id=' . $row['ImageID'] . '" class="img-responsive">';
			    		echo '<img src="images/square-medium/' . $row['Path'] . '" alt="' . $row['Title'] . '">';
		    			echo '<div class="caption"><div class="blur"></div><div class="caption-text"><p>' . $row['Title'] . '</p></div></div></a></li>';
			    	}
                }
            mysqli_close($conn);
            //****** Hint ******
            /* use while loop to display images that meet requirements ... sample below ... replace ???? with field data
            <li>
              <a href="detail.php?id=????" class="img-responsive">
                <img src="images/square-medium/????" alt="????">
                <div class="caption">
                  <div class="blur"></div>
                  <div class="caption-text">
                    <p>????</p>
                  </div>
                </div>
              </a>
            </li>        
            */ 
            ?>
       </ul>       

      
    </main>
    
    <footer>
        <div class="container-fluid">
                    <div class="row final">
                <p>Copyright &copy; 2017 Creative Commons ShareAlike</p>
                <p><a href="#">Home</a> / <a href="#">About</a> / <a href="#">Contact</a> / <a href="#">Browse</a></p>
            </div>            
        </div>
        

    </footer>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>