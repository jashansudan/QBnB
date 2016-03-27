$(document).ready(function(){

   $("#show_login").click(function(){
    showpopup();
   });
   $("#close_login").click(function(){
    hidepopup();
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

function hidepopup()
{
   $("#loginform").fadeOut();
   $("#loginform").css({"visibility":"hidden","display":"none"});
}

function message()
{
  alert('Account has been created');
}