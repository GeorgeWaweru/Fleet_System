function adminDeleteRecord(controller,delete_id,grid)
{
	var path="index.php?r="+controller+"/delete&id="+delete_id;						
		$.ajax({ 
		url: path,
		type: "POST"
		}).done(function(html){
			if(grid!='system-grid'){
			$('#'+grid).yiiGridView('update', {
				data: $(this).serialize()
			});
			}else{
				window.location.reload();
			}
		});		
}


function highlightMenu(menu_name)
	{
		$( "li" ).each(function( index ){
			if($(this).text()==menu_name)
			{
				$( this ).addClass('active');
			}
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

	

	
	
function formFieldValue(field)
{
	return fieldvalue=document.getElementById(field).value;
}





