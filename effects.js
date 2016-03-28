$(document).ready(function(){

   $("#show_login").click(function(){
    showpopup();
   });
   $("#add_property").click(function(){
    showpropertypopup();
   });
    $("#delete_property").click(function(){
      showdeletepropertypopup();
   });
   $("#close_login").click(function(){
    hidepopup();
   });
      $("#close_property").click(function(){
    hidepropertypopup();
   });
    $("#close_property_del").click(function(){
    hidedeletepropertypopup();
   });
   $("#createAccount").click(function(){
    message();
   });
   $("#createProperty").click(function(){
     goBack();
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

function showdeletepropertypopup()
{
   $("#deletepropertyform").fadeIn();
   $("#deletepropertyform").css({"visibility":"visible","display":"block"});
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

function hidedeletepropertypopup()
{
   $("#deletepropertyform").fadeOut();
   $("#deletepropertyform").css({"visibility":"hidden","display":"none"});
}

function message()
{
  alert('Account has been created');
}
function goBack()
{
  window.location.href = "dashboard.php";
}