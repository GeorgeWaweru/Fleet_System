function adminDeleteRecord(controller,delete_id)
{
	var path="index.php?r="+controller+"/delete&id="+delete_id;						
		$.ajax({ 
		url: path,
		type: "POST"
		}).done(function(html){
			window.location.reload();
		});		
}


(function($) {
    $.fn.extend( {
        limiter: function(limit, elem) {
            $(this).on("keyup focus", function() {
                setCount(this, elem);
            });
            function setCount(src, elem) {
                var chars = src.value.length;
                if (chars > limit) {
                    src.value = src.value.substr(0, limit);
                    chars = limit;
                }
                elem.html( limit - chars );
            }
            setCount($(this)[0], elem);
        }
    });
})(jQuery);



$(function(){
$(".search").keyup(function() 
{ 
var searchid = $(this).val();
var dataString = 'search='+ searchid;
if(searchid!='')
{
	$.ajax({
	type: "POST",
	url: "index.php?r=UserGroups/Livesearch",
	data: dataString,
	cache: false,
	success: function(html)
	{
	$("#result").html(html).show();
	}
	});
}return false;    
});

jQuery("#result").live("click",function(e){ 
	var $clicked = $(e.target);
	var $name = $clicked.find('.name').html();
	var decoded = $("<div/>").html($name).text();
	$('#searchid').val(decoded);
});
jQuery(document).live("click", function(e) { 
	var $clicked = $(e.target);
	if (! $clicked.hasClass("search")){
	jQuery("#result").fadeOut(); 
	 
	}
});

$('#searchid').click(function(){
	jQuery("#result").fadeIn();
});
});






$("#forgot_pass").click(function(){
	$(".reset_pass_tr").toggle(200);	
});


function ResetEmail()
{
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
	var forget_email=$("#forget_email").val();
	if(emailReg.test(forget_email)  && forget_email!=""){
	   $("#Reset_email_error").html("").hide();
	   
	   $.ajax({ 
			url: "index.php?r=Administrator/resetpassword",
			type: "POST",
			data: {'forget_email' : forget_email},
			beforeSend: function(){
				$("#Reset_email_error").html('<img src="loader.gif"/>');
			}
			}).done(function(html){
				if(parseInt(html)==1){
					 $("#Reset_email_error").html("The email you have entered was not found.").show();
				}else{
					$("#success_info_div").html("An email has been sent to your email address");
					 $("#Reset_email_error").html("").hide();
				}
			});		
	}else{
	   $("#Reset_email_error").html("Enter a valid email address").show();
	}  
}

	
function highlightMenu(menu_name)
	{
		$( "li" ).each(function( index ) {
			if($( this ).text()==menu_name)
			{
				$( this ).addClass('active');
			}
		});
	}
	
	
function formFieldValue(field)
{
	return fieldvalue=document.getElementById(field).value;
}


function validateWard()
{
	$("#wards-form").submit();	
}




function validateAchievement()
{
	var Achivements_achievement=$("#Achivements_achievement").val();
	var Achivements_impact=$("#Achivements_impact").val();
	var Achivements_status=$("#Achivements_status").val();
	if(Achivements_achievement!==""){
		$("#achievement_error").removeClass('error').html('').hide();
		if(Achivements_impact!==""){
			$("#impact_error").removeClass('error').html('').hide();
			if(Achivements_status!==""){
				$("#status_error").removeClass('error').html('').hide();
				$("#achivements-form").submit();	
			}else{
				$("#status_error").addClass('error').html('Please select the status.').show();
			}
		}else{
			$("#impact_error").addClass('error').html('Please enter the impace of the achivement above.').show();
		}
	}else{
		$("#achievement_error").addClass('error').html('Please enter an achievement.').show();
	}
	//achievement_error
	//impact_error
	//$("#achivements-form").submit();	
	
}


