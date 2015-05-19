<!-- admin.php 
	Sara Burns and Shelley Wang
	This page is the admin dashboard, seen by an admin user when they first log in.
	From here, the admin can view and search all the members of CMS, all the groups, and all the pieces
	in the CMS library. It links to a page where they can create groups. -->
<?php session_start(); 
if ($_SESSION['admin'] == '0'){ header('Location: index.php', true, 303);};
	?>
<!DOCTYPE html>
<html lang="en">
 	<head>
	<title>CS 304: WMDB</title>
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

  	 <!--for working with cookies from javascript -->
  	 <script src="js.cookie.js"></script>
		

	 <script type="text/javascript">
	 	//this function assures that the correct search box is open, according to what box was selected
	 	function selectSearch(subject){
					if(!(subject == "groups" || subject == "pieces" || subject == "people")){
	 					subject = "groups";
	 				}
					$("#" + subject).addClass('ui-selected');
					if(subject == "groups"){
						$.post("coaches.php", {}, function(result){ $("label[for='sought']").text("Search group by coach");$("#searchtext").replaceWith("<select name = 'search' class='form-control' id='searchtext'>" + result + "</select>");});
					}else{
						$("label[for='sought']").text("Search for...");
						$("#searchtext").replaceWith('<input type="text" class="form-control" id="searchtext" name = "search" placeholder="' + $("#" + subject).text() + '">');
					}
					$.post("listview.php", 
					{"category": subject}, function(data){$("#resultList").empty().html(data);});

	 	}

	 	//we use a cookie to remember what box was selected, since the javascript is reloaded each time the page refreshes
	 	//we check the value of the cookie explicitly to make sure it cannot manipulate the page
		$(document).ready(
			function () {
				var selected = Cookies.get('selected');
				if(typeof(selected) == "undefined"){
					selectSearch("groups");
					console.log("cookie was undefined");
				}else{
					selectSearch(selected);
					console.log("cookie was defined");

				}
			}
		);

		 


	</script>

	  <!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	  <![endif]-->
		<style>
		html { height: 100%;}
			body {
	      font-family: 'Open Sans', sans-serif;
	      background: #ffffff;
	      color: #da5;
	      height: 100%;
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

		
		.panel > .panel-collapse {
			margin-left:20px;
		}

		  #feedback { font-size: 1.4em; }
  #selectable .ui-selecting { background: #FECA40; }
  #selectable .ui-selected { background: #F39814; color: white; }
  #selectable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
  #selectable li { margin: 2px; padding: 0.4em; font-size: 1.0em; height: 20px; display:inline; }

  .select-time .ui-selecting { background: #FECA40; }
  .select-time .ui-selected { background: #F39814; color: white; }

  .select-piece .ui-selecting { background: #FECA40; }
  .select-piece .ui-selected { background: #F39814; color: white; }

		</style>
  </head>
  <body>
<!-- if the user is signed in, their email will appear at the top -->
<div class='row'>
<div class = 'col-md-1'><?php if(isset($_SESSION['email'])) echo 
"Hello ".$_SESSION['email']; ?></div>				<div class='col-md-1 col-md-offset-11'><a href="people.php">Regular</a>/<a href="index.php">Logout</a></div>
</div>

		<div class='jumbotron'>
			<h1>CMS Connect</h1>
		</div>
		<div class='jumbotron' style="background-size: 100% 750px;min-height:750px;">
<div class='row'>
	<div class='col-md-2 col-xs-2 col-md-offset-1'>

	<!-- Search Form -->
	     	<div class="searchform">
		<label for="sought">Search for...</label>
		<form method="post" name="sought" action="<?php echo $_SERVER['PHP_SELF'] ?>">
		    <div class="input-group">
		      	<select name = "search" class='form-control' id="searchtext"><?php require_once "coaches.php"; ?></select>
		     	<span class="input-group-btn">
		        	<input class="btn btn-default" type="submit" value="submit"></input>
		      	</span>
		    </div><!-- /input-group -->
		</form>
	
		</div>
	</div>
<!--	<div class ='col-md-2 col-xs-2 col-md-offset-7'>
	<div class = 'panel panel-default'>
	     <div class = 'panel-body' style ='height: 500px;"></div>
	
</div> -->
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
					  
	</div>
</div>

<!--this script currently controls what happens when the tabs are clicked -->
<script>

//when the tab is clicked, load the appropriate information

$("#selectable").selectable({
      stop: function() {
        $( ".ui-selected", this ).each(function() {
        	clicked = $(this).attr("id");
		if(!(clicked == "groups" || clicked == "pieces" || clicked == "people")){
        		clicked = "groups";
        	}
        	if(clicked == "groups"){
        		$.post("coaches.php", {}, function(result){ $("label[for='sought']").text("Search group by coach");$("#searchtext").replaceWith("<select name='search' class='form-control' id='searchtext'>" + result + "</select>");});
        	}else{
        	$("label[for='sought']").text("Search by...");
        	$("#searchtext").replaceWith('<input type="text" class="form-control" id="searchtext" name = "search" placeholder="' + $(this).text() + '">');
        }
          	document.cookie = "selected=" + clicked; //allows selected to be saved across windows
          	$.post("listview.php", {"category": clicked}, function(data){$("#resultList").empty().html(data);});
    });
      }
    });

</script>

<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->

<div class='col-md-6 col-xs-5' style="max-height:530px;overflow-y:auto;">					
<div class="panel panel-default">
  <div class="panel-body" style="height: 500px;">
  	<button class="btn btn-default" data-toggle="modal" data-target="#myModal">Create Group</button>
    <?php

		require_once("MDB2.php");
		require_once("/home/cs304/public_html/php/MDB2-functions.php");
		require_once("cmsconnect-dsn.inc");

		$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

					// Additional headers
					$headers .= 'From: Chamber Music Society <cms@example.com>' . "\r\n";
		require_once("helpers.php");

		//connect to the db and return a db handle
		$dbh = db_connect($cmsconnect_dsn);
		$script = $_SERVER['PHP_SELF'];

		if(isset($_REQUEST['deletegroup'])){
			$update_statement = "update humans set ingroup=0 where bnumber in (select bnumber from members where groupid = ?)";
			$update = prepared_statement($dbh, $update_statement, array($_REQUEST['deletegroup']));
			$delete_statement = "delete from groups where groupid=?";
			$delete = prepared_statement($dbh, $delete_statement, array($_REQUEST['deletegroup']));
		}
		//if the new member is approved, their information is moved to the humans table
			if(isset($_REQUEST['approved'])){
				$find_query = "select * from unapproved where bnumber=?";
				$find = prepared_query($dbh, $find_query, array($_REQUEST['approvee']) );
				while($f = $find->fetchRow(MDB2_FETCHMODE_ASSOC)){
					$bnumber = $f['bnumber'];
					$email = $f['email'];
					$pw = $f['password'];
					$instrument = $f['instrument'];
					$status = $f['status'];
					$ingroup = $f['ingroup'];
					$admin = $f['admin'];
					$yr = $f['yr'];
					$id = $f['identifier'];
					$insert_statement = "insert into humans values (?,?,?,?,?,?,?,?,?)";
					$insert = prepared_statement($dbh, $insert_statement, array($bnumber, $email,$pw, $instrument, $status, $ingroup, $admin,
						$yr, $id));
				}
				mail($email,"Account Approved", "Hi $id,<p>We wanted to let you know that your CMSConnect has been approved. Click 
					<a href = 'http://cs.wellesley.edu/~cmsconnect/cmsconnect/beta/'>here</a> to login.<p>Thank you,<br>The CMS administrators", $headers);
				echo "$id added to database";
			}

		//either way, they are deleted from the unapproved table

			if(isset($_REQUEST['approvee'])){
			$delete_statement = "delete from unapproved where bnumber=?";
			$delete = prepared_statement($dbh, $delete_statement, array($_REQUEST['approvee']));
			//if they are denied, they are just not added to the humans table before being deleted
			if(isset($_REQUEST['denied'])){
			echo "Approval denied.";
		}
			}

		

		//handles when a new group is created
		if(isset($_REQUEST['new_pid'])){
			$c = $_REQUEST['new_coach'];
			//insert info into group table
			$insert_group = "INSERT INTO groups values (0,?,null,?)";
			$insert = prepared_statement($dbh, $insert_group, array($_REQUEST['new_coaching_time'], $_REQUEST['new_coach']));
			$group_ID = query($dbh, "SELECT last_insert_id()");
			while($id = $group_ID->fetchRow(MDB2_FETCHMODE_ASSOC)){
				$gid = $id['last_insert_id()'];
			}
			//insert info into pieces table(currentgroup playing)
			$insert_into_pieces = prepared_statement($dbh, "UPDATE pieces set currentgroup = ? where pid = ?", array($gid, $_REQUEST['new_pid']));

			//add members to join table
			$members = explode(";",$_REQUEST['new_members']);
			foreach($members as $m){
				$insert_member_query = "INSERT INTO members values (?, ?)";
				$insert_member = prepared_statement($dbh, $insert_member_query, array($m, $gid));
				$in_group = "UPDATE humans set ingroup = 1 where bnumber=?";
				$update_in_group = prepared_statement($dbh, $in_group,array($m));
			}
			array_push($members, $_REQUEST['new_coach']);
			foreach($members as $m){
				$rm_ct_statement = "DELETE from schedule where bnumber = ? and timeid = ?";
				$remove_coaching_time = prepared_statement($dbh, $rm_ct_statement, array($m, $_REQUEST['new_coaching_time']));
			}

			$find_piece_query = "SELECT title, composer from pieces where pid = ?";
			$find_piece = prepared_query($dbh, $find_piece_query, array($_REQUEST['new_pid']));
			while($p = $find_piece->fetchRow(MDB2_FETCHMODE_ASSOC)){
				$t = $p['title'];
				$c = $p['composer'];
			}

			$coach_name = "SELECT identifier from humans where bnumber = ?";
			$coach_result = prepared_query($dbh, $coach_name, array($_REQUEST['new_coach']));
			while($cr = $coach_result->fetchRow(MDB2_FETCHMODE_ASSOC)){
				$cn = $cr['identifier'];
			}
			sendEmailtoGroup(array_slice($members,0,2), "CMS Assignment", "Hello,<br>This message has 
				been sent to inform you that you have been assigned to a new CMS group. You will be playing $t by $c, coached by $cn. Please log on to <a href = '
				http://cs.wellesley.edu/~cmsconnect/cmsconnect/beta/'>CMSConnect</a> to find out more information. For students, please use the portal to 
				choose a rehearsal time in the next week. Thank you,<br>The CMS Administrators");
			echo "<p>The group has been added. An email has been sent asking members to set a rehearsal time.";

		}

			


	if(isset($_REQUEST['search'])){
		$searchterm = "%".htmlspecialchars($_REQUEST['search'])."%";
		$search_sanitized = htmlspecialchars($_REQUEST['search']);
		$search_cat = empty($_COOKIE['selected']) ? "groups": $_COOKIE['selected'];
		if($search_cat == "people"){
		//search currently only handles searching people
		$search_query = "SELECT * from humans where identifier like ?";
		$search = prepared_query($dbh, $search_query, array($searchterm));
		if ($search -> numRows() == 0) echo "<p>No results found for '$search_sanitized'";
		else echo "<p>Results for $search_sanitized";
		while($result = $search->fetchRow(MDB2_FETCHMODE_ASSOC)){
			      $name = $result['identifier'];
			      $bnumber = $result['bnumber'];
			       echo "<p><a href='admin.php?bnumber=$bnumber'>$name</a><br>";
			}

		}else if($search_cat == "pieces"){
			$search_query = "SELECT * from pieces where composer like ? or title like ?";
			$search_result = prepared_query($dbh, $search_query, array($searchterm, $searchterm));
			if ($search_result -> numRows() == 0) echo "<p>No results found for $search_sanitized";
			else echo "<p>Results for $search_sanitized";
			while($result = $search_result->fetchRow(MDB2_FETCHMODE_ASSOC)){
			      $title = $result['title'];
			      $composer = $result['composer'];
			      $pid = $result['pid'];
			       echo "<p><a href='admin.php?pid=$pid'>$composer: $title</a><br>";
			}


		}else{
			$search_query = "select * from groups,pieces where groupid=currentgroup and coach like ?";
			$coach_name = prepared_query($dbh, "select identifier from humans where bnumber =?", array($search_sanitized));
			$search = prepared_query($dbh, $search_query, array($searchterm));
			$coach_nm = "";
			while($cn = $coach_name -> fetchRow(MDB2_FETCHMODE_ASSOC)){
				$coach_nm = $cn['identifier'];
			}
			if ($search -> numRows() == 0) echo "<p>No groups coached by $coach_nm";
			else echo "<p>Groups coached by $search_sanitized";	
			while($result = $search->fetchRow(MDB2_FETCHMODE_ASSOC)){
			      $title = $result['title'];
			      $composer = $result['composer'];
			      $gid = $result['groupid'];
			       echo "<p><a href='admin.php?groupid=$gid'>$title: Group $gid</a><br>";
			}


		} 



	}

		

    	//displays the profile of a group
    	if (isset($_REQUEST['groupid'])) {
			$groupid = $_REQUEST['groupid'];

			$values = array($groupid,$groupid);
			// Query to display group info, collects info about members and the piece based on groupid
			$sql = "SELECT composer,title,pid,meetingtime,rehearsaltime,coach,identifier FROM pieces,groups,humans where groupid = currentgroup and groupid=? and bnumber=(select coach from groups where groupid=?)";
			$resultset = prepared_query($dbh,$sql,$values);

			// Display piece, meeting time, rehearsal time, and coach
			while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){
				//global $title;
				$composer = $row['composer'];
				$title = $row['title'];
				$pid = $row['pid'];
				$meetingtime = implode("", makePretty(array($row['meetingtime'])));
				$rehearsaltime = $row['rehearsaltime'];
				$coach = $row['coach'];
				$identifier = $row['identifier'];
				echo "<p>
					<p><strong>Group ID: </strong>$groupid
					<p><strong>Piece: </strong><a href='admin.php?pid=$pid'>$composer $title</a>
					<p><strong>Coach:</strong> <a href='admin.php?bnumber=$coach'>$identifier</a>
					<p><strong>Meeting Time:</strong> $meetingtime
					<p><strong>Rehearsal Time:</strong> $rehearsaltime\n";
			}

			// Display list of members
			$values2 = array($groupid);

			echo"<p><strong>Members:</strong><ul>\n";
			$sql = "SELECT bnumber, identifier from humans INNER JOIN members using(bnumber) WHERE groupid=?";
			$resultset = prepared_query($dbh,$sql,$values2);
			$nr = $resultset->numRows();
			if ($nr > 0) {
				while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)) {
					$bnumber = $row['bnumber'];
					$identifier = $row['identifier'];
					
					echo "<li><a href='admin.php?bnumber=$bnumber'>$identifier</a></li>\n";
				} 
			}
			echo "</ul>\n";
			echo "<form name = 'delete' method = 'post' action='$script'><input type='hidden' name='deletegroup' value='$groupid'></input><input type='submit' class='btn btn-default' value='Delete Group'></input></form>";
    	}


    	//Displays the profile of a person(human)
    	if (isset($_REQUEST['bnumber'])) {
			$bnumber = $_REQUEST['bnumber'];
			$values = array($bnumber);
			// Query to find out whether or not the person(human) is already in a group
			$ingroupquery = "SELECT ingroup FROM humans WHERE bnumber=?";
			$resultset = prepared_query($dbh,$ingroupquery,$values);
			while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){
				$ingroup= $row['ingroup'];
			}

			if ($ingroup == 1){
				$values = array($bnumber, $bnumber);
				// Query to display information about an individual
				$individual = "SELECT identifier,email,instrument,status,admin,humans.yr,groupid,composer,title FROM (humans INNER JOIN members USING(bnumber)),pieces WHERE bnumber=? and currentgroup=groupid and groupid=(select groupid from members where bnumber=?)";
				$resultset = prepared_query($dbh,$individual,$values);
		

				// Display name, email, instrument, status, class year, current group/piece
				while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){
					$identifier = $row['identifier'];
					$email = $row['email'];
					$instrument = $row['instrument'];
					$status = $row['status'];
					$admin = $row['admin'] == "0" ? "No": "Yes";
					$yr = isset($row['yr']) ? $row['yr'] : "N/A";
					$groupid = $row['groupid'];
					$composer = $row['composer'];
					$title = $row['title'];

					echo "<p>
						<p><strong>Name: </strong>$identifier
						<p><strong>Bnumber: </strong>$bnumber
						<p><strong>Year: </strong> $yr
						<p><strong>Instrument:</strong> $instrument
						<p><strong>Status:</strong> $status
						<p><strong>Admin?:</strong> $admin
						<p><strong>Group: </strong><a href='admin.php?groupid=$groupid'>$composer $title</a>\n";
				}
			}else{
				//they are not in a group, so don't look for group info
				$values = array($bnumber);
				// Query to display information about an individual
				$individual = "SELECT identifier,email,instrument,status,admin,humans.yr FROM humans where bnumber=?";
				$resultset = prepared_query($dbh,$individual,$values);
				

				// Display name, email, instrument, status, class year
				while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){
					$identifier = $row['identifier'];
					$email = $row['email'];
					$instrument = $row['instrument'];
					$status = $row['status'];
					$admin = $row['admin'] == "0" ? "No": "Yes";
					$yr = isset($row['yr']) ? $row['yr'] : "N/A";
					$group = $status == "coach" ? "coach" : "Unassigned";

					echo "<p>
						<p><strong>Name:</strong> $identifier
						<p><strong>Bnumber:</strong> $bnumber
						<p><strong>Year: </strong>$yr
						<p><strong>Instrument: </strong>$instrument
						<p><strong>Status: </strong> $status
						<p><strong>Admin?: </strong>$admin
						<p><strong>Group: </strong>$group\n";
				}


			}


    	}
    	//Displays the profile of a piece
    	if (isset($_REQUEST['pid'])) {
			$pid = $_REQUEST['pid'];

			$values = array($pid);
			// Query to display info for piece clicked
			$sql = "SELECT title,yr,composer,currentgroup from pieces where pid=?";
			$resultset = prepared_query($dbh,$sql,$values);
			
			// Display title, composer, year, and current group playing
			while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){				
				$title = $row['title'];
				$composer = $row['composer'];
				$yr = substr($row['yr'],0,4);
				$currentgroup = $row['currentgroup'];

				echo "<p>
					<p><strong>Piece ID:</strong> $pid
					<p><strong>Title:</strong> $title
					<p><strong>Composer:</strong> $composer
					<p><strong>Year:</strong> $yr
					<p><strong>Group:</strong> ";
				if($currentgroup != "")	echo "<a href='admin.php?groupid=$currentgroup'>$composer $title</a>\n";
				else echo "None";
			}

			$instrumentation_query = "SELECT * from instrumentation where pid = ?";
			$instrument_result = prepared_query($dbh, $instrumentation_query, $values);

			echo "<p><strong>Instruments: </strong> <br>";
			while($ins = $instrument_result->fetchRow(MDB2_FETCHMODE_ASSOC)){
				$inst = $ins['instrument'];
				echo "$inst<br>";
			}

    	}

    	if (isset($_REQUEST['bnumberu'])){

    			$values = array($_REQUEST['bnumberu']);
				// Query to display information about an individual
				$individual = "SELECT * FROM unapproved where bnumber=?";
				$resultset = prepared_query($dbh,$individual,$values);
				

				// Display name, email, instrument, status, class year
				while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){
					$identifier = $row['identifier'];
					$email = $row['email'];
					$instrument = $row['instrument'];
					$status = $row['status'];
					$yr = $row['yr'];
					$bnumber = $row['bnumber'];

					echo "<p><strong>Name: </strong>$identifier
						<p><strong>Bnumber:</strong> $bnumber
						<p><strong>Year: </strong> $yr
						<p><strong>Instrument:</strong> $instrument
						<p><strong>Status: </strong>$status\n";
				}
				echo "<form name = 'approve' method = 'post' action='$script'><input type='hidden' value='$bnumber' name='approvee'></input><input type='submit' class='btn btn-default' name='denied' value='Delete'></input>
				<input type='submit' class= 'btn btn-default' name='approved' value='Approve'></form>";
    	}


    ?>
  </div>
