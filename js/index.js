$(document).ready(function(){
  $('#fname, #lname').keyup(function(){
  var fname = $('#fname').val();
  var lname = $('#lname').val();
  var fullname = fname + " " + lname;
  $('#fullname').val(fullname);
  });
  });
  