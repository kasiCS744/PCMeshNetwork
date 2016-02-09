<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<%@ page session="false" %>
<html>
<head>
	<title>Home</title>
	
	<!-- Le styles -->
	<link href="resources/css/bootstrap.css" rel="stylesheet">
	<!-- Bootstrap theme -->
	<link href="resources/css/bootstrap-theme.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="resources/css/search.css" rel="stylesheet">
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  	
  	<style>
  	#draggable { width: 150px; height: 150px; padding: 0.5em; border: 0px;}
  	</style>
</head>
<body>
	<div class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Partially Connected Mesh Network</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">

					<li class="active"><a href="<c:url value="/"/>">Home</a></li>
					<li><a href="<c:url value="/"/>">Settings</a>
					<li><a href="<c:url value="/"/>">Logout</a></li>
					
				</ul>
				<div style="padding-left: 750px; padding-top: 10px; color: Orange"
					class="userheader">Logged in as: ${user}</div>
			</div>
		</div>
	</div>
	<div class="container theme-showcase" role ="main">
		<div id="draggable" class="ui-widget-content">
			<canvas id="myCanvas" width="150" height="150">
				Your browser does not support the HTML5 canvas tag.
			</canvas>
		</div>
		<form class="form-horizontal" role="form" action="<c:url value="/"/>" method="post">
			<div class="form-group">
				<label for="xposition" class="col-sm-2 control-label">X Position</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" id="xposition" placeholder="X Position" name="x">
				</div>
			</div>
			
			<div class="form-group">
				<label for="yposition" class="col-sm-2 control-label">Y Position</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" id="yposition" placeholder="Y Position" name="y">
				</div>
			</div>
			
			<div class="form-group">
				<label for="pid" class="col-sm-2 control-label">Pattern ID</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" id="pid" placeholder="Pattern ID" name="p">
				</div>
			</div>
			
			<div class="form-group">
				<label for="connector" class="col-sm-2 control-label">Is this a connector node?</label>
				<div class="col-sm-10">
					<div class="checkbox">
						<input type="checkbox" value="" id="connector">
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="neighborID" class="col-sm-2 control-label">Enter the neighboring nodes ID's</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" id="neighborID" placeholder="Neighbor ID's" name="n">
				</div>
			</div>												
			
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" onclick="msg()" class="btn btn-default">Add Connector Node</button>
				</div>
			</div>
			
<!-- 		<form>	 -->
<!-- 			<h1> -->
<!-- 				<input type="button" onclick="msg()" value="Add Connector Node" /> -->
<!-- 			</h1> -->
		</form>	
		<script>
  			function msg() {
  				var c=document.getElementById("myCanvas");
  				var ctx=c.getContext("2d");
  				ctx.beginPath();
  				ctx.arc(75,75,50,0,2*Math.PI);
  				ctx.fillStyle = 'green';
  				ctx.fill();
  				ctx.stroke();
     			$( "#draggable" ).draggable();
  			}
  		</script>
	</div>

	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="resources/js/bootstrap.js"></script>
</body>
</html>
