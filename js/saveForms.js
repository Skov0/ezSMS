/*
* Copyright 2016 Skovdev. All rights reserved.
*/

document.getElementById("InputNumber").value = getSavedValue("InputNumber");    // set the value to this input
document.getElementById("InputText").value = getSavedValue("InputText");   // set the value to this input

//Save the value function - save it to localStorage as (ID, VALUE)
function saveValue(e){
  var id = e.id;  // get the sender's id to save it .
  var val = e.value; // get the value.
  localStorage.setItem(id, val);// Every time user writing something, the localStorage's value will override .
}

//get the saved value function - return the value of "v" from localStorage.
function getSavedValue  (v){
  if (localStorage.getItem(v) === null) {
      return "";// You can change this to your defualt value.
  }
  return localStorage.getItem(v);
}

// detect when form is submitted, then clear localStorage
document.forms['main'].onsubmit = function() {
  localStorage.clear();
}
