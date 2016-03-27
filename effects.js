$(document).ready(function(){

   $("#show_login").click(function(){
    showpopup();
   });
   $("#add_property").click(function(){
    showpropertypopup();
   });
   $("#close_login").click(function(){
    hidepopup();
   });
      $("#close_property").click(function(){
    hidepropertypopup();
   });
   $("#createAccount").click(function(){
    message();
   });
});


function showpopup()
{
   $("#loginform").fadeIn();
   $("#loginform").css({"visibility":"visible","display":"block"});
}

function showpropertypopup()
{
   $("#propertyform").fadeIn();
   $("#propertyform").css({"visibility":"visible","display":"block"});
}

function hidepopup()
{
   $("#loginform").fadeOut();
   $("#loginform").css({"visibility":"hidden","display":"none"});
}

function hidepropertypopup()
{
   $("#propertyform").fadeOut();
   $("#propertyform").css({"visibility":"hidden","display":"none"});
}

function message()
{
  alert('Account has been created');
}