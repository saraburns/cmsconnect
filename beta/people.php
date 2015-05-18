<!-- people.php
	Sara Burns and Shelley Wang
	This is the landing page for non-admins. -->
<?php session_start();
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

                ?>
            </div>

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
				
<!-- END MODAL HERE XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->				
<div class='col-md-6 col-xs-5 col-md-offset-1' style="max-height:620px;overflow-y:auto;">

<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->					
<!-- Insert calendar here -->
<span class="test2">
		<?php
			require_once("calhelp.php");
			//doThis();
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
