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

	  <script type="text/javascript">
$(document).ready(function(){ 
    $("#myTab a").click(function(e){
    	e.preventDefault();
    	$(this).tab('show');
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

<div class='row'>
<div class = 'col-md-2'><?php if(isset($_SESSION['email'])) echo "Hello ".$_SESSION['email']; ?></div>				<div class='col-md-1 col-md-offset-9'>Admin Mode <a href="#">Logout</a></div>
</div>

		<div class='jumbotron'>
			<h1>CMS Connect</h1>
		</div>
		<div class='jumbotron' style="background-image: url(movietheater.jpg);
		background-size: 100% 750px;min-height:750px;">



			<div class='row'>
				<div class='col-md-3 col-xs-3'></div>
				<div class='col-md-2 col-xs-2'>

<!-- Search Form -->
<div class="searchform">
	<form method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">
					
					  <div class="form-group">
					    <label for="sought">Search for...</label>
					    <input class="form-control" name="sought" placeholder="Name">
					  </div>
						<div class="form-group">
					    <input class="btn btn-default" type="submit" value="Submit"></input>
					</div>
				</form>
</div>

<!-- End of Search Form -->

					<div class="list-group" id="myTab" style="max-height:420px;overflow-y:auto;">
					  <a href="#sectionB" class="list-group-item active">
					    Cras justo odio
					  </a>
					  <a href="#sectionA" class="list-group-item">Dapibus ac facilisis in</a>
					  <a href="#" class="list-group-item">Morbi leo risus</a>
					  <a href="#" class="list-group-item">Porta ac consectetur ac</a>
					  <a href="#" class="list-group-item">Vestibulum at eros</a>
					  <a href="#" class="list-group-item">Vestibulum at eros</a>
					  <a href="#" class="list-group-item">Vestibulum at eros</a>
					  <a href="#" class="list-group-item">Vestibulum at eros</a>
					  <a href="#" class="list-group-item">Vestibulum at eros</a>
					  <a href="#" class="list-group-item">Vestibulum at eros</a>
					  <a href="#" class="list-group-item">Vestibulum at eros</a>
					  <a href="#" class="list-group-item">Vestibulum at eros</a>
					  <a href="#" class="list-group-item">Vestibulum at eros</a>
					</div>
				</div>
				<div class='col-md-5 col-xs-5' style="max-height:420px;overflow-y:auto;">

<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->					
<div class="bs-example">
    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a href="#sectionA">Groups</a></li>
        <li><a href="#sectionB">Pieces</a></li>
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">People <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="#dropdown1">Students</a></li>
                <li><a href="#dropdown2">Coaches</a></li>
            </ul>
        </li>
    </ul>
    <div class="tab-content">
        <div id="sectionA" class="tab-pane fade in active">
            <h3>Section A</h3>
            <p>Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui. Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth.</p>
        </div>
        <div id="sectionB" class="tab-pane fade">
            <h3>Section B</h3>
            <p>Vestibulum nec erat eu nulla rhoncus fringilla ut non neque. Vivamus nibh urna, ornare id gravida ut, mollis a magna. Aliquam porttitor condimentum nisi, eu viverra ipsum porta ut. Nam hendrerit bibendum turpis, sed molestie mi fermentum id. Aenean volutpat velit sem. Sed consequat ante in rutrum convallis. Nunc facilisis leo at faucibus adipiscing.</p>
        </div>
        <div id="dropdown1" class="tab-pane fade">
            <h3>Dropdown 1</h3>
            <p>WInteger convallis, nulla in sollicitudin placerat, ligula enim auctor lectus, in mollis diam dolor at lorem. Sed bibendum nibh sit amet dictum feugiat. Vivamus arcu sem, cursus a feugiat ut, iaculis at erat. Donec vehicula at ligula vitae venenatis. Sed nunc nulla, vehicula non porttitor in, pharetra et dolor. Fusce nec velit velit. Pellentesque consectetur eros.</p>
        </div>
        <div id="dropdown2" class="tab-pane fade">
            <h3>Dropdown 2</h3>
            <p>Donec vel placerat quam, ut euismod risus. Sed a mi suscipit, elementum sem a, hendrerit velit. Donec at erat magna. Sed dignissim orci nec eleifend egestas. Donec eget mi consequat massa vestibulum laoreet. Mauris et ultrices nulla, malesuada volutpat ante. Fusce ut orci lorem. Donec molestie libero in tempus imperdiet. Cum sociis natoque penatibus et magnis.</p>
        </div>
    </div>
</div>

<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->


				</div>
			</div>
			
			
		</div>
		<div>
			<p align="center">Sara Burns and Shelley Wang</p>
		</div>
    

  </body>
</html>
