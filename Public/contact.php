<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University of Oxford</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">

</head>
<body>


<?php
  include '../includes/sub-header.php';
  ?>


    <!-------Contact us -------->
    <section class="location">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2469.6872164482347!2d-1.2570928233649628!3d51.75704287187111!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4876c6a9ef8c485b%3A0xd2ff1883a001afed!2sUniversity%20of%20Oxford!5e0!3m2!1sen!2suk!4v1742903188181!5m2!1sen!2suk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
    <section class="contact-us">
        <div class="row">
            <div class="contact-col">
                <div>
                    <i class="fa fa-home"></i>
                    <span>
                        <h5>Wellington Square,Oxford</h5>
                        <p>OX1 2JD</p>
                    </span>
                </div>
            
            
                <div>
                    <i class="fa fa-phone"></i>
                <span>
                    <h5>+44 7587903292</h5>
                    <p>Monday to Friday, 10am-5pm</p>
                </span>
                </div>
            
            
                <div>
                    <i class="fa fa-envelope-o"></i>
                <span>
                    <h5>Postal address</h5>
                    <p>University of Oxford<br>University Offices<br>Wellington Square
                        <br>Oxford<br>OX1 2JD
                        <br>United Kingdom

                    </p>
                </span>
                </div>
                <div>
                    <i class="fa fa-envelope-o"></i>
                <span>
                    <h5>Email address</h5>
                    <p>oxford@uni.ox.ac.uk
                    </p>
                </span>
                </div>
            </div>
            <div class="contact-col">
                <form action="form-handler.php" method="post">
                    <input type="text" name="name" placeholder="Enter your name" required>
                    <input type="Email" name="email" placeholder="Enter email address" required>
                    <input type="text" name="subject" placeholder="Enter your subject" required>
                    <textarea  rows="8" name="message" placeholder="Message"></textarea>
                    <button type="submit" class="hero-btn red-btn">Send Message</button>
                </form>
            </div>
            </div>
        
    </section>
    
 <!-- Footer -->
 <?php
  include '../includes/footer.php';
  ?>
    

    
</body>
</html>