<?php //if password matches, send them to the homepage(with appropriate info contained in session superglobal)
  //currently, we are using a canned username/pword. Eventually we'll look it up in the database
if(isset($_REQUEST['email']) && isset($_REQUEST['password'])){
 $email = $_REQUEST['email'];
 $homepage = 'http://cs.wellesley.edu/~cmsconnect/cmsconnect/admin.php';
if ($email == 'swang8@wellesley.edu' && $_REQUEST['password'] == 'chamber') {
      session_start();
      $_SESSION['email'] = $email;
      header('Location: '.$homepage, true, 303);
      die();
}else{
echo "The information you entered was incorrect. Please try again.";
}
} ?>

<!-- php is above DOCTYPE since it writes a header -->
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

	  <script type="text/javascript">
$(document).ready(function(){ 
    $("#myTab a").click(function(e){
    	e.preventDefault();
    	$(this).tab('show');
    });

    $('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus()
});

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
		</style>
  </head>
  <body>

		<div class='jumbotron'>
			<h1>CMS Connect</h1>
		</div>



			<div class='row'>
				<div class='col-md-3 col-xs-3'></div>
				<div class='col-md-2 col-xs-2 col-md-offset-2'>

<!-- Search Form -->
<div class="login">
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">				
		<div class="form-group">
					    <label for="email">Email</label>
					    <input class="form-control" name="email" placeholder="@wellesley.edu">
					    <label for="password">Password</label>
					    <input class="form-control" type= "password" name="password" placeholder="Password">
					  </div>
						<div class="form-group">
					    <input class="btn btn-default btn-sm" type="submit" value="Login"></input>
					    <input class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" value="New Account"></input>
			</div>
	</form>
</div>
</div>


<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
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
        					<label for="identity">Name</label>
        				    <input class="form-control" name="identity" placeholder="Name">
        				    <label for="bnumber">B Number</label>
        				    <input class="form-control" name="bnumber" placeholder="BXXXXXXXX">
        				    <label for="email">Email</label>
        				    <input class="form-control" name="email" placeholder="@wellesley.edu">
        				    <label for="password">Password</label>
        				    <input class="form-control" name="password" placeholder="Password">
        				    <label for="accounttype">Account Type</label>
        				    <div class="accounttype">
        				      <label><input type="radio" name="type"> Student</label>
        				    </div>
        				    <div class="accounttype">
        				      <label><input type="radio" name="type"> Coach</label>
        				    </div>
<!--         				    <input class="form-control" name="accounttype" placeholder="BXXXXXXXX"> -->
        				  </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Create Account!</button>
      </div>
    </div>
  </div>
</div>
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
			</div>
			
			
		</div>
		<div>
			<p align="center">Sara Burns and Shelley Wang</p>
		</div>
    

  </body>
</html>
