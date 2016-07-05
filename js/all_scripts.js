function social_share(url, width, height) {
    var leftPosition, topPosition;
    leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
    topPosition = (window.screen.height / 2) - ((height / 2) + 50);
    window.open(url, "Window2",
    "status=no,height=" + height + ",width=" + width + ",resizable=yes,left="
    + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY="
    + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no");
}



function UpdateProfile()
{	
var validation= new Validation();
var ajax_call = new Ajax();
var user_level=parseInt($("#user_level").val());
var first_name= document.getElementById('first_name');
var other_names= document.getElementById('other_names');
var location= document.getElementById('location');
var email= document.getElementById('email');
var linked_in= document.getElementById('linked_in');
var image= document.getElementById('image');

var hidden_image=$("#hidden_image").val();
if(image.value==''){
	var image_ext = 'png';
}else{
	var image_ext = image.value.split('.').pop();
}

if( $("#password_section").css('display') == 'none' ) {
	var password= 'password';
	var confirm_pass= 'password';
	setCookie("CURRENT_RESULT_REGISTER",'Strong');
}else{
	var password= document.getElementById('password');
	var confirm_pass= document.getElementById('confirm_pass');
}
 

var capture_code= document.getElementById('capture_code');
var CURRENT_CAPTURE=getCookie('CURRENT_CAPTURE');
var CURRENT_RESULT=getCookie('CURRENT_RESULT_REGISTER');

if(user_level>0){
	$("#user_level_error").html("").hide();
		if(validation.validate_para(first_name) && first_name.value!="first Name"){
		$("#first_name_error").html("").hide();
		if(validation.validate_para(other_names) && other_names.value!="first Name"){  
			$("#other_names_error").html("").hide();
			if(location.value!=0){  
				$("#location_error").html("").hide();
					if(validation.validate_email(email) && email.value !="me@yourmail.com"){  
					$("#email_error").html("").hide();
						if(linked_in.value!=""){
							$("#linked_in_error").html("").hide();
									if((image_ext=="png" || image_ext=="gif" || image_ext=="jpg")){
										$("#image_error").html("").hide();
										if(password.value!=""){ 
											$("#password_error").html("").hide();
												if(CURRENT_RESULT=='Good' || CURRENT_RESULT=='Strong'){
													$("#password_error").html("").hide();
													$("#result").html("").hide();
													if(confirm_pass.value!=""){ 
													$("#conn_password_error").html("").hide();
													if(password.value==confirm_pass.value){ 
														$("#conn_password_error").html("").hide();
														$("#password_error").html("").hide();
															
													//Submit form
													$("#preview").html('');
													$("#preview").html('<img src="loader.gif"/>');
												   
													$("#uploadfrm").ajaxForm({
													dataType:'json',
													success: function (response){
													console.log(response);
													
													
													if(parseInt(response.field)==1)
													{
													$("#success_msg").html("Your profile has been successfully updated");
													//$("#current_profile_photo").attr('src',"uploads/"+UPDATE_DETAILS.PROFILE_PHOTO);					
													//$("#user_prof_image_pic").html("<img id='profile_pic_image' src='uploads/"+UPDATE_DETAILS.PROFILE_PHOTO+"' />");
													window.location.href=window.location.href;
													 //$("#image").val('image');
													 //$(".fake-file").html('');
													 
													
													
													//$("#hidden_image").val(UPDATE_DETAILS.PROFILE_PHOTO);
													$("#result").html('');
													$("#capture_code").val('');
													$("#reg_form_error").html("").hide();
													$("#preview").html('');
													}
													
													else if(parseInt(response.field)==0){
													$("#success_msg").html("").hide();
													$("#reg_form_error").html("Profile update failed please try again.").show();
													}
													
													
													
													else{
														$("#preview").html('');
														$(".form_f").css('border','1px solid #DDDDDD');
														$(".error_nortification2").html("").hide();
														
														$("#"+response.field).css('border','1px solid red');
														$("#"+response.error_div).html(response.error).show();
														$('html, body').animate({
														scrollTop: $("#"+response.error_div).offset().top			
														});	
														
														
														
													}
													}
													}).submit();
													// End submit form												   														
														
													}else{
														$("#conn_password_error").html("Passwords do not match").show();
														$("#password_error").html("Passwords do not match").show();
															$('html, body').animate({
															scrollTop: $("#password_error").offset().top			
															});	
													}
													}else{
														$("#conn_password_error").html("Please confirm password").show();
														$('html, body').animate({
														scrollTop: $("#conn_password_error").offset().top			
														});	
													}
												}else{
													
													$("#password_error").html("Password is not strong enough").show();
													$('html, body').animate({
													scrollTop: $("#password_error").offset().top			
													});	
												}
										}else{
											$("#password_error").html("Please update your password").show();
											$('html, body').animate({
											scrollTop: $("#password_error").offset().top			
											});	
										}
									}else{
										$("#image_error").html("Only PNG, GIF and JPEG files are allowed").show();
										$('html, body').animate({
										scrollTop: $("#image_error").offset().top			
										});	
									}
							}else{
								$("#linked_in_error").html("Please enter your Linkedin ID").show();
								$('html, body').animate({
								scrollTop: $("#linked_in_error").offset().top			
								});	
							}	
						}else{
							$("#email_error").html("Please a valid Email").show();
							$('html, body').animate({
							scrollTop: $("#email_error").offset().top			
							});	
						}
			}else{
				$("#location_error").html("Please select your location").show();
				$('html, body').animate({
				scrollTop: $("#location_error").offset().top			
				});	
			}
		}else{
			$("#other_names_error").html("Please enter your other names").show();
			$('html, body').animate({
			scrollTop: $("#other_names_error").offset().top			
			});	
		}
	}else{
		$("#first_name_error").html("Please enter your first name").show();
		$('html, body').animate({
		scrollTop: $("#first_name_error").offset().top			
		});	
	}			
	}else{
		$("#user_level_error").html("Please select one").show();	
			$('html, body').animate({
			scrollTop: $("#user_level_error").offset().top			
			});	
	}

}



function ReloadCapture()
{
	$.ajax({ 
			url: "proc/reload_reg_capture.php",
			type: "POST",
			data: {},
			beforeSend: function(){
				$("#capture_img").html('<img src="loader.gif"/>');
			}
			}).done(function(html){
				$("#capture_img").html(html);
			});	
}




function Register()
{	
var validation= new Validation();
var ajax_call = new Ajax();
var user_level=parseInt($("#user_level").val());
var first_name= document.getElementById('first_name');
var other_names= document.getElementById('other_names');
var location= document.getElementById('location');
var email= document.getElementById('email');
var linked_in= document.getElementById('linked_in');
var resume= document.getElementById('resume');
var image= document.getElementById('image');
var resume_ext = resume.value.split('.').pop(); 
var image_ext = image.value.split('.').pop(); 
var password= document.getElementById('password');
var confirm_pass= document.getElementById('confirm_pass');

var capture_code= document.getElementById('capture_code');
var CURRENT_CAPTURE=getCookie('CURRENT_CAPTURE');
var CURRENT_RESULT=getCookie('CURRENT_RESULT_REGISTER');


if(user_level>0){
	$("#user_level_error").html("").hide();
		if(validation.validate_para(first_name) && first_name.value!="first Name"){  
		$("#first_name_error").html("").hide();
		if(validation.validate_para(other_names) && other_names.value!="first Name"){  
			$("#other_names_error").html("").hide();
			if(location.value!=0){  
				$("#location_error").html("").hide();
					if(validation.validate_email(email) && email.value !="me@yourmail.com"){  
					$("#email_error").html("").hide();
						if(linked_in.value!=""){
							$("#linked_in_error").html("").hide();
							
							if(resume.value!=""){  
							$("#resume_error").html("").hide();
							if(resume_ext=="doc" || resume_ext=="docx" || resume_ext=="pdf"){
								$("#resume_error").html("").hide();
								if(image.value!=""){  
									$("#image_error").html("").hide();
										if(password.value!=""){ 
											$("#password_error").html("").hide();
												if(CURRENT_RESULT=='Good' || CURRENT_RESULT=='Strong'){
													$("#password_error").html("").hide();
													$("#result").html("").hide();
													if(confirm_pass.value!=""){ 
												$("#conn_password_error").html("").hide();
													if(password.value==confirm_pass.value){ 
														$("#conn_password_error").html("").hide();
														$("#password_error").html("").hide();
															if(capture_code.value!=""){
																if(capture_code.value==CURRENT_CAPTURE){
																	$("#form_capture_error").html("").hide();
																		//Submit form
																		$("#preview").html('');
																		$("#preview").html('<img src="loader.gif"/>');
																		$("#uploadfrm").ajaxForm({
																		dataType:'json',
																		success: function (response) {
																		if(parseInt(response.field)==1)
																		{
																			ReloadCapture();
																			//Send Email to the user
																			$.ajax({ 
																			url: "proc/send_email.php",
																			type: "POST",
																			data: {'email' : email.value,'first_name':first_name.value,'other_names':other_names.value},
																			beforeSend: function(){
																			$("#preloading_div").fadeIn();
																			}
																			}).done(function(html){
																			});			
																			//End send Email to user
																			$('#uploadfrm')[0].reset();
																			 $("#out_user_level").text('--Select Level--'); 
																			 $("#location_out").text('--Select Location--'); 
																			$("#success_msg").html("Thank you for registering");
																			$("#capture_code").val('');
																			$("#result").html('');
																			$("#reg_form_error").html("").hide();
																			$("#preview").html('');
																		}else if(parseInt(response.field)==0){
																			$("#success_msg").html("").hide();
																			$("#reg_form_error").html("Registration failed please try again.").show();
																		}else{
																				$("#preview").html('');
																				$(".form_f").css('border','1px solid #DDDDDD');
																				$(".error_nortification").html("").hide();
																				$("#"+response.field).css('border','1px solid red');
																				$("#"+response.error_div).html(response.error).show();
																				$('html, body').animate({
																				scrollTop: $("#"+response.error_div).offset().top			
																				});	
																		}
																		}
																		}).submit();
																	// End submit form
																}else{
																		$("#form_capture_error").html("Captcha code does not match").show();
																		$("#success_msg").html("").hide();
																		$("#reg_form_error").html("").hide();
																	$('html, body').animate({
																	scrollTop: $("#form_capture_error").offset().top			
																	});		

																}
															}else{
																	$("#form_capture_error").html("Please enter the captcha code above").show();
																	$("#success_msg").html("").hide();
																	$("#reg_form_error").html("").hide();
																$('html, body').animate({
																scrollTop: $("#form_capture_error").offset().top			
																});		

															}														   														
														
													}else{
															$("#conn_password_error").html("Passwords do not match").show();
															$("#password_error").html("Passwords do not match").show();
															$("#success_msg").html("").hide();
															$("#reg_form_error").html("").hide();
														$('html, body').animate({
														scrollTop: $("#conn_password_error").offset().top			
														});		

													}
											}else{
														$("#conn_password_error").html("Please confirm password").show();
														$("#success_msg").html("").hide();
														$("#reg_form_error").html("").hide();
													$('html, body').animate({
													scrollTop: $("#conn_password_error").offset().top			
													});		

											}
												}else{
													
														$("#password_error").html("Password is not strong enough").show();
														$("#success_msg").html("").hide();
														$("#reg_form_error").html("").hide();
													$('html, body').animate({
													scrollTop: $("#password_error").offset().top			
													});		
												}
											
										}else{
												$("#password_error").html("Please create your password").show();
												$("#success_msg").html("").hide();
												$("#reg_form_error").html("").hide();
											$('html, body').animate({
											scrollTop: $("#password_error").offset().top			
											});		
										}
									if(image_ext=="png" || image_ext=="gif" || image_ext=="jpg"){
									$("#image_error").html("").hide();
									}else{
											$("#image_error").html("Only PNG, GIF and JPEG files are allowed").show();
											$("#success_msg").html("").hide();
											$("#reg_form_error").html("").hide();
										$('html, body').animate({
										scrollTop: $("#image_error").offset().top			
										});		
									}
								}else{
										$("#image_error").html("Please upload your passport size photo").show();
										$("#success_msg").html("").hide();
										$("#reg_form_error").html("").hide();
									$('html, body').animate({
									scrollTop: $("#image_error").offset().top			
									});		
								}
							}else{
									$("#resume_error").html("Only PDF and Word document files are allowed").show();
									$("#success_msg").html("").hide();
									$("#reg_form_error").html("").hide();
								$('html, body').animate({
								scrollTop: $("#resume_error").offset().top			
								});		
							}
						}else{
								$("#resume_error").html("Please upload your resume").show();
								$("#success_msg").html("").hide();
								$("#reg_form_error").html("").hide();
							$('html, body').animate({
							scrollTop: $("#resume_error").offset().top			
							});		
						}
					}else{
							$("#linked_in_error").html("Please enter your Linkedin ID").show();
							$("#success_msg").html("").hide();
							$("#reg_form_error").html("").hide();
						$('html, body').animate({
						scrollTop: $("#linked_in_error").offset().top			
						});		
					}	
						}else{
								$("#email_error").html("Please a valid Email").show();
								$("#success_msg").html("").hide();
								$("#reg_form_error").html("").hide();
							$('html, body').animate({
							scrollTop: $("#email_error").offset().top			
							});		

						}		
			}else{
					$("#location_error").html("Please select your location").show();
					$("#success_msg").html("").hide();
					$("#reg_form_error").html("").hide();
				$('html, body').animate({
				scrollTop: $("#location_error").offset().top			
				});		

			}
		}else{
				$("#other_names_error").html("Please enter your other names").show();
				$("#success_msg").html("").hide();
				$("#reg_form_error").html("").hide();
			$('html, body').animate({
			scrollTop: $("#other_names_error").offset().top			
			});		

		}
	}else{
			$("#first_name_error").html("Please enter your first name").show();
			$("#success_msg").html("").hide();
			$("#reg_form_error").html("").hide();
		$('html, body').animate({
		scrollTop: $("#first_name_error").offset().top			
		});		

	}			
	
	}else{
				$("#user_level_error").html("Please select one").show();
				$("#success_msg").html("").hide();
				$("#reg_form_error").html("").hide();
			$('html, body').animate({
			scrollTop: $("#user_level_error").offset().top			
			});		
	}
}


function forgotEmail()
{
	var validation= new Validation();
	var ajax_call = new Ajax();
	var forget_pass_email= document.getElementById('forget_pass_email');
	if(validation.validate_email(forget_pass_email) && forget_pass_email.value !="me@yourmail.com"){  
		$("#forgot_email_error").html("").hide();
		
		$.ajax({ 
				url: "proc/reset_pass.php",
				type: "POST",
				data: {'forget_pass_email' : forget_pass_email.value},
				beforeSend: function(){
				$("#forgot_email_error").html('<img src="loader.gif" alt="Uploading...."/>').show();
				}
				}).done(function(html){
					console.log(html);
					if(parseInt(html)==1){
							$.ajax({ 
							url: "proc/reset_email.php",
							type: "POST",
							beforeSend: function(){
								$("#forget_pass_email").val('');
								$("#success_msg_reset").html("Please check your email address for password reset").show();
								$("#forgot_email_error").html("").hide();
							//$("#preloading_div").fadeIn();
							}
							}).done(function(html){
								
							});
					}else{
						$("#success_msg_reset").html("").hide();
						$("#forgot_email_error").html("The email you supplied does not exist in our database").show();
					}
				});
	}else{
		$("#success_msg_reset").html("").hide();
		$("#forgot_email_error").html("Enter a valid Email").show();
	}
}

