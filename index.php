<?php include('stats/stl.php'); 
$domain= $_SERVER['HTTP_HOST'];
// below added on 12/25/2018
$num1=rand(1,9);  
$num2=rand(1,9);  
$captcha_total=$num1+$num2;
$math = "$num1"." + "."$num2"." =";
$_SESSION['rand_code'] = $captcha_total;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Domain for Sale</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/common.css" rel="stylesheet">

    <script>
    document.getElementById("domainname").innerHTML = 
    "<h1>" + window.location.hostname+ "</h1>;
    domainname = location.hostname;
    </script>

    <!-- EmailJS script -->
    <script type="text/javascript" src="https://cdn.emailjs.com/dist/email.min.js"></script>
    <script type="text/javascript">
      (function() {
          emailjs.init("Ev83eOudWBJjeARnB"); // Replace with your EmailJS user ID
      })();
    </script>

    <!-- Confetti JS -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>

  </head>
  <body>

    <div class="container">
      <div class="col-sm-6">
        <h1> <?php echo $domain; ?> </h1>
        <p id="domainname">Like the domain name?</p>        
        <h2>This domain is for sale Only - CAD $13500</h2>
        <h3>Contact site owner below:</h3>
        
        <form id="contact-form">
          <div class="form-group">
              <label for="inputName">Name</label>
              <input type="text" name="name" class="form-control" id="inputName" placeholder="Your Name">
          </div>

          <div class="form-group">
              <label for="inputEmail">Email</label>
              <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Your Email">
          </div>

          <div class="form-group">
              <label for="inputMessage">Message</label>
              <textarea name="message" class="form-control" id="inputMessage" placeholder="Your Message"></textarea>
          </div>

          <button type="submit" class="btn btn-success">Submit</button>
        </form>

        <!-- Confirmation message div -->
        <div id="confirmation-message" style="margin-top: 20px; font-weight: bold; color: green;"></div>

        <script type="text/javascript">
            document.getElementById('contact-form').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission behavior

                emailjs.sendForm('service_7hk18q4', 'template_d0wsefs', this)
                    .then(function() {
                        // Show success message
                        document.getElementById('confirmation-message').innerHTML = "Email sent successfully!";

                        // Trigger confetti
                        confetti({
                          particleCount: 100,
                          spread: 70,
                          origin: { y: 0.6 }
                        });
                    }, function(error) {
                        document.getElementById('confirmation-message').innerHTML = "Failed to send email: " + JSON.stringify(error);
                        document.getElementById('confirmation-message').style.color = "red";
                    });
            });
        </script>
      </div>
      <div class="col-sm-6">
      
      </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/common.js"></script>
  </body>
</html>
