<!-- people.php
	Sara Burns and Shelley Wang
	This is the landing page for non-admins. -->
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


	<!-- CSS -->

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

	<!-- Bootstrap -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

	


	//  <script type="text/javascript">
  $('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus()
});

});

	// </script>


	  <!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	  <![endif]-->
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
		</style>
  </head>
  <body>

<link rel="stylesheet" type="text/css" href="easycal.css">


<div class='row'>
<div class = 'col-md-1'><?php if(isset($_SESSION['email'])) echo 
"Hello ".$_SESSION['email']; ?></div>				<div class='col-md-1 col-md-offset-11'><a href="#">Logout</a></div>
</div>

		<div class='jumbotron'>
			<h1>CMS Connect</h1>
		</div>
		<div class='jumbotron'>



<div class='row'>
				<div class='col-md-1 col-xs-3 col-md-offset-1'><input class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" value="Add Free Time"></input></div>
				
<div class='col-md-6 col-xs-5 col-md-offset-1' style="max-height:620px;overflow-y:auto;">

<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->					
<!-- Insert calendar here -->
	<div class="mycal" style="width: 760px; "></div>


	<script src="jquery.min.js"></script>
	<script src="underscore-min.js"></script>
<script src="moment.min.js"></script>
	<script type="text/javascript" src="dataset.js"></script>
	<script type="text/javascript" src="easycal.js"></script>

	<script>
		$('.mycal').easycal({
			minTime : '07:00:00',
			maxTime : '23:00:00',
			slotDuration : 60,
			startDate : '31-10-2015', // OR 31/10/2104
			dayClick : function(){
				console.log('Slot selected');
			},
			events : getEvents()
		});
	</script>
<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
</div>
<!-- XXXXXX -->

<div class='col-md-2 col-xs-2'>



<!-- Search Form -->
	<div class="searchform">
		<label for="sought">Search for...</label>
		<form method="get" name="sought" action="<?php echo $_SERVER['PHP_SELF'] ?>">
		    <div class="input-group">
		      	<input type="text" class="form-control" placeholder="Pieces">
		     	<span class="input-group-btn">
		        	<input class="btn btn-default" type="submit" value="submit"></input>
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
	$.post("http://cs.wellesley.edu/~cmsconnect/cmsconnect/listview.php", 
					{"category": "pieces"}, function(data){console.log(data);$("#resultList").empty().html(data);});
	</script>
</div>

<!-- users can add free time to their schedules -->
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXx -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create an Account</h4>
      </div>
      <div class="modal-body">
        <form method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        	<div class="form-group">
        					<label for= "day">Day</label>
        					<select name = "day">
        						<option value="1">Sunday</option>
  								<option value="2">Monday</option>
  								<option value="3">Tuesday</option>
  								<option value="4">Wednesday</option>
  								<option value="5">Thursday</option>
  								<option value="6">Friday</option>
  								<option value="7">Saturday</option>
        					</select>
        					<label for= "hour">Time</label>
        					<select name = "day">
        						<option value="1">7-8AM</option>
  								<option value="2">8-9AM</option>
  								<option value="3">9-10AM</option>
  								<option value="4">10-11AM</option>
  								<option value="5">11-12PM</option>
  								<option value="6">12-1PM</option>
  								<option value="7">1-2PM</option>
  								<option value="8">2-3PM</option>
  								<option value="9">3-4PM</option>
  								<option value="10">4-5PM</option>
  								<option value="11">5-6PM</option>
  								<option value="12">6-7PM</option>
  								<option value="13">7-8PM</option>
  								<option value="14">9-10PM</option>
  								<option value="15">10-11PM</option>
        					</select>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Add</button>
      </div>
    </div>
  </div>
</div>

<!-- XXXXXX -->
			</div>
			
			
		</div>
		<div>
			<p align="center">Sara Burns and Shelley Wang</p>
		</div>
    

  </body>
</html>
