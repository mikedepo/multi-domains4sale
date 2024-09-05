<?php include('stats/stl.php'); 
$domain= $_SERVER['HTTP_HOST'];
// below added on 12/25/2018
// Source: http://carlofontanos.com/adding-a-simple-math-captcha-to-your-form-in-php/
    $num1=rand(1,9); //Generate First number between 1 and 9  
    $num2=rand(1,9); //Generate Second number between 1 and 9  
    $captcha_total=$num1+$num2;
    $math = "$num1"." + "."$num2"." =";
    $_SESSION['rand_code'] = $captcha_total;

// end of addition.

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
domainname =location.hostname;
</script>

  </head>
  <body>

    <div class="container">
      <div class="col-sm-6">
	   <h1> <?php echo $domain; ?> </h1>
	   <p id="domainname">Like the domain name?</p>		
		<h2>This domain is for sale Only - CAD $3500</h2>
		<h3>Contact site owner below:</h3>
		
        <form class="form-horizontal" role="form">
          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
              <input type="text" name="name" class="form-control" id="inputName" placeholder="Your Name">
            </div>
          </div>
		  
          <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Your Email">
            </div>
          </div>
          <div class="form-group">
            <label for="inputMessage" class="col-sm-2 control-label">Message</label>
            <div class="col-sm-10">
              <input type="text" name="message" class="form-control" id="inputMessage" placeholder="Your Message">
            </div>
          </div>
          <div></div>
              <label for="inputHuman" class="col-sm-2 control-label">
              <?php echo $math; ?></label>
            <div class="col-sm-10">
              <input type="text" style = "width: 150px !important;" name="human" class="form-control" id="human" placeholder="Are You Human?">
            </div>
          
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
           
        </form>  
      </div>
      <div class="col-sm-6">

      </div>
    </div>


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/common.js"></script>
  </body>
</html>