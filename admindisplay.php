<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
 	<head>
	<title>CS 304: WMDB</title>
	<!--Sara Burns & Shelley Wang-->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

	<!-- Bootstrap -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	
	 <link rel="stylesheet" href="./jquery-ui-1.11.4.custom/jquery-ui.css">
  	 <script src="./jquery-ui-1.11.4.custom/jquery-ui.js"></script>		
		

	 <script type="text/javascript">
		$(document).ready(
		function(){
		    $("#myTab a").click(function(e){
		    	e.preventDefault();
		    	$(this).tab('show');
		    });
		}
  });

		 


	</script>

	  <!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	  <![endif]-->
		<style>
			body {
	      font-family: 'Open Sans', sans-serif;
	      background: #ffffff;
	      color: #da5;
			}
	    h1 {
	      text-align: center;
	    }
	    li {
	    	font-size: 150%;
	    }
	    a:link, a:visited, a:active, a:hover {
	      color: #39f;
	    }
	    .jumbotron {
	    	background: #ffffff;
	    	background-repeat: no-repeat;
	    	padding-top: 0px;
	    	padding-bottom: 0px;
	    	margin-top: 0px;
	    	margin-bottom: 0px;
	    	overflow-x: hidden;
	    }

	    .bs-example{
		margin: 20px;
		}

		  #feedback { font-size: 1.4em; }
  #selectable .ui-selecting { background: #FECA40; }
  #selectable .ui-selected { background: #F39814; color: white; }
  #selectable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
  #selectable li { margin: 2px; padding: 0.4em; font-size: 1.0em; height: 20px; display:inline; }


		</style>
  </head>
  <body>
<?php 
//These files provides us the credentials and methods to work with our mysql database via MDB2
require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("cmsconnect-dsn.inc");

//connect to the db and return a db handle
$dbh = db_connect($cmsconnect_dsn);
$script = $_SERVER['PHP_SELF'];
$coach_query = "SELECT identifier from humans where bnumber = (SELECT coach from groups where groupid = ?)";

function populateList($category){
	global $dbh;
	$listcontents = "";
	$list_query = "";
	if($category == "groups"){
		$list_query = "SELECT composer,yr,currentgroup from pieces where currentgroup is not null";
		$resultset = query($dbh, $list_query);
		while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
    		$composer = $row['composer'];
    		$yr = $row['year'];
    		$currentgroup = $row['currentgroup'];
    		$coach_name = prepared_query($dbh, $person_query, array($currentgroup));
    		$listcontents += "<a href='$script?groupid=$currentgroup' class='list-group-item'>$composer($yr): $coach_name</a>";
 		}
 	}

 		return $listcontents;

}
if(isset($_REQUEST['category'])) populateList($_REQUEST['category']);

?>
<div class='row'>
<div class = 'col-md-1'><?php if(isset($_SESSION['email'])) echo 
"Hello ".$_SESSION['email']; ?></div>				<div class='col-md-1 col-md-offset-11'><a href="#">Admin</a>/<a href="#">Logout</a></div>
</div>

		<div class='jumbotron'>
			<h1>CMS Connect</h1>
		</div>
		<div class='jumbotron' style="background-size: 100% 750px;min-height:750px;">
<div class='row'>
	<div class='col-md-2 col-xs-2 col-md-offset-7'>

	<!-- Search Form -->
	     	<div class="searchform">
		<label for="sought">Search for...</label>
		<form method="get" name="sought" action="<?php echo $_SERVER['PHP_SELF'] ?>">
		    <div class="input-group">
		      	<input type="text" class="form-control" id="searchtext" placeholder="Search for...">
		     	<span class="input-group-btn">
		        	<input class="btn btn-default" type="submit" value="submit"></input>
		      	</span>
		    </div><!-- /input-group -->
		</form>
	
		</div>
	</div>
</div>



<div class='row'>
				<div class='col-md-1 col-xs-3'></div>
<div class='col-md-2 col-xs-2'>
        <p id="feedback">
<span>Viewing:</span> 
 
<ol id="selectable">
  <li id="groups" class="ui-widget-content">Groups</li>
  <li id="people"class="ui-widget-content">People</li>
  <li id="pieces" class="ui-widget-content">Pieces</li>
</ol>		     
<p>
	<div class="list-group" id="resultList" style="max-height:420px;overflow-y:auto;">
					  <a href="#sectionB" class="list-group-item active">
					    Cras justo odio
					  </a>
					  <a href="#sectionA" class="list-group-item">Dapibus ac facilisis in</a>
	</div>
</div>

<div class='col-md-6 col-xs-5' style="max-height:530px;overflow-y:auto;">

<script src = "admin.js"></script> 

