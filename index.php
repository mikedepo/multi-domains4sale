<?php
// Get domain prices from environment variable
$domainPrices = isset($_ENV['DOMAIN_PRICES']) ? json_decode($_ENV['DOMAIN_PRICES'], true) : [];
$domainRedirects = isset($_ENV['DOMAIN_REDIRECTS']) ? json_decode($_ENV['DOMAIN_REDIRECTS'], true) : [];

// Get the current domain and normalize it (remove "www." if present)
$domain = strtolower($_SERVER['HTTP_HOST']);
$domain = preg_replace('/^www\./', '', $domain); // Remove "www." if it exists

// Fetch the price and redirect link for the current domain
$priceValue = isset($domainPrices[$domain]) ? $domainPrices[$domain] : null;
$redirectUrl = isset($domainRedirects[$domain]) ? $domainRedirects[$domain] : 'https://default-redirect.com'; // Default redirect if not set

$price = $priceValue ? "CAD $" . $priceValue : "PLEASE CONTACT FOR PRICE";

// Get EmailJS keys from environment variables
$emailjsUserId = $_ENV['EMAILJS_USER_ID'] ?? '';
$emailjsServiceId = $_ENV['EMAILJS_SERVICE_ID'] ?? '';
$emailjsTemplateId = $_ENV['EMAILJS_TEMPLATE_ID'] ?? '';

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
      .error {
        color: red;
        font-size: 14px;
        margin-top: 5px;
      }
      .warning {
        color: orange;
        font-size: 14px;
        margin-top: 5px;
      }
    </style>

    <!-- EmailJS script -->
    <script type="text/javascript" src="https://cdn.emailjs.com/dist/email.min.js"></script>
    <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", function() {
        var emailjsUserId = "<?php echo $emailjsUserId; ?>";
        var emailjsServiceId = "<?php echo $emailjsServiceId; ?>";
        var emailjsTemplateId = "<?php echo $emailjsTemplateId; ?>";
        var priceValue = <?php echo $priceValue ? $priceValue : 'null'; ?>; // Get price as a number
        var redirectUrl = "<?php echo $redirectUrl; ?>"; // URL to redirect after 5 seconds

        emailjs.init(emailjsUserId); // Initialize EmailJS with User ID

        // Correct the script to set the domain name dynamically
        var domain = window.location.hostname;
        document.getElementById("domainname").innerHTML = "<h1>" + domain + "</h1>";

        // Set domain in the hidden input field
        document.getElementById("hiddenDomain").value = domain;

        // Show initial message and set up redirection
        const contentSection = document.getElementById('content-section');
        const redirectMessage = document.getElementById('redirect-message');
        let redirectTimeout;

        // Show the redirect message for 5 seconds
        redirectTimeout = setTimeout(function() {
          window.location.href = redirectUrl;
        }, 5000);

        // If the user clicks the link, stop the redirection and show the form content
        document.getElementById('cancel-redirect').addEventListener('click', function(e) {
          e.preventDefault();
          clearTimeout(redirectTimeout); // Stop the redirection
          redirectMessage.style.display = 'none'; // Hide the message
          contentSection.style.display = 'block'; // Show the form
        });

        // Function to show warning messages (already implemented)
        function showWarning(input, message) {
          let warningElement = input.parentElement.querySelector('.warning');
          if (!warningElement) {
            warningElement = document.createElement('div');
            warningElement.className = 'warning';
            input.parentElement.appendChild(warningElement);
          }
          warningElement.textContent = message;
        }

        // Real-time offer validation (already implemented)
        document.getElementById("inputOffer").addEventListener("input", function() {
          const offerValue = parseFloat(this.value);
          if (!isNaN(offerValue) && priceValue && offerValue < 0.8 * priceValue) {
            showWarning(this, "Offers are more likely to be accepted if they are 80% of the asking price or more.");
          } else {
            const warningElement = this.parentElement.querySelector('.warning');
            if (warningElement) {
              warningElement.remove();
            }
          }
        });

        // Form validation function
        function validateForm() {
          // Clear previous error messages
          document.querySelectorAll('.error').forEach(el => el.remove());

          let valid = true;
          const name = document.getElementById("inputName");
          const email = document.getElementById("inputEmail");
          const message = document.getElementById("inputMessage");
          const offer = document.getElementById("inputOffer");

          // Name validation
          if (name.value.trim() === "") {
            showError(name, "Name is required");
            valid = false;
          }

          // Email validation
          const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
          if (email.value.trim() === "") {
            showError(email, "Email is required");
            valid = false;
          } else if (!emailPattern.test(email.value)) {
            showError(email, "Please enter a valid email address");
            valid = false;
          }

          // Message validation
          if (message.value.trim() === "") {
            showError(message, "Message is required");
            valid = false;
          }

          // Offer validation
          if (offer.value.trim() === "") {
            showError(offer, "Offer is required");
            valid = false;
          } else if (isNaN(offer.value) || offer.value <= 0) {
            showError(offer, "Please enter a valid numeric offer");
            valid = false;
          }

          return valid;
        }

        // Function to show error messages
        function showError(input, message) {
          const errorElement = document.createElement('div');
          errorElement.className = 'error';
          errorElement.textContent = message;
          input.parentElement.appendChild(errorElement);
        }

        // Handle form submission with validation
        document.getElementById('contact-form').addEventListener('submit', function(event) {
          event.preventDefault(); // Prevent the default form submission behavior

          if (validateForm()) {
            // EmailJS sends the form directly, no need to use FormData
            emailjs.sendForm(emailjsServiceId, emailjsTemplateId, this)
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
          }
        });
      });
    </script>

  </head>
  <body>
    <div id="redirect-message" class="container text-center">
      <p>You will be redirected in 5 seconds, to buy this domain, <a href="#" id="cancel-redirect">click here</a>.</p>
    </div>

    <div id="content-section" class="container" style="display: none;">
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

        <div class="form-group">
          <label for="inputOffer">Make an Offer (CAD)</label>
          <input type="number" name="offer" class="form-control" id="inputOffer" placeholder="Enter your offer">
        </div>

        <!-- Hidden input to hold the domain name -->
        <input type="hidden" name="domainname" id="hiddenDomain">

        <div class="text-center">
          <button type="submit" class="btn submit-btn">Submit Inquiry</button>
        </div>
      </form>

      <!-- Confirmation message div -->
      <div id="confirmation-message" class="confirmation-message text-center" style="color:green;"></div>
    </div>

    <!-- Confetti JS Script added at the bottom to ensure it's loaded before being used -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
