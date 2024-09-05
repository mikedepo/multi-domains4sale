<?php
// Get domain prices from environment variable
$domainPrices = isset($_ENV['DOMAIN_PRICES']) ? json_decode($_ENV['DOMAIN_PRICES'], true) : [];

// Get the current domain and normalize it (remove "www." if present)
$domain = strtolower($_SERVER['HTTP_HOST']);
$domain = preg_replace('/^www\./', '', $domain); // Remove "www." if it exists

// Fetch the price for the current domain or display "PLEASE CONTACT FOR PRICE"
$price = isset($domainPrices[$domain]) ? "CAD $" . $domainPrices[$domain] : "PLEASE CONTACT FOR PRICE";

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Domain for Sale</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
      body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
      }
      h1, h2, h3 {
        color: #333;
      }
      .container {
        margin-top: 50px;
        max-width: 900px;
        background-color: #fff;
        padding: 40px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
      }
      .price {
        color: #28a745;
        font-size: 24px;
        font-weight: bold;
      }
      .submit-btn {
        background-color: #28a745;
        color: white;
        font-size: 18px;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 5px;
      }
      .submit-btn:hover {
        background-color: #218838;
        color: white;
      }
      .form-group label {
        font-weight: bold;
      }
      .confirmation-message {
        margin-top: 20px;
        font-size: 16px;
        font-weight: bold;
      }
    </style>

    <!-- EmailJS script -->
    <script type="text/javascript" src="https://cdn.emailjs.com/dist/email.min.js"></script>
    <script type="text/javascript">
      (function() {
          emailjs.init("Ev83eOudWBJjeARnB"); // Replace with your EmailJS user ID
      })();
    </script>

    <!-- Confetti JS -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>

    <script>
      // Correct the script to set the domain name dynamically
      document.addEventListener("DOMContentLoaded", function() {
        var domain = window.location.hostname;
        document.getElementById("domainname").innerHTML = "<h1>" + domain + "</h1>";

        // Set domain in the hidden input field
        document.getElementById("hiddenDomain").value = domain;
      });
    </script>

  </head>
  <body>

    <div class="container">
      <div class="text-center mb-5">
        <h1 id="domainname"> </h1> <!-- Domain name will be injected here -->
        <p class="lead">This domain is available for purchase!</p>        
        <!-- Dynamic price will be displayed here -->
        <h2 class="price">Price: <?php echo $price; ?></h2>
      </div>

      <h3>Interested? Contact the owner below:</h3>
      
      <form id="contact-form" class="mt-4">
        <div class="form-group">
          <label for="inputName">Your Name</label>
          <input type="text" name="name" class="form-control" id="inputName" placeholder="Enter your name">
        </div>

        <div class="form-group">
          <label for="inputEmail">Your Email</label>
          <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter your email">
        </div>

        <div class="form-group">
          <label for="inputMessage">Your Message</label>
          <textarea name="message" class="form-control" id="inputMessage" placeholder="Enter your message"></textarea>
        </div>

        <!-- Hidden input to hold the domain name -->
        <input type="hidden" name="domainname" id="hiddenDomain">

        <div class="text-center">
          <button type="submit" class="btn submit-btn">Submit Inquiry</button>
        </div>
      </form>

      <!-- Confirmation message div -->
      <div id="confirmation-message" class="confirmation-message text-center" style="color:green;"></div>

      <script type="text/javascript">
        document.getElementById('contact-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission behavior

            emailjs.sendForm('service_7hk18q4', 'template_d0wsefs', this)
                .then(function() {
                    // Show success message
                    document.getElementById('confirmation-message').innerHTML = "Thank you! Your inquiry has been sent.";

                    // Trigger confetti
                    confetti({
                      particleCount: 100,
                      spread: 70,
                      origin: { y: 0.6 }
                    });
                }, function(error) {
                    document.getElementById('confirmation-message').innerHTML = "Failed to send your inquiry. Please try again.";
                    document.getElementById('confirmation-message').style.color = "red";
                });
        });
      </script>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
