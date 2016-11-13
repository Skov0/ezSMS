/*
* Copyright 2016 Skovdev. All rights reserved.
*/

function DeleteSMS (id) {
  $.ajax({
      type: "POST",
      src: '../backend/Actions.php',
      data:{ smsID : id },
      success:function(html) {
        location.reload();
      }
  });
}

function ViewSMS (id) {
  var win = window.open("../dashboard/viewsms.php?id=" + id, '_blank');
  win.focus();
}

function DeleteUser(id) {
  $.ajax({
      type: "POST",
      src: '../backend/Actions.php',
      data:{ userID : id },
      success:function(html) {
        location.reload();
      }
  });
}

function DeleteContact(id) {
  $.ajax({
      type: "POST",
      src: '../backend/Actions.php',
      data:{ contactID : id },
      success:function(html) {
        location.reload();
      }
  });
}

$(document).ready(function(){
$('#edituser').on('show.bs.modal', function (e) {
    var rowid = $(e.relatedTarget).data('id');
    var purpose = 'user';
    $.ajax({
        type : 'post',
        url : 'http://localhost/ezsms/backend/fetch_data.php', //Here you will fetch records
        data :  'rowid='+ rowid + '&purpose=' + purpose, //Pass $id
        success : function(data){
        $('.fetched-data').html(data);//Show fetched data from database
        }
    });
 });
});

$(document).ready(function(){
$('#editcontact').on('show.bs.modal', function (e) {
    var rowid = $(e.relatedTarget).data('id');
    var purpose = 'contact';
    $.ajax({
        type : 'post',
        url : 'http://localhost/ezsms/backend/fetch_data.php', //Here you will fetch records
        //data :  'rowid='+ rowid, //Pass $id
        data :  'rowid='+ rowid + '&purpose=' + purpose, //Pass $id
        success : function(data){
        $('.fetched-data').html(data);//Show fetched data from database
        }
    });
 });
});
