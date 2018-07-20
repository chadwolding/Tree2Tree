<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Runs if the cancel button is clicked for sending a message to Josh
if (isset($_POST['cancelMessageButton'])) {
    header('location: #contactContainer');
}

// Runs if the submit button is clicked to send a message.
if (isset($_POST['sendMessageButton'])) {

    //Create/Sanitize variables from user inputs on message form.
    $first_name = filter_var($_POST['firstName'], FILTER_SANITIZE_STRING);
    $last_name = filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    //Input error messages.
    $first_name_error = '';
    $last_name_error = '';
    $phone_error = '';
    $email_error = '';
    $message_error = '';

    // Validate first name.
    if (empty($first_name)) {
        $first_name_error = 'First name is required';
    } elseif (strlen($first_name) > 40) {
        $first_name_error = 'First name must be less than 40 characters';
    }

    // Validate last name.
    if (empty($last_name)) {
        $last_name_error = 'Last name is required';
    } elseif (strlen($last_name) > 40) {
        $last_name_error = 'Last name must be less than 40 characters';
    }

    // Validate phone number.
    if (!empty($phone)) {
        if (!preg_match('/^\+?(\(?[0-9]{3}\)?|[0-9]{3})[-\.\s]?[0-9]{3}[-\.\s]?[0-9]{4}$/', $phone)) {
            $phone_error = 'Please enter a valid phone number';
        }
    }

    // Validate email.
    if (empty($email)) {
        $email_error = 'An email is required';
    } elseif (strlen($email) > 75) {
        $email_error = 'Emails must be less than 75 characters';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = 'Email is not valid';
    }

    // Validate email body
    if (empty($message)) {
        $message_error = 'A message is required';
    } elseif (strlen($message) > 1500) {
        $message_error = 'Messages must be less characters';
    }

    // If all inputs are valid, send the email.
    if (empty($first_name_error) && empty($last_name_error) && empty($email_error) && empty($phone_error) && empty($message_error)) {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication

            // ADD JOSH'S INFO
            $mail->Username = 'example@gmail.com';                 // SMTP username
            $mail->Password = 'password';                           // SMTP password

            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            // EDIT WITH JOSH'S INFO
            $mail->setFrom('example@gmail.com');
            $mail->addAddress('example@gmail.com');
            $mail->addReplyTo($email);     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $first_name . ' ' . $last_name . ' sent you a message!';
            $mail->Body = $message . '<br><br><h3>Phone Number: <a href="tel:1' . $phone . '"> ' . $phone . ' </h3>';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo '<script>alert("Your message has been sent.");
            window.location = "http://www.tree2treellc.com/index.php";
            </script>';

        } catch (Exception $e) {
            //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    } else {
        echo '<script>alert("Something went wrong. Please try again.")</script>';
    }


}

?>
<!doctype html>
<html lang="en">

<head>
    <title>Tree To Tree</title>
    <link rel="icon" href="images/logo.jpg">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/about.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="css/gallery.css">

    <!--FONTS-->
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">

</head>

<body>
<div style="clear: both;"></div>
<div>
    <!-- Nav -->
    <img id="title" src="images/logo.jpg">
    <ul class="nav" id="pageLinks">
        <li><a href="#">Home</a></li>
        <li><a href="#serviceContainer">Services</a></li>
        <li><a href="#aboutContainer">About</a></li>
        <li><a href="#galleryContainer">Gallery</a></li>
        <li><a href="#contactContainer">Contact</a></li>
        <button id="collapseBar" onclick="toggleNavPage()"><i class="fa fa-bars right fa-2x" aria-hidden="true"></i>
        </button>
    </ul>
</div>

<!-- Nav -->
<div class="pageNav" id="fullPageMenu">
    <div class="menuContent">
        <a id="phone" href="#"><i class="fa fa-phone fa-lg" aria-hidden="true"></i>111-111-1111</a>
        <a><img id="menuImg" src="images/logo.jpg"></a>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#serviceContainer">Services</a></li>
            <li><a href="#aboutContainer">About</a></li>
            <li><a href="#galleryContainer">Gallery</a></li>
            <li><a href="#contactContainer">Contact</a></li>
        </ul>
        <hr>
        <h3>7 Days A Week</h3>
        <h3>7AM - 7PM</h3>
    </div>