function validateFaq()
{
	var Faqs_position_id=$("#Faqs_position_id").val();
	var Faqs_question=$("#Faqs_question").val();
	var Faqs_status=$("#Faqs_status").val();
	if(Faqs_position_id!==""){
		$("#position_error").removeClass('error').html('').hide();
		if(Faqs_question!==""){
			$("#question_error").removeClass('error').html('').hide();
			if(Faqs_status!==""){
				$("#status_error").removeClass('error').html('').hide();
				$("#faqs-form").submit();	
			}else{
				$("#status_error").addClass('error').html('Please select the status.').show();
			}
		}else{
			$("#question_error").addClass('error').html('Please enter the FAQ question.').show();
		}
	}else{
		$("#position_error").addClass('error').html('Please enter the political position.').show();
	}
}

function validatePosition()
{
	var Positions_title=$("#Positions_title").val();
	var Positions_status=$("#Positions_status").val();
	if(Positions_title!==""){
		$("#title_error").removeClass('error').html('').hide();
		if(Positions_status!==""){
			$("#status_error").removeClass('error').html('').hide();
			$("#positions-form").submit();
		}else{
			$("#status_error").addClass('error').html('Please select the status.').show();
		}
	}else{
		$("#title_error").addClass('error').html('Please enter the political position.').show();
	}
}


function validateuserQuestion()
{
	$("#user-questions-form	").submit();
}


function validateParty()
{
	var Parties_title=$("#Parties_title").val();
	var Parties_abreviations=$("#Parties_abreviations").val();
	var Parties_leader=$("#Parties_leader").val();
	var profile_pic_hidden=$("#profile_pic_hidden").val();
	var Parties_profile_pic=$("#Parties_profile_pic").val();
	var cover_photo_pic_hidden=$("#cover_photo_pic_hidden").val();
	var Parties_cover_photo_pic=$("#Parties_cover_photo_pic").val();
	var Parties_status=$("#Parties_status").val();
	
	
	if(profile_pic_hidden=="" && Parties_profile_pic=="")
	{
		var profile_pic_ext="";
	}else if(profile_pic_hidden!="" && Parties_profile_pic=="")
	{
		var profile_pic_ext="gif";
	}else if(profile_pic_hidden=="" && Parties_profile_pic!="")
	{
		var profile_pic_ext = Parties_profile_pic.split('.').pop().toLowerCase(); 
	}else{
		var profile_pic_ext = Parties_profile_pic.split('.').pop().toLowerCase();
	}
	
	if(cover_photo_pic_hidden=="" && Parties_cover_photo_pic=="")
	{
		var cover_photo_ext="";
	}else if(cover_photo_pic_hidden!="" && Parties_cover_photo_pic=="")
	{
		var cover_photo_ext="gif";
	}else if(cover_photo_pic_hidden=="" && Parties_cover_photo_pic!="")
	{
		var cover_photo_ext = Parties_cover_photo_pic.split('.').pop().toLowerCase(); 
	}else{
		var cover_photo_ext = Parties_cover_photo_pic.split('.').pop().toLowerCase();
	}
	
	if(Parties_title!==""){
		$("#title_error").removeClass('error').html('').hide();
		if(Parties_abreviations!==""){
			$("#abreviations_error").removeClass('error').html('').hide();
			if(Parties_leader!==""){
				$("#leader_error").removeClass('error').html('').hide();
				if(profile_pic_ext=="gif" || profile_pic_ext=="png" || profile_pic_ext=="jpg" || profile_pic_ext=="jpeg"){
					$("#profile_pic_error").removeClass('error').html('').hide();
					if(cover_photo_ext=="gif" || cover_photo_ext=="png" || cover_photo_ext=="jpg" || cover_photo_ext=="jpeg"){
						$("#cover_photo_pic_error").removeClass('error').html('').hide();
						if(Parties_status!==""){
							$("#status_error").removeClass('error').html('').hide();
							$("#parties-form").submit();
						}else{
							$("#status_error").addClass('error').html('Please select the status.').show();
						}
					}else{
						$("#cover_photo_pic_error").addClass('error').html('Please upload the cover photo as(.JPG,.PNG or.GIF)').show();
					}
				}else{
					$("#profile_pic_error").addClass('error').html('Please upload the cover photo as(.JPG,.PNG or.GIF)').show();
				}
			}else{
				$("#leader_error").addClass('error').html('Please enter the party leader.').show();
			}	
		}else{
			$("#abreviations_error").addClass('error').html('Please enter the abreviations.').show();
		}	
	}else{
		$("#title_error").addClass('error').html('Please enter the tilte.').show();
	}		
}