<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->					
<div class="panel panel-default">
  <div class="panel-body" style="height: 500px;">
    <?php
    	//displays the profile of a group
    	if (isset($_GET['groupid'])) {
			// CASE 2
			// Directs to appropriate page if specific movie is clicked.
			$groupid = $_GET['groupid'];

			$values = array($groupid,$groupid);
			// Query to display title & release year of movie
			$sql = "SELECT composer,title,pid,meetingtime,rehearsaltime,coach,identifier FROM pieces inner join groups inner join humans 
					where groupid=? and bnumber=(select coach from groups where groupid=?)";
			$resultset = prepared_query($dbh,$sql,$values);
			// declare variable title for global usage
			//$title;

			// Display Group ID, Piece, Coach, Meeting Time, and Rehearsal Time
			while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){
				//global $title;
				$composer = $row['composer'];
				$title = $row['title'];
				$pid = $row['pid'];
				$meetingtime = $row['meetingtime'];
				$rehearsaltime = $row['rehearsaltime'];
				$coach = $row['coach'];
				$identifier = $row['identifier'];
				echo "<p>Group ID: $groupid
					<p>Piece: <a href='admindisplay.php?pid=$pid'>$composer $title</a>
					<p>Coach: <a href='admindisplay.php?bnumber=$coach'>$identifier</a>
					<p>Meeting Time: $meetingtime
					<p>Rehearsal Time: $rehearsaltime\n";
			}

			// Display list of members
			$values2 = array($groupid);

			echo"<p>Members:<ul>\n";
			$sql = "SELECT bnumber, identifier from humans INNER JOIN members using(bnumber) WHERE groupid=?";
			$resultset = prepared_query($dbh,$sql,$values2);
			$nr = $resultset->numRows();
			if ($nr > 0) {
				// Display cast only if it has a cast
				while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
					$bnumber = $row['bnumber'];
					$identifier = $row['identifier'];
					// we didn't have to pull out the data into variables, but doing so
					// makes the following line easy to read:
					echo "<li><a href='admindisplay.php?bnumber=$bnumber'>$identifier</a></li>\n";
				} // call to actorList function
			}
			echo "</ul>\n";

    	}
    	//Displays the profile of a person(human)
    	if (isset($_GET['bnumber'])) {
			// CASE 2
			// Directs to appropriate page if specific movie is clicked.
			$bnumber = $_GET['bnumber'];

			$values = array($bnumber, $bnumber);
			// Query to display title & release year of movie
			$sql = "SELECT identifier,email,instrument,status,admin,humans.yr,groupid,composer,title FROM humans INNER JOIN members USING(bnumber)
						INNER JOIN pieces WHERE bnumber=? and groupid=(select groupid from members where bnumber=?)";
			$resultset = prepared_query($dbh,$sql,$values);
			// declare variable title for global usage
			//$title;

			// Display Group ID, Piece, Coach, Meeting Time, and Rehearsal Time
			while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){
				//global $title;
				$identifier = $row['identifier'];
				$email = $row['email'];
				$instrument = $row['instrument'];
				$status = $row['status'];
				$admin = $row['admin'];
				$yr = $row['yr'];
				$groupid = $row['groupid'];
				$composer = $row['composer'];
				$title = $row['title'];

				echo "<p>Name: $identifier
					<p>Bnumber: $bnumber
					<p>Year: $yr
					<p>Instrument: $instrument
					<p>Status: $status
					<p>Admin?: $admin
					<p>Group: <a href='admindisplay.php?groupid=$groupid'>$composer $title</a>\n";
			}


    	}
    	//Displays the profile of a piece
    	if (isset($_GET['pid'])) {
			// CASE 2
			// Directs to appropriate page if specific movie is clicked.
			$pid = $_GET['pid'];

			//Show selected movie profile
			$values = array($pid);
			// Query to display title & release year of movie
			$sql = "SELECT title,yr,composer,currentgroup from pieces where pid=?";
			$resultset = prepared_query($dbh,$sql,$values);
			// declare variable title for global usage
			//$title;

			// Display Group ID, Piece, Coach, Meeting Time, and Rehearsal Time
			while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){				
				$title = $row['title'];
				$composer = $row['composer'];
				$yr = $row['yr'];
				$currentgroup = $row['currentgroup'];

				echo "<p>Piece ID: $pid
					<p>Title: $title
					<p>Composer: $composer
					<p>Year: $yr
					<p>Group: <a href='admindisplay.php?groupid=$currentgroup'>$composer $title</a>\n";
			}

    	}


    ?>
  </div>
</div>

<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
</div>




<!-- XXXXXX -->

<!-- End of Search Form -->

</div>


<!-- XXXXXX -->
			</div>
			
			
		</div>
		<div>
			<p align="center">Sara Burns and Shelley Wang</p>
		</div>
    

  </body>
</html>
