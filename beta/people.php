<!-- people.php
	Sara Burns and Shelley Wang
	This is the landing page for non-admins. -->
<?php session_start();

	require_once("MDB2.php");
	//require_once("calhelp.php");
	require_once("/home/cs304/public_html/php/MDB2-functions.php");
	require_once("cmsconnect-dsn.inc");
	$dbh = db_connect($cmsconnect_dsn);
	
	if(isset($_SESSION['email'])){
		$email = $_SESSION['email'];
		$values = array($email);
		// Query to display title & release year of movie
		$sql = "SELECT bnumber FROM humans where email=?";
		$resultset = prepared_query($dbh,$sql,$values);
		//Get user's bnumber
		while($row = $resultset->fetchRow(MDB2_FETCHMODE_ASSOC)){
			$bnumber = $row['bnumber'];
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
 	<head>
	<title>CS 304: WMDB</title>
	<!--Sara Burns & Shelley Wang-->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>


	<!-- CSS -->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

	<!-- Bootstrap -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

	
	<script src="https://code.jquery.com/jquery.js"></script>

	<!-- Will eventually have modal for user to choose rehearsal time -->
	<script type="text/javascript">
		$('#myModal').on('shown.bs.modal', function (event) {
			$('#myInput').focus();
			// if ($(event.target).hasClass("modally")) {
			// 	$.ajax
			// 	  ({
			// 	    type: "POST",
			// 	    url: "choose-rehearse.php",
			// 	    data: {'notfree': addid},
			// 	    success: function(msg)
			// 	    {
			// 	     $("#myModal").html(msg);
			// 	    }
			// 	  });
			//   });
		});

		// $(".test2").click(function(event){
		// 	//alert("test2 was a whee");

		// 	if ($(event.target).hasClass("inschedule")) {

		// 			  });
		// });
	</script>

		<style>
			body {
	      font-family: 'Open Sans', sans-serif;
	      background: #ffffff;
	      color: #da5;
	      box-sizing: border-box;
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

		.inschedule{
			background-color: #9EC5A6;
		}

		.meeting{
			background-color: #8EB4B7;
		}

		.rehearsal{
			background-color: #E6D899;
		}

		td:hover { background-color: #98E6E6 !important; }

		table { table-layout: fixed; }
		td { word-wrap: break-word; width: 12.5%; }

		</style>
  </head>
  <body>


<div class='row'>
<div class = 'col-md-1'>
	<?php if(isset($_SESSION['email'])) echo "Hello ".$_SESSION['email']; ?>
</div>

<div class='col-md-1 col-md-offset-11'><a href="admin.php">Admin</a>/<a href="login.php">Logout</a></div>
</div>

		<div class='jumbotron'>
			<h1>CMS Connect</h1>
		</div>
		<div class='jumbotron'>



<div class='row'>
<div class='col-md-1 col-xs-3 col-md-offset-1'><input class="btn btn-default btn-sm modally" data-toggle="modal" data-target="#myModal" value="Choose Rehearsal Time"></input>
</div>
<!-- MODAL HERE XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="Create Group" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Choose Rehearsal Time</h4>
      </div>
      <div class="modal-body">
          <div id="group_form">            
        <form method="post" id = "cg" action="<?php $_SERVER['PHP_SELF'] ?>">
              <!-- first screen of modal form, loaded automatically, others loaded via AJAX -->
              <div id ="choose_rehearse">
                  <?php
                    require("choose-rehearse.php");

                    // if(isset($_REQUEST['rehearsal'])){
                    // 	echo "$_REQUEST['rehearsal']";
                    // 	// $c = $_REQUEST['new_coach'];
                    // 	// //insert info into group table
                    // 	// $insert_group = "INSERT INTO groups values (0,?,null,?)";
                    // 	// $insert = prepared_statement($dbh, $insert_group, array($_REQUEST['new_coaching_time'], $_REQUEST['new_coach']));
                    // 	// $group_ID = query($dbh, "SELECT last_insert_id()");
                    // 	// while($id = $group_ID->fetchRow(MDB2_FETCHMODE_ASSOC)){
                    // 	// 	$gid = $id['last_insert_id()'];
                    // 	// }
                    // 	// //insert info into pieces table(currentgroup playing)
                    // 	// $insert_into_pieces = prepared_statement($dbh, "UPDATE pieces set currentgroup = ? where pid = ?", array($gid, $_REQUEST['new_pid']));

                    // 	// //add members to join table
                    // 	// $members = explode(";",$_REQUEST['new_members']);
                    // 	// foreach($members as $m){
                    // 	// 	$insert_member_query = "INSERT INTO members values (?, ?)";
                    // 	// 	$insert_member = prepared_statement($dbh, $insert_member_query, array($m, $gid));
                    // 	// 	$in_group = "UPDATE humans set ingroup = 1 where bnumber=?";
                    // 	// 	$update_in_group = prepared_statement($dbh, $in_group,array($m));
                    // 	// }
                    // 	// array_push($members, $_REQUEST['new_coach']);
                    // 	// foreach($members as $m){
                    // 	// 	$rm_ct_statement = "DELETE from schedule where bnumber = ? and timeid = ?";
                    // 	// 	$remove_coaching_time = prepared_statement($dbh, $rm_ct_statement, array($m, $_REQUEST['new_coaching_time']));
                    // 	// }

                    // 	// $find_piece_query = "SELECT title, composer from pieces where pid = ?";
                    // 	// $find_piece = prepared_query($dbh, $find_piece_query, array($_REQUEST['new_pid']));
                    // 	// while($p = $find_piece->fetchRow(MDB2_FETCHMODE_ASSOC)){
                    // 	// 	$t = $p['title'];
                    // 	// 	$c = $p['composer'];
                    // 	// }

                    // 	// $coach_name = "SELECT identifier from humans where bnumber = ?";
                    // 	// $coach_result = prepared_query($dbh, $coach_name, array($_REQUEST['new_coach']));
                    // 	// while($cr = $coach_result->fetchRow(MDB2_FETCHMODE_ASSOC)){
                    // 	// 	$cn = $cr['identifier'];
                    // 	// }
                    // 	// sendEmailtoGroup(array_slice($members,0,2), "CMS Assignment", "Hello,<br>This message has 
                    // 	// 	been sent to inform you that you have been assigned to a new CMS group. You will be playing $t by $c, coached by $cn. Please log on to CMSConnect to find out more information. For students, please use the portal to 
                    // 	// 	choose a rehearsal time in the next week. Thank you,<br>The CMS Administrators");
                    // 	// echo "<p>The group has been added. An email has been sent asking members to set a rehearsal time.";

                    // }
                ?>
            </div>

        </form> </div>
            <!-- part of a mild form of form verification -->
            <!-- <label id="error">Please select a time to rehearse and try again</label> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="redo" data-dismiss="modal">Start Over</button>
        <button type="button" class="btn btn-primary" id= "add" name="add">Choose Piece</button>
      </div>
    </div>
  </div>
</div>				
				
<!-- END MODAL HERE XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->				
<div class='col-md-6 col-xs-5 col-md-offset-1' style="max-height:620px;overflow-y:auto;">

<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->					
<!-- Insert calendar here -->
<span class="test2">
		<?php
			require_once("calhelp.php");
			if(isset($_REQUEST['rehearsal'])){
				$rehearse=$_REQUEST['rehearsal'];
				echo "Rehearsal is $rehearse";
				// $c = $_REQUEST['new_coach'];
				// //insert info into group table
				// $insert_group = "INSERT INTO groups values (0,?,null,?)";
				// $insert = prepared_statement($dbh, $insert_group, array($_REQUEST['new_coaching_time'], $_REQUEST['new_coach']));
				// $group_ID = query($dbh, "SELECT last_insert_id()");
				// while($id = $group_ID->fetchRow(MDB2_FETCHMODE_ASSOC)){
				// 	$gid = $id['last_insert_id()'];
				// }
				// //insert info into pieces table(currentgroup playing)
				// $insert_into_pieces = prepared_statement($dbh, "UPDATE pieces set currentgroup = ? where pid = ?", array($gid, $_REQUEST['new_pid']));

				// //add members to join table
				// $members = explode(";",$_REQUEST['new_members']);
				// foreach($members as $m){
				// 	$insert_member_query = "INSERT INTO members values (?, ?)";
				// 	$insert_member = prepared_statement($dbh, $insert_member_query, array($m, $gid));
				// 	$in_group = "UPDATE humans set ingroup = 1 where bnumber=?";
				// 	$update_in_group = prepared_statement($dbh, $in_group,array($m));
				// }
				// array_push($members, $_REQUEST['new_coach']);
				// foreach($members as $m){
				// 	$rm_ct_statement = "DELETE from schedule where bnumber = ? and timeid = ?";
				// 	$remove_coaching_time = prepared_statement($dbh, $rm_ct_statement, array($m, $_REQUEST['new_coaching_time']));
				// }

				// $find_piece_query = "SELECT title, composer from pieces where pid = ?";
				// $find_piece = prepared_query($dbh, $find_piece_query, array($_REQUEST['new_pid']));
				// while($p = $find_piece->fetchRow(MDB2_FETCHMODE_ASSOC)){
				// 	$t = $p['title'];
				// 	$c = $p['composer'];
				// }

				// $coach_name = "SELECT identifier from humans where bnumber = ?";
				// $coach_result = prepared_query($dbh, $coach_name, array($_REQUEST['new_coach']));
				// while($cr = $coach_result->fetchRow(MDB2_FETCHMODE_ASSOC)){
				// 	$cn = $cr['identifier'];
				// }
				// sendEmailtoGroup(array_slice($members,0,2), "CMS Assignment", "Hello,<br>This message has 
				// 	been sent to inform you that you have been assigned to a new CMS group. You will be playing $t by $c, coached by $cn. Please log on to CMSConnect to find out more information. For students, please use the portal to 
				// 	choose a rehearsal time in the next week. Thank you,<br>The CMS Administrators");
				// echo "<p>The group has been added. An email has been sent asking members to set a rehearsal time.";

			}
	?>
</span>

<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
</div>

<div class='col-md-2 col-xs-2'>
<!-- ********************************************* -->
		<script>
			$(".test2").click(function(event){
				//alert("test2 was a whee");
				if ($(event.target).hasClass("notfree")) {
					var addid = event.target.id;
						$.ajax
						  ({
						    type: "POST",
						    url: "calhelp.php",
						    data: {'notfree': addid},
						    success: function(msg)
						    {
						     $(".test2").html(msg);
						    }
						  });
				}

				if ($(event.target).hasClass("inschedule")) {
					var addid = event.target.id;
						$.ajax
						  ({
						    type: "POST",
						    url: "calhelp.php",
						    data: {'inschedule': addid},
						    success: function(msg)
						    {
						     $(".test2").html(msg);
						    }
						  });
				}

				if ($(event.target).hasClass("rehearsal")) {
					alert("Your rehearsal time is at this time slot. The location is Jewett 201.");
				}

				if ($(event.target).hasClass("meeting")) {
					alert("Your meeting time is at this time slot. The location is Jewett 201.");
				}
			});


		</script>

<!-- *********************************************************** -->

		<script>
			$(".modally").click(function(event){
				if ($(event.target).hasClass("modally")) {
				$.ajax
				  ({
				    type: "POST",
				    url: "choose-rehearse.php",
				    data: {},
				    success: function(msg)
				    {
				     $("#choose_rehearse").html(msg);
				     console.log(msg);
				    }
				  });
				}
			  });

			$("#add").on('click', function(event){
				$("input[name='rehearsal']").val($("input[name='roptions']:checked").attr("id"));
				$("#cg").trigger("submit");
			});
	</script>
<!-- Search Form -->
	<div class="searchform">
		<label for="sought">Search for...</label>
		<form method="get" name="sought" action="<?php echo $_SERVER['PHP_SELF'] ?>">
		    <div class="input-group">
		      	<input type="text" class="form-control" placeholder="Pieces">
		     	<span class="input-group-btn">
		        	<input class="btn btn-default" type="submit"></input>
		      	</span>
		    </div><!-- /input-group -->
		</form>
	</div>
	<p>

<!-- End of Search Form -->

	<div class="list-group" id="resultList" style="max-height:420px;overflow-y:auto;">
					 
	</div>

	<script>
	//users can only look at the pieces
	$.post("listview.php", 
					{"category": "pieces"}, function(data){console.log(data);$("#resultList").empty().html(data);});
	</script>
</div>


			</div>
			
			
		</div>
		<div>
			<p align="center">Sara Burns and Shelley Wang</p>
		</div>
    

  </body>
</html>