function validateCounty()
{
	var County_title=$("#County_title").val();
	var County_status=$("#County_status").val();
	if(County_title!==""){
		$("#title_error").removeClass('error').html('').hide();
		if(County_status!==""){
			$("#status_error").removeClass('error').html('').hide();
			$("#county-form").submit();
		}else{
			$("#status_error").addClass('error').html('Please select the status.').show();
		}
	}else{
		$("#title_error").addClass('error').html('Please enter the tilte.').show();
	}
}

function validateConstituency()
{
	var Constituency_county_id=$("#Constituency_county_id").val();
	var Constituency_title=$("#Constituency_title").val();
	if(Constituency_county_id!==""){
		$("#county_error").removeClass('error').html('').hide();
		if(Constituency_title!==""){
			$("#title_error").removeClass('error').html('').hide();
			if(Constituency_status!==""){
				$("#status_error").removeClass('error').html('').hide();
				$("#constituency-form").submit();
			}else{
				$("#status_error").addClass('error').html('Please select the status.').show();
			}
		}else{
			$("#title_error").addClass('error').html('Please enter the constituency.').show();
		}
	}else{
		$("#county_error").addClass('error').html('Please select the county.').show();
	}
}


function validateCandidates()
{
	var Candidates_position_id=$("#Candidates_position_id").val();
	var Candidates_county_id=$("#Candidates_county_id").val();
	var Candidates_constituency_id=parseInt($("#Candidates_constituency_id").val());
	var Candidates_ward_id=parseInt($("#Candidates_ward_id").val());
	var Candidates_party_id=$("#Candidates_party_id").val();
	var Candidates_entry_number=$("#Candidates_entry_number").val();
	var Candidates_names=$("#Candidates_names").val();
	var Candidates_email=$("#Candidates_email").val();
	var Candidates_gender=$("#Candidates_gender").val();
	var profile_pic_hidden=$("#profile_pic_hidden").val();
	var Candidates_profile_pic=$("#Candidates_profile_pic").val();
	var cover_photo_pic_hidden=$("#cover_photo_pic_hidden").val();
	var Candidates_cover_photo_pic=$("#Candidates_cover_photo_pic").val();
	
	var Candidates_package_id=$("#Candidates_package_id").val();
	var Candidates_time_based_campaign=$("#Candidates_time_based_campaign").val();
	var Candidates_start_time=$("#Candidates_start_time").val();
	var Candidates_end_time=$("#Candidates_end_time").val();
	
	
	var Candidates_status=$("#Candidates_status").val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
	
	var current_task=$("#current_task").val();
	
	
	if(profile_pic_hidden=="" && Candidates_profile_pic=="")
	{
		var profile_pic_ext="";
	}else if(profile_pic_hidden!="" && Candidates_profile_pic=="")
	{
		var profile_pic_ext="gif";
	}else if(profile_pic_hidden=="" && Candidates_profile_pic!="")
	{
		var profile_pic_ext = Candidates_profile_pic.split('.').pop().toLowerCase(); 
	}else{
		var profile_pic_ext = Candidates_profile_pic.split('.').pop().toLowerCase();
	}
	
	
	
	if(cover_photo_pic_hidden=="" && Candidates_cover_photo_pic=="")
	{
		var cover_photo_ext="";
	}else if(cover_photo_pic_hidden!="" && Candidates_cover_photo_pic=="")
	{
		var cover_photo_ext="gif";
	}else if(cover_photo_pic_hidden=="" && Candidates_cover_photo_pic!="")
	{
		var cover_photo_ext = Candidates_cover_photo_pic.split('.').pop().toLowerCase(); 
	}else{
		var cover_photo_ext = Candidates_cover_photo_pic.split('.').pop().toLowerCase();
	}
	
	if(Candidates_position_id!==""){
		$("#position_error").removeClass('error').html('').hide();
		if(Candidates_county_id!==""){
			$("#county_error").removeClass('error').html('').hide();
			if(Candidates_constituency_id>0){
				$("#constituency_error").removeClass('error').html('').hide();
				if(Candidates_ward_id>0){
					$("#Ward_error").removeClass('error').html('').hide();
					if(Candidates_party_id!==""){
						$("#party_error").removeClass('error').html('').hide();
						if(Candidates_entry_number!==""){
							$("#entry_number_error").removeClass('error').html('').hide();
								if(Candidates_names!==""){
								$("#names_error").removeClass('error').html('').hide();
								if(emailReg.test(Candidates_email) && Candidates_email!=""){
									$("#email_error").removeClass('error').html('').hide();
									if(Candidates_gender!==""){
										$("#gender_error").removeClass('error').html('').hide();
										if(profile_pic_ext=="gif" || profile_pic_ext=="png" || profile_pic_ext=="jpg" || profile_pic_ext=="jpeg"){
											$("#profile_pic_error").removeClass('error').html('').hide();
											if(cover_photo_ext=="gif" || cover_photo_ext=="png" || cover_photo_ext=="jpg" || cover_photo_ext=="jpeg"){
												$("#cover_photo_pic_error").removeClass('error').html('').hide();
												if(Candidates_package_id!==""){
													$("#package_error").removeClass('error').html('').hide();
													if(Candidates_time_based_campaign!==""){
														$("#period_error").removeClass('error').html('').hide();
														if($(".campaign_periods").is(':visible')){
															if(Candidates_start_time!==""){
															   $("#start_date_error").removeClass('error').html('').hide();
																if(Candidates_end_time!==""){
																   $("#end_date_error").removeClass('error').html('').hide();
																	// Validate final field and submit the form
																	if(Candidates_status!==""){
																		$("#status_error").removeClass('error').html('').hide();
																		$(".dropDownElements").prop("disabled", false);
																		
										$("#Candidates-form").ajaxForm({
										dataType:'html',
										success: function (response){
										
										
										
										try {
										jQuery.parseJSON(response);
										var TRANSACTION_DETAILS = jQuery.parseJSON(response);
										$("#"+TRANSACTION_DETAILS.field).css('border','1px solid red');
										$("#"+TRANSACTION_DETAILS.error_div).html(TRANSACTION_DETAILS.error).show();
										$('html, body').animate({
										scrollTop: $("#"+TRANSACTION_DETAILS.field).offset().top		
										});	
										
										
										} catch(error) {
										if(current_task=='Add'){
										$("#candidate_frm_info").addClass('success').removeClass('error').html('Candidate successfully added.').show();
										}else if(current_task=='Update'){
										$("#candidate_frm_info").addClass('success').removeClass('error').html('Candidate successfully updated.').show();
										}
										}
										
										
										}
										}).submit();
																		
																	}else{
																		$("#status_error").addClass('error').html('Please select the status.').show();
																	}
																	//End Validate final field and submit the form
																}else{
																   $("#end_date_error").addClass('error').html('Please enter the campaign end date.').show()
																}
															}else{
															   $("#start_date_error").addClass('error').html('Please enter the campaign start date.').show()
															}
														}else{
															// Validate final field and submit the form
															if(Candidates_status!==""){
																$("#status_error").removeClass('error').html('').hide();
																$(".dropDownElements").prop("disabled", false);
																$("#Candidates-form").submit();
															}else{
																$("#status_error").addClass('error').html('Please select the status.').show();
															}
															//End Validate final field and submit the form
														}
													}else{
														$("#period_error").addClass('error').html('Please select the campaign period.)').show()
													}
												}else{
													$("#package_error").addClass('error').html('Please select the campaign package.)').show()
												}
											}else{
												$("#cover_photo_pic_error").addClass('error').html('Please upload the cover photo as(.JPG,.PNG or.GIF)').show()
											}
										}else{
											$("#profile_pic_error").addClass('error').html('Please upload the profile photo as(.JPG,.PNG or.GIF)').show();
										}
									}else{
										$("#gender_error").addClass('error').html('Please select the Candidates gender.').show();
									}
								}else{
									$("#email_error").addClass('error').html('Please a valid email address.').show();
								}
							}else{
								$("#names_error").addClass('error').html('Please enter the Candidates names.').show();
							}
						}else{
							$("#entry_number_error").addClass('error').html('Please enter the entry number.').show();
						}
					}else{
						$("#party_error").addClass('error').html('Please select the Political Party.').show();
					}
				}else{
					$("#Ward_error").addClass('error').html('Please select the ward.').show();
				}
			}else{
				$("#constituency_error").addClass('error').html('Please select the constituency.').show();
			}
		}else{
			$("#county_error").addClass('error').html('Please select the county.').show();
		}
	}else{
		$("#position_error").addClass('error').html('Please select the Political Position.').show();
	}
}