</div>

</div>
<div class="col-md-2">

	<span><p>Unapproved Accounts</span>
    <div class="panel panel-default">
    
        <div class="panel-body">
        	<?php
        	$query_result = query($dbh, "select * from unapproved");
        	if($query_result->numRows() == 0) echo "No one awaiting approval.";
        	while($m = $query_result->fetchRow(MDB2_FETCHMODE_ASSOC)){
        		$bnumber = $m['bnumber'];
        		$name = $m['identifier'];
        		$instrument = $m['instrument'];
        		echo "<a href='admin.php?bnumberu=$bnumber'>$name,$instrument</a>";
        	}

        	?></div>

    </div>


</div>




<!-- XXXXXX -->

<!-- End of Search Form -->

</div>

<!-- XXXXXXXXXXXXX 
	Begin modal contents -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="Create Group" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create Group</h4>
      </div>
      <div class="modal-body">
      	<div id="group_form">			
        <form method="post" id = "cg" action="<?php $_SERVER['PHP_SELF'] ?>">
      		<!-- first screen of modal form, loaded automatically, others loaded via AJAX -->
      		<div id ="choose_members">
      			<?php
        			require_once("choose-members.php");

        		?>
        	</div>
        	<!-- second screen of modal form -->
        	<div id ="choose_piece">
        	</div>
        	<!-- third screen of modal form -->
        	<div id = "choose_rehearse"></div>
			<!-- hidden inputs allow for more flexible form interaction -->        
        	<input type="hidden" name = "new_coach"></input>
        	<input type="hidden" name = "new_members"></input>
        	<input type="hidden" name = "new_coaching_time"></input>
        	<input type="hidden" name = "new_pid"></input>
        	<!-- <input type="hidden" name = "new_rehearsal"></input> -->


        </form> </div>
        	<!-- part of a mild form of form verification -->
        	<label id="error">Please select a time to rehearse and try again</label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="redo" data-dismiss="modal">Start Over</button>
        <button type="button" class="btn btn-primary" id= "add" name="add">Choose Piece</button>
      </div>
    </div>
  </div>
