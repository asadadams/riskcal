<?php
	require_once('classes/businessline.class.php');
	require_once('classes/bia.class.php');
	$businessLineObj = new BusinessLine();
	$biaObj = new BIA();
	
	if($biaObj->getAlphaFactor()['alpha'] != 0){
		$alphafactor = $biaObj->getAlphaFactor()['alpha'];
	}else{
		$alphafactor  = 15;
	}
?>

<!DOCTYPE html>
<html lang="">
	<head>
        <meta charset="utf-8">
		<!-- Boostrap -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Main css -->
		<link rel="stylesheet" href="css/main.css">
		
		<!-- Datatables -->
		<link rel="stylesheet" href="modules/datatables/datatables.min.css">
		
	</head>

	<body>
		<nav class="navbar navbar-inverse" style='border-radius:0px;margin-bottom:0px;'>
		  <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="index.html">Risk Calculator</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li class="active"><a href="index.html">Home</a></li>
			  </ul>
			  
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		
		<div class='container'>
			<h2>Operiational Risk Calculator - Basic Indictor Approach(BIA)</h2>
			
			<div class = 'row'>
			
				<div class='col-md-6'>
					<h3>Add a business line</h3>
					<form class='addBusinessLineForm' autocomplete="off" method="POST">
						<div class='row'>
							<div class="col-sm-11 form-group">
								<label for="business_line_name">Name of business line:</label>
								<input type="text" class="form-control" id="business_line_name" name="business_line_name" placeholder='Enter in a businees line name'>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12 form-group">
								<button type="submit" class="btn btn-lg btn-default" >Add business</button>
							</div>
						</div>
						
						<div class='col-md-6' id='error_output'></div>
						<div class='col-md-11' id='success_output'></div>
					</form>
				</div>
				
				<div class='col-md-6'>
					<h3>Set Alpha factor</h3>
					<input type='hidden' value="<?php echo $alphafactor;?>" id='alpha_value'>
					
					<div class='alert alert-warning'>
						Alpha factor is currently set to 15% by basel. Please make sure to check with basel before setting alpha factor
					</div>
					<form class='updateAlphaFactor' autocomplete="off" method="POST">
						<div class='row'>
							<div class="col-sm-6 form-group">
								<label for="alpha_factor_input">Alpha factor:</label>
								<input type="text" class="form-control" value="<?php echo $alphafactor;?>" id="alpha_factor_input" name="alpha_factor_input" placeholder='Alpha factor'>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12 form-group">
								<button type="submit" class="btn btn-lg btn-default" >Set alpha factor</button>
							</div>
						</div>
						
						<div class='col-md-6' id='error_output_2'></div>
						<div class='col-md-6' id='success_output_2'></div>
						
					</form>
				</div>	
			
			</div>
			
			
			
			
			
			<br/>
			<h3>Business lines</h3>
				
			<?php
				if($businessLineObj->getBusinesLines() != 0){
			?>
				<div class='buttons'>
					<button class="btn btn-primary btn-xs addbusinesslineyear">Add year</button>
					<button class="btn btn-primary btn-xs make_calculations">Make calculations</button>
				</div>
				
				<div id='calculations'>
					<div id='sums-calculations'></div>
					<div id='true-negatives-calculations'></div>
					<div id='average-calculations'></div>
					<div id='capital-calculations'></div>
				</div>
				
				</br>
			<table class="table table-striped table-advance table-hover" id='zctb' width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						 <?php
							foreach($businessLineObj->getBusinesLines() as $businesLines){
								$id = $businesLines['id'];
								$name = $businesLines['name'];
						?>
							<tr id='businessline-list'>
								<td><a href="editbusineslist.php&id=<?php echo $id;?>"><?php echo $id;?></a></td>
								<td><?php echo $name;?></td>
								<td>
									
									<div class="col-sm-2 form-group year_amt" businessline_id='<?php echo $id;?>'>
										<input type="text" class="form-control year_input year_1" id="year_1" placeholder='Year-1'>
									</div>
									
									
								</td>
								<td>
									
									<button id="<?php echo $id;?>" class="btn btn-danger btn-xs delete_businesslist"><i class="glyphicon glyphicon-trash"></i> Delete</button>
								</td>
							</tr>
						<?php }?>
					</tbody>
				
			</table>
			<?php }else{?>
				<p>No business line added</p>
			<?php }?>
			
			
			
		</div>
		
		
		<!-- JQuery -->
		<script src='js/jquery.js'></script>
		<!-- Bootstrap JS -->
		<script src='js/bootstrap.min.js'></script>
		<!-- Core js -->
		<script src="js/main.js"></script>
		<!-- JQuery validate -->
		<script src="js/jquery.validate.min.js"></script>
		
		<!-- Datatables -->
		<script src="modules/datatables/datatables.min.js"></script>
		<script>
		$('documnet').ready(function(){
			$('#zctb').DataTable();
		});
	  </script>
		
    </body>
</html>
