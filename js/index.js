$(document).ready(function() {
  $('#fname').on('input', function () {
    const val = $(this).val().trim();
    if (val === "") {
      showError('#fname', 'First Name is required.');
    } 
    else if (!/^[a-zA-Z ]+$/.test(val)) {
        showError('#fname', 'Only alphabets allowed.');
    } 
    else {
        clearError('#fname');
    }
  });
  $('#lname').on('input', function () {
    const val = $(this).val().trim();
    if (val === "") {
      showError('#lname', 'Last Name is required.');
    } 
    else if (!/^[a-zA-Z ]+$/.test(val)) {
      showError('#lname', 'Only alphabets allowed.');
    } 
    else {
      clearError('#lname');
    }
  });
  $('#fname, #lname').keyup(function() {
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var fullname = fname + " " + lname;
    $('#fullname').val(fullname);
  });
  $('#contact').on('input', function () {
    const val = $(this).val().trim();
    if (val === "") {
      showError('#contact', 'Contact Number is required.');
    } 
    else if (!/^\+91[6-9]\d{9}$/.test(val)) {
      showError('#contact', 'Only numeric 10 digit number is allowed.');
    } 
    else {
      clearError('#contact');
    }
  }); 
  $('#email').on('input', function () {
    const val = $(this).val().trim();
    if (val === "") {
      showError('#email', 'Email is required.');
    } 
    else if (!/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/.test(val)) {
      showError('#email', 'Invalid email format.');
    } 
    else {
      clearError('#email');
    }
  });
  $('#result').on('input', function () {
    const lines = $(this).val().trim().split('\n');
    let isValid = true;
    for (let line of lines) {
      const parts = line.split('|');
      if (parts.length !== 2 || !/^[a-zA-Z ]+$/.test(parts[0].trim()) || isNaN(parts[1].trim())) {
        isValid = false;
        break;
      }
    }
    if (!isValid) {
      showError('#result', 'Format: Subject | Marks (e.g. Math | 90)');
    }
    else {
      clearError('#result');
    }
  });
  function showError(selector, message) {
    let el = $(selector).next('.error');
    if (el.length === 0) {
      $(selector).after('<span class="error"></span>');
      el = $(selector).next('.error');
    }
    el.text(message);
  }
  function clearError(selector) {
    let el = $(selector).next('.error');
    if (el.length > 0) {
      el.text('');
    }
  }
});
  