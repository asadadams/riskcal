$(document).ready(function(){
	/**** Add business line ****/
	$('.addBusinessLineForm').validate({
		rules:{
			business_line_name: {
				required: true,
				minlength:2,
				maxlength:25
			},
		},
		messages:{ 
			business_line_name:{
				required:"Please enter in a business line",
				minlength:"Business line name should be at least 2 characters",
				maxlength: "Business line name shouldn't be more than 25 characters"
			}
		}
	})
	
	//Submitting business line form and adding it db
	$('.addBusinessLineForm').submit( function(e){
		e.preventDefault();
		if($('.addBusinessLineForm').valid() == true){	
			$.ajax({
			  url: 'lib/addbusinessline.php',
			  type: 'POST',
			  data: {business_line_name:$('#business_line_name').val()},
			  success:function(response){
				if(response.success){
					$('#error_output').css('display','none');
					$('#success_output').css('display','block').html("Business line has been successfully added. Redirecting...");				
					$('#business_line_name').val('');
					setTimeout('window.location.href = "index.php";',2000);
				}else{
					$('#success_output').css('display','none');
					$('#error_output').css('display','block').html(response.error);
				}
			  },
			  error:function(error){
				 $('#error_output').css('display','block').html("An error occured, please try again");
			  }
			});
			
		}
		
	});
	
	//Deleting room
	$('.delete_businesslist').click(function(){
		if(confirm("Are you sure you want to delete this business line")){
			var this_btn = $(this); //current btn clicked
			var id = $(this).attr('id');

		
			$.ajax({
				url: 'lib/deletebusinessline.php',
				type: 'POST',
				data: {id:id},
				success:function(response){
					if(response.success){
						
						if($("tr#businessline-list").length){
							this_btn.closest("tr#businessline-list").remove();
							
							//If do no more elements hide buttons and refresh
							if($("tr#businessline-list").length == 0){ 
								$('.buttons').css('display','none');
								window.location.href = "index.php";
							}
							
						}
						

					}else{
						alert("An unexpected error occured, try again");
					}
				},
				error: function (error,err,er){
					console.log(error);
				}
            });
		}
	});
	
	
	/**** Alpha factor ****/
	$('.updateAlphaFactor').validate({
		rules:{
			alpha_factor_input: {
				required: true,
			},
		},
		messages:{ 
			alpha_factor_input:{
				required:"Field is required",
			}
		}
	});
	
	$('.updateAlphaFactor').submit( function(e){
		e.preventDefault();
		if($('.updateAlphaFactor').valid() == true){	
			$.ajax({
			  url: 'lib/updateAlphaFactor.php',
			  type: 'POST',
			  data: {alpha_factor_input:$('#alpha_factor_input').val()},
			  success:function(response){
				if(response.success){
					$('#error_output_2').css('display','none');
					$('#success_output_2').css('display','block').html('Alpha factor updated to '+$('#alpha_factor_input').val()+'%');				
					$('#alpha_value').val($('#alpha_factor_input').val());
				}else{
					$('#success_output_2').css('display','none');
					$('#error_output_2').css('display','block').html(response.error);
				}
			  },
			  error:function(error){
				 $('#error_output').css('display','block').html("An error occured, please try again");
			  }
			});
			
		}
		
	});
	
	
	//Button to add more year fields for calculations
	var year_no = 1;
	$('.addbusinesslineyear').on("click",function(){
		
		if(year_no == 1){
			year_no++;
			$('.year_amt').after('<div class="col-sm-2 form-group year_amt_form_group year_amt_'+year_no+'"><input type="text" class="form-control year_input year_'+year_no+'" id="year_'+year_no+'"  placeholder="Year-2"></div>'); 				
		}else{
			var class_no = year_no + 1;
			$('.year_amt_'+year_no).after('<div class="col-sm-2 form-group year_amt_form_group year_amt_'+class_no+'"><input type="text" class="form-control year_input year_'+class_no+'" id="year_'+class_no+'" placeholder="Year-'+class_no+'"></div>'); 				
			year_no++;
		}
		
			
	});
	
	$('.make_calculations').click(function(){
		//Reseting calculation divs
		$('#sums-calculations').css('display','block').html(""); 
		$('#true-negatives-calculations').css('display','block').html(""); 
		$('#average-calculations').css('display','block').html("")
		$('#capital-calculations').css('display','block').html("")
		$('#sums-calculations').append("<h3>Sums</h3>");
		$('#true-negatives-calculations').append("<h3>True Negatives</h3>");
		
		var sums = [];
		var trueNegatives = [];
		var average = 0;
		var trueNegativeSum = 0; 
		
		for(var i=1;i<=year_no;i++){
			var sum = 0;
			$('.year_'+i).each(function(){
				sum += +$(this).val();
			})
			sums.push(sum);
			
			//True negatives, if sum < 0 , 0 is used instead of negative
			if(sum < 0){
				trueNegatives.push(0);
			}else{
				trueNegatives.push(sum);
			}
		}
		
		console.log('Sums', sums)
		console.log('true Negatives', trueNegatives)
		
		for(var i=0;i<sums.length;i++){
			var val = i + 1;
			$('#sums-calculations').append('<p>Year-'+val+': <strong>GHC '+ sums[i] +' </strong></p>');
		}
		
		for(var i=0;i<trueNegatives.length;i++){
			var val = i + 1;
			$('#true-negatives-calculations').append('<p>Year-'+val+': <strong>GHC '+ trueNegatives[i] +' </strong></p>');
			
			//Finding average using true negatives
			trueNegativeSum += trueNegatives[i];
		}
		
		average = trueNegativeSum/trueNegatives.length; // calculating average
		
		var alpha_value = parseFloat($('#alpha_value').val())/100;
		
		$('#average-calculations').append('<h3>Average: <strong>GHC '+ parseFloat(average).toFixed(2)+'</strong></h3>');
		
		$('#capital-calculations').append('<h3>Capital(GOI): <strong>GHC '+ parseFloat(parseFloat(average) * alpha_value).toFixed(4) +'</strong></h3>');
		
	})
	
	
	
});