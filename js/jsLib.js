/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



function ajaxPush(serve,successRedirection,divid,messageTitle,messageCateg){
        // alert("Tuko hapa");
        message=msgText=$("#"+divid).val();
        changeTitle=$("#"+messageTitle).val();
        if(message!='' || changeTitle!=''){
            
       
         hs.htmlExpand(this, { 
			width: 400, creditsPosition: 'bottom left', 
			headingEval: 'this.a.title', wrapperClassName: 'titlebar', headingText: 'Sending Message', maincontentText: "Please Wait" } );
 
                   $.ajax({
			type: "GET",
			url: serve,
			data: {messageTitle:changeTitle, messageText:message, messageCateg:messageCateg,messageStatus:'pending'},
			beforeSend: function(x) {
                          
			  if(x && x.overrideMimeType) {
				x.overrideMimeType("application/j-son;charset=UTF-8");
			  }
                       // alert("Sending");
			},
			dataType: "json",
			success: function(data){
			  // do stuff...
                          // alert("Success");
                          window.location.refresh=successRedirection;
                       
			},
                         error: function (response, status) {
                          //  alert("Error! "+response+" "+status);
                        }

		});
                
         }
}