</div>

<!-- Landing Image -->
<div class="landingImg">
    <div id="landingTextContainer">
        <h1 id="landingImgTitle">Tree To Tree</h1>
    </div>
</div>

<!-- Services Section -->
<div class="container" id="serviceContainer">
    <h1 id="serviceTitle" class="sectionTitle">Services</h1>
    <div id="serviceGrid">
        <div id="trimming">
            <div class="serviceThumbnail">
                <img src="images/trimming_sm.jpg" class="portrait">
            </div>
            <h1>Pruning/Trimming</h1>
            <p>Need some more sun in your backyard? We can handle any job.</p>
        </div>
        <div id="removal">
            <div class="serviceThumbnail">
                <img src="images/tree_removal_sm.jpg">
            </div>
            <h1>Tree Removal</h1>
            <p>No matter how big or small, in an open field or growing between the garage and house, we can handle any
                tree you need removed.</p>
        </div>
        <div id="estimate">
            <div class="serviceThumbnail">
                <img src="images/estimate.jpg">
            </div>
            <h1>Free Estimates</h1>
            <p>Done hesitate, give us a call and we'll make it out to your house as soon as we can for a free
                estimate.</p>
        </div>
    </div>
</div>

<!--About Section -->
<div class="aboutContainer" id="aboutContainer">
    <div class="aboutGrid">
        <div id="aboutTextContainer">
            <h1 id="aboutTitle" class="sectionTitle">About</h1>
            <h1><span class="aboutSpan" class="aboutSpan">-</span> Serving Central WI Since 2017 <span
                        class="aboutSpan">-</span></h1>
            <hr>
            <p>Tree to Tree, Care LLC is owned and operated by Joshua Desotel. Offering a wide range of services to his
                own local community. If you have any questions dont hesitate to give us a call.</p>
            <div id="listGrid">
                <div class="aboutList">
                    <ul class="check-list">
                        <li><i class="fa fa-check" aria-hidden="true"></i>Local</li>
                        <li><i class="fa fa-check" aria-hidden="true"></i>Personable</li>
                        <li><i class="fa fa-check" aria-hidden="true"></i>Reasonably Priced</li>
                    </ul>
                </div>
                <div class="aboutList">
                    <ul class="check-list">
                        <li><i class="fa fa-check" aria-hidden="true"></i>Fast</li>
                        <li><i class="fa fa-check" aria-hidden="true"></i>7 days a week</li>
                        <li><i class="fa fa-check" aria-hidden="true"></i>Insured</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="aboutImg"></div>
    </div>
</div>

<!-- Image Gallery -->
<div class="galleryContainer" id="galleryContainer">
    <h1 id="galleryTitle" class="sectionTitle">Gallery</h1>
    <div class="galleryGrid">
        <div class="thumbnail">
            <img id="Gallery_1" src="images/gallery/Gallery_1.jpeg" onclick="fullScreen(id)" class="serviceImg">
        </div>
        <div class="thumbnail">
            <img id="Gallery_2" src="images/gallery/Gallery_2.jpeg" onclick="fullScreen(id)" class="serviceImg">
        </div>
        <div class="thumbnail">
            <img id="Gallery_3" src="images/gallery/Gallery_3.jpeg" onclick="fullScreen(id)" class="serviceImg">
        </div>
        <div class="thumbnail">
            <img id="Gallery_4" src="images/gallery/Gallery_4.jpeg" onclick="fullScreen(id)" class="serviceImg">
        </div>
        <div class="thumbnail">
            <img id="Gallery_5" src="images/gallery/Gallery_5.jpeg" onclick="fullScreen(id)" class="serviceImg">
        </div>
        <div class="thumbnail">
            <img id="Gallery_6" src="images/gallery/Gallery_6.jpeg" onclick="fullScreen(id)" class="serviceImg">
        </div>
        <div class="thumbnail">
            <img id="Gallery_7" src="images/gallery/Gallery_7.jpeg" onclick="fullScreen(id)" class="serviceImg">
        </div>
        <div class="thumbnail">
            <img id="Gallery_8" src="images/gallery/Gallery_8.jpeg" onclick="fullScreen(id)"
                 class="serviceImg portrait">
        </div>
        <div class="thumbnail" id="Gallery_9">
            <img src="images/gallery/Gallery_9.jpeg" onclick="fullScreen(id)" class="serviceImg">
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <span id="close" onclick="pleaseClose()">&times;</span>
    <img src="images/placeholder.png" class="modal-content" id="modalImage" alt="">
    <div id="caption"></div>