</div>

<script>


  $("#choose_piece").hide();
  $(".panel > .panel-collapse").collapse("hide");
  $('#myModal').modal({show:false}).on('shown.bs.modal', function () {
  $('#myInput').focus()
});

  // var current_members, instruments, coach, coachID, cTime, coachAdded, cTimeAdded;
  //three text states for the submit button
  var addButtons = ["Choose Piece", "Choose Rehearsal Time", "Create Group"];

    //resets the modal and form to their initials states
  function startOver(){
  	$(".modal").find(".ui-selected").removeClass("ui-selected");
  	//reset the variables which hold the form input
  	coach = "";
  	coachID = "";
  	current_members = [];
  	cTime = "";
  	cTimeAdded=false;
  	coachAdded=false;
	instruments = [];
	//reset the labels and go back to the first screen
  	$(".current_labels").remove();
  	$("#choose_piece,#choose_rehearse").hide();
  	$("#group_form").find("input[type='hidden']").val("");
  	$("#choose_members").show();
  	$("#add").text(addButtons[0]);
  }

  
  startOver();


  $(".select-time").selectable({
    	selected: function(){
    		$(".ui-selected", this).each(function(){
    			$(this).addClass("s");
    			// var current = this;
    			var timeslot = $(this).parent().attr("id");
    			$( ".select-time").filter(function(){return $(this).attr("id") != timeslot;}).selectable("disable");
    			// console.log($(".select-time").parent().not("#" + timeslot));
    			//somehow needs to be called outside of initialization block 
    			
    			//panels that don't contain that time slot are disabled(can be reenabled when a time is unselected)
				// $(this).closest(".panel-group").children().filter(function(){
				// return $(this).find("#" + timeslot).length == 0}).find("a").attr("data-toggle", "").css("color", "#828282");
				//record who is currently selected as part of this group/when the coaching time is, and display it
				if(!coachAdded){//the coach is the person in the outer panel list, the members are in the inner panel list
					coach = $(this).closest(".panel-group").closest(".panel").find("a").first().text().trim();
				 	$("#coach").append("<span class ='current_labels'>" + coach);
				 	coachID = $(this).closest(".panel-group").closest(".panel").find(".coach_name").attr("id");
				 	coachAdded = true;
				}
				var new_member = $(this).closest(".panel").find(".member_name").text();
				var member_id = $(this).closest(".panel").find(".member_name").attr("id");
				var instrument = $(this).closest(".panel").find(".instrument").text().trim();
				if(current_members.indexOf(member_id) < 0){
					current_members.push(member_id); 
					$("#members").append("<span class ='current_labels " + member_id + "'>" + new_member+"</span> ");
					instruments.push(instrument);
				}
				if(!cTimeAdded){
					cTime = $(this).parent().attr("id").trim();
					$("#ctime").append("<span class ='current_labels " + cTime + "'>" + $(this).text());
					cTimeAdded = true;
				}


    		});

    	},
    	//when a timeslot is unselected, this function is evaluated
    	unselected: function(){
    		$(".ui-selectee",this).each(function(){
    		var timeslot = $(this).parent().attr("id");
    		$( ".select-time").filter(function(){return $(this).attr("id") != timeslot;}).selectable("enable");
    		$(this).closest(".panel-group").children().filter(function(){
				return $(this).find("#" + timeslot).length == 0}).find("a").attr("data-toggle", "collapse").css("color", "#8ba9fe");
    		var mid = $(this).closest(".panel").find(".member_name").attr("id");
    			current_members.splice(current_members.indexOf(mid),1);
    			instruments.splice(instruments.indexOf($(this).closest(".panel").find(".instrument").text().trim()),1);
    			$("." + mid).remove();
    		if((current_members.length == 0) && coachAdded && coach == $(this).closest(".panel-group").closest(".panel").find("a").first().text().trim()){
    			coach = "";
    			$("#coach").text("Coach: ");
    			coachAdded = false;
    		}

    		if((current_members.length == 0) && cTimeAdded){
    			var ct = timeslot.trim();
    			if($(".current_labels." + ct).text() == $(this).text()){
    			$(".current_labels." + ct).remove();
    			cTimeAdded = false;
    		}

    		}


    		
    	});
    }

    });


 $("#error").hide();

  $("#add").on('click', function(event){
  	//these if statements determine what stage of group creation we're on
  	if($(this).text() == addButtons[0]){
  	$("#error").hide();
  	//mild form verification(don't need a lot since no user submitted data)
  	if(coach == "" || cTime == "" || members.length == 0){
  		$("#error").show();
  		return false;
  	}else{
  	//set necessary form inputs from current screen and move to next stage
  	$("input[name='new_coach']").val(coachID);
  	$("input[name='new_members']").val(current_members.join(";"));
  	$("input[name='new_coaching_time']").val(cTime);
  	// var inputString = "coach=" + coach + "&members=" + current_members.join(';') + "&cTime=" + cTime;
  	$.post("choose-piece.php", {"instruments": instruments.join(";")}, function(response){$("#choose_piece").html(response);$(".select-piece").selectable();});
  	$("#choose_members").hide();
  	$("#choose_piece").show();
  	$("#add").text(addButtons[1]);
  	  }

  	}else if($(this).text() == addButtons[1]){
  		//move onto the third stage
  		$("input[name='new_pid']").val($("input[name='options']:checked").attr("id"));
  		$("#add").text(addButtons[2]);
  		console.log($("#add").text());
  		//modal body is populated with html produced by choose-rehearse
  		$.post("choose-rehearse.php", {"members": current_members.join(";"), "coaching_time": cTime}, function(response){$("#choose_rehearse").html(response);});
  		 $("#choose_piece").hide();
  		 $("#choose_rehearse").show();
  	
   	}else if($(this).text() == addButtons[2]){
   		//time to submit, make sure to save the last form input
   		$("input[name='rehearsal']").val($("input[name='roptions']:checked").attr("id"));
		$("#cg").trigger("submit");
		 startOver();
   	}

  });
  

  $('#redo').on("click", function(){
  	startOver();
  });


</script>


<!-- XXXXXX 
	End modal contents -->
			</div>
			
			
		</div>
		<div>
			<p align="center">Sara Burns and Shelley Wang</p>
		</div>
    

  </body>
</html>