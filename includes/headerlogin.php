<section class="headerlogin">
    <nav>
        <a href="dashboard.php"><img src="../images/logo.png" alt="Logo"></a> <!-- Changed to link to the dashboard -->
        <div class="nav-links">
            <link rel="stylesheet" href="../css/stylelogin.css">
            <ul>
                <?php if (isset($_SESSION['student_id'])): ?> <!-- Check if student is logged in -->
                    <li><a href="dashboard.php">DASHBOARD</a></li>
                    <li><a href="profile.php">PROFILE</a></li> <!-- Optional Profile link -->
                    <li><a href="applications.php">MY APPLICATIONS</a></li> <!-- Optional Applications link -->
                    
                <?php else: ?>
                    <li><a href="index.php">HOME</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="course.php">COURSE</a></li>
                <li><a href="blog.php">BLOG</a></li>
                <li><a href="contact.php">CONTACT</a></li>
                    
                    <li><a href="signup.php">REGISTER</a></li> <!-- Optional Registration link -->
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</section>
