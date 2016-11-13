/*
* Copyright 2016 Skovdev. All rights reserved.
*/

$(document).ready(function () {

window.setTimeout(function() {
    $(".alerts").fadeTo(1500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 5000);

});