</div>

<!-- Contact -->
<div class="contactContainer" id="contactContainer">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="contactForm">
        <h1 id="contactTitle" class="sectionTitle">Message</h1>
        <label class="input" for="fname">First Name</label>
        <input class="input <?php if (!empty($first_name_error)) echo 'inputError' ?>" type="text" id="fname"
               name="firstName"
               value="<?php if (!empty($first_name)) echo $first_name; ?>">
        <span class="inputErrorMessage"><?php if (!empty($first_name_error)) echo $first_name_error; ?></span>
        <label class="input" for="lname">Last Name</label>
        <input class="input <?php if (!empty($last_name_error)) echo 'inputError' ?>" type="text" id="lname"
               name="lastName"
               value="<?php if (!empty($last_name)) echo $last_name; ?>">
        <span class="inputErrorMessage"><?php if (!empty($last_name_error)) echo $last_name_error; ?></span>
        <label class="input" for="email">Email</label>
        <input class="input <?php if (!empty($email_error)) echo 'inputError' ?>" type="text" id="email"
               name="email"
               value="<?php if (!empty($email)) echo $email; ?>">
        <span class="inputErrorMessage"><?php if (!empty($email_error)) echo $email_error; ?></span>
        <label class="input" for="phone">Phone (optional)</label>
        <input class="input <?php if (!empty($phone_error)) echo 'inputError' ?>" type="text" id="phonefname"
               name="phone" value="<?php if (!empty($phone)) echo $phone; ?>">
        <span class="inputErrorMessage"><?php if (!empty($phone_error)) echo $phone_error; ?></span>
        <label class="input" for="subject">Message</label>
        <textarea class="input <?php if (!empty($message_error)) echo 'inputError' ?>" id="message"
                  name="message"><?php if (!empty($message)) echo $message; ?></textarea>
        <span class="inputErrorMessage"><?php if (!empty($message_error)) echo $message_error; ?></span>
        <div class="buttonGrid">
            <input type="submit" value="Send" class="button" id="sendMessageButton" name="sendMessageButton">
            <input type="submit" value="Clear" class="button" id="cancelButton" name="cancelMessageButton">
        </div>
    </form>
</div>

<!-- Footer Contact Info -->
<div id="contactInfoBar">
    <div class="contactBox" id="box1">
        <h1 class="hide">Hours</h1>
        <hr class="hide">
        <h2>7 Days A Week</h2>
        <h2>7AM - 7PM</h2>
    </div>
    <div class="contactBox" id="box2">
        <h1>Contact</h1>
        <hr>
        <a id="contactPhone" href="#"><h2 class="contactMethod">111-111-1111</h2></a>
        <a id="contactEmail" href="#"><h2 class="contactMethod">example@gmail.com</h2></a>
    </div>
    <div class="contactBox" id="box3">
        <h1 class="hide">Social</h1>
        <hr class="hide">
        <a class="socialIcon" href="https://www.facebook.com/TreetoTreeLLC"><i class="fa fa-facebook-square fa-3x"
                                                                               aria-hidden="true"></i></a>
        <a class="socialIcon" href="#"><i class="fa fa-instagram fa-3x" aria-hidden="true"></i></a>
    </div>
</div>

<div id="footer">
    <h3>© 2018, Tree To Tree Care LLC. All Rights Reserved.</h3>
</div>

</body>
<!-- JQUERY AND JAVASCRIPT -->
<script src="https://use.fontawesome.com/1edc521bf1.js"></script>
<script src="javascript/javascript.js"></script>
<script src="javascript/jQuery.js"></script>

</html>