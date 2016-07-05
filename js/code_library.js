var Ajax = (function () {
    function Ajax(loading_element, target_url, request_data) {
        this.loading_element = loading_element;
        this.target_url = target_url;
        this.request_data = request_data;
    }
    Ajax.prototype.makeRequest = function (target_url, request_data, beforeSave, afterSave) {
        $.ajax({
            url: target_url,
            data: request_data != "undefined" ? request_data : "",
            beforeSend: function () {
				if(typeof beforeSave !== "undefined"){
					if(typeof (beforeSave) == typeof (Function)) {
						beforeSave();
					} else {
					}
				}
            }
        }).done(function (response) {
			if(typeof afterSave !== "undefined"){
				if(typeof (afterSave) == typeof (Function)) {
					afterSave(response);
				}
			}else{
				console.log("Request completed.");
			}
        });
    };
    Ajax.prototype.saveData = function (target_url, request_data, beforeSave, afterSave) {
        $.ajax({
            url: target_url,
            data: request_data,
            beforeSend: function () {
                if(typeof beforeSave != "undefined"){
					if(typeof (beforeSave) == typeof (Function)) {
						beforeSave();
					} else {
					}
				}
            }
        }).done(function (response) {
            if(isNaN(response)) {
				ShowNotification('warning',response);
            } else {
                if(parseInt(response) == 1) {
                    if(typeof afterSave != "undefined"){
						if(typeof (afterSave) == typeof (Function)) {
							ShowNotification('success','Record saved successfully.', function(){
								afterSave();
							});
						} else {
							ShowNotification('success','Record saved successfully.');
						}	
				    }else{
						ShowNotification('success','Record saved successfully.');
					}
                } else {
                    ShowNotification('warning',response);
                }
            }
        });
    };
    return Ajax;
})();

var Validation = (function () {
    function Validation(email_reg, string_reg, mobile_phone_reg, mobile_phone_length, number, password, para, date) {
        this.email_reg = jQuery.type(email_reg) === "regexp" ? email_reg : /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        this.mobile_phone_reg = jQuery.type(mobile_phone_reg) === "regexp" ? mobile_phone_reg : /(\+254|0)7\d{8}/;
        this.mobile_phone_length = jQuery.type(mobile_phone_length) === "number" ? mobile_phone_length : 10;
        this.string_reg = jQuery.type(string_reg) === "regexp" ? string_reg : /^[a-zA-Z'\- ]+$/;
		this.number_reg = jQuery.type(number) === "regexp" ? number : /^[-+]?[0-9]*\.?[0-9]*([eE][-+]?[0-9]+)?$/;
		this.password_reg = jQuery.type(password) === "regexp" ? password : /^.*(?=.{8,})(?=.*\d)(?=.*[a-z]).*$/;
		this.paragraph_reg = jQuery.type(para) === "regexp" ? para : /^[a-zA-Z0-9'.,@!?()?&\- ]+$/;
		this.date_reg = jQuery.type(date) === "regexp" ? date : /^\d{1,2}[\/\-]\d{1,2}[\/\-]\d{4}$/;
    }
    Validation.prototype.validate_number = function (element) {
        var number = $("#" + element.id).val();
        if(this.number_reg.test(number) && number > 0) {
			this.error_log = "";
			$("#" + element.id).css('border','1px solid #DDDDDD');
            return true;
        } else {
            this.error_log = "Invalid number supplied (e.g 0 - 9)";
			$("#" + element.id).css('border','1px solid red');
            return false;
        }
    };
    Validation.prototype.validate_email = function (element) {
        var email = $("#" + element.id).val();
        if(this.email_reg.test(email)) {
            this.error_log = "";
			$("#" + element.id).css('border','1px solid #DDDDDD');
            return true;
        } else {
            this.error_log = "The email address is invalid (e.g johndoe@oursite.co.ke)";
			$("#" + element.id).css('border','1px solid red');
            return false;
        }
    };
	Validation.prototype.validate_date = function (element) {
        var date = $("#" + element.id).val();
        if(this.date_reg.test(date)) {
            this.error_log = "";
			$("#" + element.id).css('border','1px solid #DDDDDD');
            return true;
        } else {
            this.error_log = "The date is invalid (e.g 01-01-2012 or 01/01/2013)";
			$("#" + element.id).css('border','1px solid red');
            return false;
        }
    };
	Validation.prototype.validate_para = function (element) {
        var para = $("#" + element.id).val();
        if(this.paragraph_reg.test(para)) {
            this.error_log = "";
			$("#" + element.id).css('border','1px solid #DDDDDD');
            return true;
        } else {
            this.error_log = "The paragraph has invalid characters (John doe has 1 car.)";
			$("#" + element.id).css('border','1px solid red');
            return false;
        }
    };
	Validation.prototype.validate_password = function (element) {
        var password = $("#" + element.id).val();
        if(this.password_reg.test(password)) {
            this.error_log = "";
			$("#" + element.id).css('border','1px solid #DDDDDD');
            return true;
        } else {
            this.error_log = "The password is invalid (e.g johndoe123)";
			$("#" + element.id).css('border','1px solid red');
            return false;
        }
    };
    Validation.prototype.validate_mobile = function (element) {
        var mobile_number = $("#" + element.id).val().replace(/\s/g, '');
        if(mobile_number.length == this.mobile_phone_length) {
            if(this.mobile_phone_reg.test(mobile_number)) {
                this.error_log = "";
				$("#" + element.id).css('border','1px solid #DDDDDD');
                return true;
            } else {
                this.error_log = "Invalid mobile number supplied (e.g 0711000000)";
				$("#" + element.id).css('border','1px solid red');
                return false;
            }
        } else {
            this.error_log = "Mobile number is too short alllowed length is " + this.mobile_phone_length;
			$("#" + element.id).css('border','1px solid red');
            return false;
        }
    };
    Validation.prototype.validate_string = function (element) {
        var _string = $("#" + element.id).val();
		if(_string.length > 0 ){
			 if(this.string_reg.test(_string)) {
				this.error_log = "";
				$("#" + element.id).css('border','1px solid #DDDDDD');
				return true;
			} else {
				this.error_log = "Invalid characters in string";
				$("#" + element.id).css('border','1px solid red');
				return false;
			}	
		}else{
			return false;
		}
    };
    return Validation;
})();
window.onload = function () {
    var validator_call = new Validation();
	var ajax_call = new Ajax();
};