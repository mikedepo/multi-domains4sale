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
		<h2>This domain is for sale Only - CAD $13500</h2>
		<h3>Contact site owner below:</h3>
		<a href="mailto:johnlowen69@outlook.com">johnlowen69@outlook.com<a/>
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