function validateClients()
{
var Clients_logo=$("#Clients_logo").val();
var image_file=$("#image_file").val();
var Clients_sector_id=$("#Clients_sector_id").val();
var Clients_title=$("#Clients_title").val();
var Clients_entry_number=$("#Clients_entry_number").val();
var Clients_client_desc=$("#Clients_client_desc").val();
var Clients_contact_person=$("#Clients_contact_person").val();
var Clients_email=$("#Clients_email").val();
var Clients_status=$("#Clients_status").val();
var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 

	if(image_file=="" && Clients_logo=="")
	{
		var ext="";
	}else if(image_file!="" && Clients_logo=="")
	{
		var ext="gif";
	}else if(image_file=="" && Clients_logo!="")
	{
		var ext = Clients_logo.split('.').pop(); 
	}else{
		var ext = Clients_logo.split('.').pop(); 
	}
	if(ext=="gif" || ext=="png" || ext=="jpg"|| ext=="svg"){
		$("#logo_error").removeClass('error').html('').hide();
		if(Clients_sector_id!==""){
			$("#sector_error").removeClass('error').html('').hide();
			if(Clients_title!==""){
				$("#title_error").removeClass('error').html('').hide();
				if(Clients_entry_number!==""){
					$("#Clients_entry_number_error").removeClass('error').html('').hide();
					if(Clients_client_desc!==""){
					$("#description_error").removeClass('error').html('').hide();
						if(Clients_contact_person!==""){
							$("#contact_person_error").removeClass('error').html('').hide();
								if(emailReg.test(Clients_email) && Clients_email!=""){
									$("#email_error").removeClass('error').html('').hide();
									if(Clients_status!==""){
										$("#status_error").removeClass('error').html('').hide();
										$("#clients-form").submit();
									}else{
										$("#status_error").addClass('error').html('Please select the status.').show();
									}
								}else{
									$("#email_error").addClass('error').html('Please enter a valid client email.').show();
								}
						}else{
							$("#contact_person_error").addClass('error').html('Please enter the contact person.').show();
						}
				}else{
					$("#description_error").addClass('error').html('Please enter the client description.').show();
				}
				}else{
					$("#Clients_entry_number_error").addClass('error').html('Please enter the client entry number.').show();
				}
			}else{
				$("#title_error").addClass('error').html('Please enter the client name.').show();
			}
		}else{
			$("#sector_error").addClass('error').html('Please select the sector.').show();
		}
	}else{
		$("#logo_error").addClass('error').html('Only .GIF,.PNG and .JPG files are allowed.').show();
	}
}


