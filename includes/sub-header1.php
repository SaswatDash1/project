<section class="sub-header">
        <nav>
            <a href="dashboard.php"><img src="../images/logo.png" alt="logo"></a>
            <div class="nav-links">
                
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
                    <li><a href="login.php">LOGIN</a></li>
                    <li><a href="signup.php">REGISTER</a></li> <!-- Optional Registration link -->
                <?php endif; ?>
                    
                </ul>
            </div>
            
        </nav>
        
    </section>