<?php

if(isset($_REQUEST['debugmode'])){
    if($_REQUEST['debugmode']){
        $_SESSION['debugmode']=true;
    }
    else{
        $_SESSION['debugmode']=false;
    }
}
if(isset($_SESSION['debugmode']) && $_SESSION['debugmode'] && $_SESSION['adminloggedinstatus']){
    error_reporting(E_ALL);
    ini_set('display_errors',1);
}

if(function_exists('mysql_safequery') == false) {
    function mysql_safequery($query,$params=false) {
        if ($params) {
            foreach ($params as &$v) { $v = mysql_real_escape_string($v); }
            $sql_query = vsprintf( str_replace("?","'%s'",$query), $params );
            $sql_query = mysql_query($sql_query);
        } else {
            $sql_query = mysql_query($query);
        }
        return ($sql_query);
    }
}
function hook_opensrsemail_ActivateTemplatesChangesHeadOutput($vars){
     $script = '<script type="text/javascript">
     
     $.extend({
          password: function (length, special) {
            var iteration = 0;
            var password = "";
            var randomNumber;
            if(special == undefined){
                var special = false;
            }
            while(iteration < length){
                randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
                if(!special){
                    if ((randomNumber >=33) && (randomNumber <=47)) { continue; }
                    if ((randomNumber >=58) && (randomNumber <=64)) { continue; }
                    if ((randomNumber >=91) && (randomNumber <=96)) { continue; }
                    if ((randomNumber >=123) && (randomNumber <=126)) { continue; }
                }
                iteration++;
                password += String.fromCharCode(randomNumber);
            }
            return password;
          }
        });

        //<![CDATA[
            jQuery(document).ready(function(){
    ';
      
     if($vars['filename'] == "clientarea")
     {
        $script.='
            jQuery("input[name=\'passwordConfirm\']").blur(function(){
                var password = jQuery("input[name=\'password\']").val(); 
                var passwordConfirm = jQuery("input[name=\'passwordConfirm\']").val(); 
                if(password !=  passwordConfirm)
                {
                    if(!jQuery("#msg").length)
                    {
                        jQuery("input[name=\'passwordConfirm\']").after("<div id=\'msg\'></div>");
                    }
                    jQuery("#msg").html("<span style=\'color:#DF0101\'>Your passwords do not match.</span>");
                    jQuery(".btn-primary").prop("disabled", true);
                }
                else
                {
                    jQuery("#msg").html("");
                    jQuery(".btn-primary").prop("disabled", false);
                }
            })
        '; 
        
        $script.='
            jQuery("input[name=\'title\']").blur(function(){
                if(this.value.length > 60)
                {
                    if(!jQuery("#msgtitle").length)
                    {
                        jQuery("input[name=\'title\']").after("<div id=\'msgtitle\'></div>");
                    }
                    jQuery("#msgtitle").html("<span style=\'color:#DF0101\'>Maximum 60 characters are allowed for Title. (ex. Ms. or Mr.)</span>");
                    jQuery(".btn-primary").prop("disabled", true);
                }
                else
                {
                    jQuery("#msgtitle").html("");
                    jQuery(".btn-primary").prop("disabled", false);
                }
            })
        ';
        
        $script.='
            jQuery("input[name=\'firstName\']").blur(function(){
                if(this.value.length > 255)
                {
                    if(!jQuery("#msgfirstName").length)
                    {
                        jQuery("input[name=\'firstName\']").after("<div id=\'msgfirstName\'></div>");
                    }
                    jQuery("#msgfirstName").html("<span style=\'color:#DF0101\'>Maximum 255 characters are allowed for First Name.</span>");
                    jQuery(".btn-primary").prop("disabled", true);
                }
                else
                {
                    jQuery("#msgfirstName").html("");
                    jQuery(".btn-primary").prop("disabled", false);
                }
            })
        ';
        
        $script.='
            jQuery("input[name=\'lastName\']").blur(function(){
                if(this.value.length > 255)
                {
                    if(!jQuery("#msglastName").length)
                    {
                        jQuery("input[name=\'lastName\']").after("<div id=\'msglastName\'></div>");
                    }
                    jQuery("#msglastName").html("<span style=\'color:#DF0101\'>Maximum 255 characters are allowed for Last Name.</span>");
                    jQuery(".btn-primary").prop("disabled", true);
                }
                else
                {
                    jQuery("#msglastName").html("");
                    jQuery(".btn-primary").prop("disabled", false);
                }
            })
        ';
        
        $script.='
            jQuery("input[name=\'phone\']").blur(function(){
                if(this.value.length > 30)
                {
                    if(!jQuery("#msgphone").length)
                    {
                        jQuery("input[name=\'phone\']").after("<div id=\'msgphone\'></div>");
                    }
                    jQuery("#msgphone").html("<span style=\'color:#DF0101\'>Maximum 30 characters are allowed for Phone.</span>");
                    jQuery(".btn-primary").prop("disabled", true);
                }
                else
                {
                    jQuery("#msgphone").html("");
                    jQuery(".btn-primary").prop("disabled", false);
                }
            })
        ';
        
        $script.='
            jQuery("input[name=\'fax\']").blur(function(){
                if(this.value.length > 30)
                {
                    if(!jQuery("#msgfax").length)
                    {
                        jQuery("input[name=\'fax\']").after("<div id=\'msgfax\'></div>");
                    }
                    jQuery("#msgfax").html("<span style=\'color:#DF0101\'>Maximum 30 characters are allowed for Fax.</span>");
                    jQuery(".btn-primary").prop("disabled", true);
                }
                else
                {
                    jQuery("#msgfax").html("");
                    jQuery(".btn-primary").prop("disabled", false);
                }
            })
        ';
        
        /*$script.='
            jQuery("input[name=\'phone\']").blur(function(){
                if(!this.value.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/) || this.value.length > 30)
                {
                    if(!jQuery("#msgphone").length)
                    {
                        jQuery("input[name=\'phone\']").after("<div id=\'msgphone\'></div>");
                    }
                    jQuery("#msgphone").html("<span style=\'color:#DF0101\'>Invalid Phone Number Format.</span>");
                    jQuery(".btn-primary").prop("disabled", true);
                }
                else
                {
                    jQuery("#msgphone").html("");
                    jQuery(".btn-primary").prop("disabled", false);
                }
            })
        ';
        
        $script.='
            jQuery("input[name=\'fax\']").blur(function(){
                if(!this.value.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/) || this.value.length > 30)
                {
                    if(!jQuery("#msgfax").length)
                    {
                        jQuery("input[name=\'fax\']").after("<div id=\'msgfax\'></div>");
                    }
                    jQuery("#msgfax").html("<span style=\'color:#DF0101\'>Invalid Fax Number Format.</span>");
                    jQuery(".btn-primary").prop("disabled", true);
                }
                else
                {
                    jQuery("#msgfax").html("");
                    jQuery(".btn-primary").prop("disabled", false);
                }
            })
        ';*/
        
        $script.='
            jQuery("input[name=\'mailbox\']").blur(function(){
                var email =  jQuery("input[name=\'mailbox\']").val().concat("@test.com");
                if(!email.match(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/) || this.value.length <= 0)
                {
                    if(!jQuery("#msgmailbox").length)
                    {
                        jQuery("span[id=\'sdomain\']").after("<div id=\'msgmailbox\'></div>");
                    }
                    if(this.value.length > 0)
                        jQuery("#msgmailbox").html("<span style=\'color:#DF0101\'>Invalid Email Format (ex. johndoe@domain.com).</span>");
                    else
                        jQuery("#msgmailbox").html("<span style=\'color:#DF0101\'>Email is required (ex. johndoe@domain.com).</span>");
                    jQuery(".btn-primary").prop("disabled", true);
                }
                else
                {
                    jQuery("#msgmailbox").html("");
                    jQuery(".btn-primary").prop("disabled", false);
                }
            })
        ';
        
        $script.='
            jQuery("input[name=\'forwardEmail\']").blur(function(){
                if(this.value.length <= 0)
                {
                    if(!jQuery("#msgforwardEmail").length)
                    {
                        jQuery("input[name=\'forwardEmail\']").after("<div id=\'msgforwardEmail\'></div>");
                    }
                    jQuery("#msgforwardEmail").html("<span style=\'color:#DF0101\'>You must provide valid email address(es) to forward to.</span>");
                    jQuery(".btn-primary").prop("disabled", true);
                }   
                else
                {   
                    var forwardEmails = this.value.split(",");
                    for(var i=0;i<forwardEmails.length;i++)
                    {
                            if(!forwardEmails[i].match(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/))
                            {
                                if(!jQuery("#msgforwardEmail").length)
                                {
                                    jQuery("input[name=\'forwardEmail\']").after("<div id=\'msgforwardEmail\'></div>");
                                }
                                jQuery("#msgforwardEmail").html("<span style=\'color:#DF0101\'>Email address "+ forwardEmails[i] +" is not valid.</span>");
                                jQuery(".btn-primary").prop("disabled", true);
                                break;
                            }
                            else
                            {
                                jQuery("#msgforwardEmail").html("");
                                jQuery(".btn-primary").prop("disabled", false);
                            }
                            
                    }
                }
            })
        ';

        $script.='
            jQuery("input[name=\'alias\']").blur(function(){
                var email =  jQuery("input[name=\'alias\']").val().concat("@test.com");
                if(!email.match(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/) || this.value.length <= 0)
                {
                    if(!jQuery("#msg_alias_domain").length)
                    {
                        jQuery("select[name=\'alias_domain\']").after("<div id=\'msg_alias_domain\'></div>");
                    }
                    if(this.value.length > 0)
                        jQuery("#msg_alias_domain").html("<span style=\'color:#DF0101\'>Invalid Email Format (ex. johndoe@domain.com).</span>");
                    else
                        jQuery("#msg_alias_domain").html("<span style=\'color:#DF0101\'>Email is required (ex. johndoe@domain.com).</span>");
                    jQuery(".btn-primary").prop("disabled", true);
                }
                else
                {
                    jQuery("#msg_alias_domain").html("");
                    jQuery(".btn-primary").prop("disabled", false);
                }
            })
        ';
        
        $script.='
            jQuery("#generatePassword").click(function(e){  
                // First check which link was clicked
                linkId = $(this).attr("id");
                password = "";
                if (linkId == "generatePassword"){
         
                    // If the generate link then create the password variable from the generator function
                    password = $.password(12,false);
         
                    // Empty the random tag then append the password and fade In
                    $("#random").empty().val(password).fadeIn("slow");
                    $("input[name=\'password\']").val(password);
                    $("input[name=\'passwordConfirm\']").val(password);

                } 
                e.preventDefault();
            })
        ';
     }
     
     $script.="
        });
        //]]>
        </script>";
     return $script;
}

add_hook('ClientAreaHeadOutput',1,'hook_opensrsemail_ActivateTemplatesChangesHeadOutput');

?>