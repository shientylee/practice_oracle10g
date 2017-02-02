<script>
<?php

      if (!isset($_SESSION['token_username'])){
        echo "$('#login_modal').modal('open');";
      }

      ?>
      $('#login_progress').hide();
      $('#register_progress').hide();
      $("#register_username_progress").hide();
      $("#register_email_progress").hide();
      $("#login_form").submit(function(){ 
      event.preventDefault();
      $('.button-collapse').sideNav('hide');
      $('#login_back').hide();
      $('#login_submit').hide();
      $('#login_progress').show();
      var str = $(this).serialize();
       $.ajax({
                  type: 'post',
                  url: 'scripts/login.php',
                  data: str,
                  success: function (msg) {
                    Materialize.toast('Processing . . .', 3000);
                    if (msg == 'OK'){
                      setTimeout('loggedin();', 3000); 

                    }else{
                      setTimeout('error();', 3000); 
                      
                    }
                  }
          });
      });
      $("#register_form").submit(function(){ 
      event.preventDefault();
      $('.button-collapse').sideNav('hide');
      $('#register_submit').hide();
      $('#register_progress').show();
      var str2 = $(this).serialize();
       $.ajax({
                  type: 'post',
                  url: 'scripts/register1.php',
                  data: str2,
                  success: function (msg1) {
                    if (msg1 == "OK"){
                      Materialize.toast('Processing . . .', 3000);
                      setTimeout('registered();', 3000); 
                    }else if(msg1 == "Username already taken"){
                      Materialize.toast('Username already taken', 3000);
                      registerresetform();
                    }else if(msg1 == "Letters and spaces are only allowed in First Name"){
                      Materialize.toast('Letters and spaces are only allowed in First Name', 3000);
                      registerresetform();
                      $("#register_fname").css({"border-bottom": "1px solid #f44336", "box-shadow": "0 1px 0 0 #f44336"});
                    }else if(msg1 == "Letters and spaces are only allowed in Last Name"){
                      Materialize.toast('Letters and spaces are only allowed in Last Name', 3000);
                      registerresetform();
                      $("#register_lname").css({"border-bottom": "1px solid #f44336", "box-shadow": "0 1px 0 0 #f44336"});
                    }else if(msg1 == "Password not match"){
                      Materialize.toast("Password doesn't match", 3000);
                      registerresetform();
                    }else if(msg1 == "Password not match"){
                      Materialize.toast("Password doesn't match", 3000);
                      registerresetform();
                    }else if(msg1 == "Email already taken"){
                      Materialize.toast("Email already taken", 3000);
                      registerresetform();
                    }else if(msg1 == "Only letters and white space allowed in E-Mail filled"){
                      Materialize.toast("Illegal characters detected on E-Mail field", 3000);
                      registerresetform();
                    }else if(msg1 == "Invalid E-Mail format"){
                      Materialize.toast("Invalid E-Mail format", 3000);
                      registerresetform();  
                    }else if(msg1 == "ERROR"){
                      Materialize.toast("Error on registering, Please contact Administrator", 3000);
                      registerresetform();  
                    }else{
                      Materialize.toast("Unidentified Error, Please contact Administrator", 3000);
                      registerresetform();  
                    }
                  }
          });
      });
      });
      function registerresetform()
      {
      $('#register_submit').show();
      $('#register_progress').hide();
      }
      function registered()
      {
      $('.modal').modal('close');
      Materialize.toast('Successfully Registered!', 5000);
      $('#register_form')[0].reset();
      $('#register_submit').show();
      $('#register_progress').hide();
      }
      function loggedin()
      {
      $('.modal').modal('close');
      Materialize.toast('Successfully Logged In!', 5000);
      $('#login_form')[0].reset();
      $('#login_submit').show();
      $('#login_submit').show();
      $('#login_progress').hide();
      $("#sidenav-pc").load('index.php #sidenav-pc');
      $( "#mobile_login" ).replaceWith( "<li><a href='logout.php'>Logout</a></li>" );
      }
      function error()
      {
      Materialize.toast('Username or Password is incorrect!', 5000);
      $('#login_form')[0].reset();
      $('#login_submit').show();
      $('#login_submit').show();
      $('#login_progress').hide();
      }
      function checkAvailabilityUsername() {
      $("#register_username_progress").show();
      jQuery.ajax({
      url: "scripts/check_availability_username.php",
      data:'username='+$("#register_username").val(),
      type: "POST",
      success:function(data){
      if(data == "<small class='green-text'>Username available</small>"){
        $("#register_username").css({"border-bottom": "1px solid #4caf50", "box-shadow": "0 1px 0 0 #4caf50"});
      }else{
        $("#register_username").css({"border-bottom": "1px solid #f44336", "box-shadow": "0 1px 0 0 #f44336"});
      }
      $("#register_username_response").html(data);
      $("#register_username_progress").hide();
      },
      error:function (){}
      });
      }

      function checkAvailabilityEmail() {
      $("#register_email_progress").show();
      jQuery.ajax({
      url: "scripts/check_availability_email.php",
      data:'email='+$("#register_email").val(),
      type: "POST",
      success:function(data1){
      if(data1 == "<small class='green-text'>Email available</small>"){
        $("#register_email").css({"border-bottom": "1px solid #4caf50", "box-shadow": "0 1px 0 0 #4caf50"});
      }else{
        $("#register_email").css({"border-bottom": "1px solid #f44336", "box-shadow": "0 1px 0 0 #f44336"});
      }
      $("#register_email_response").html(data1);
      $("#register_email_progress").hide();
      },
      error:function (){}
      });
      }
    </script>