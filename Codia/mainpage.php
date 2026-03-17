<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C0DiA Main Page</title>
    <link rel="stylesheet" href="mainpage.css">
</head>
<body>
    
    <header>
        <h1>C0DiA</h1>
        <nav>
            <a href="mainpage.php">Home</a>
            <a href="courses.php">Courses</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
        </nav>
        <div class="search">
            <input type="text" placeholder="Search courses...">
            <button>Search</button>
        </div>
    </header>

    <section class="welcome">
        <div class="welcome-text">
            <h1>Welcome to <span>C0DiA</span>👋</h1>
                <p class="desc"> 
                    Learn. Build. Connect. 
                    At C0DiA, your coding journey starts today—unlock your potential and 
                    become the developer you're meant to be.
                </p>
                <div class="buttons">
                    <button class="join">Join Now</button>
                    <button class="catalog">View Catalog</button>
                </div>
        </div>
        <div class="student-image">
            <img src="https://static.vecteezy.com/system/resources/thumbnails/045/782/211/small_2x/young-developer-coding-at-workstation-photo.jpg" alt="Student Studying">
        </div>

    </section>

    <main>
        <section class="featured-courses">
            <h2>Featured Courses</h2>
            <p>Explore our most popular tracks and start your learning journey with high-impact curriculum.</p>
            <div class="course-list">
                <div class="course-item">
                    <h3>C Language</h3>
                    <p>Learn C programming and understand low-level programming concepts.</p>
                    <a href="c_course.php">Enroll Now</a>
                </div>
                <div class="course-item">
                    <h3>C++ Programming</h3>
                    <p>Master C++ programming and build high-performance applications.</p>
                    <a href="cpp_course.php">Enroll Now</a>
                </div>
                <div class="course-item">
                    <h3>HTML, CSS & JavaScript</h3>
                    <p>Learn the fundamentals of web development and create stunning websites.</p>
                    <a href="html_course.php">Enroll Now</a>
                </div>
                <div class="course-item">
                    <h3>Java Programming</h3>
                    <p>Master Java programming and build powerful applications.</p>
                    <a href="java_course.php">Enroll Now</a>
                </div>
                <div class="course-item">
                    <h3>Python Programming</h3>
                    <p>Explore Python programming and dive into data science and machine learning.</p>
                    <a href="python_course.php">Enroll Now</a>
                </div>
            </div>
        </section>

        <section class="community">
            <h2>Join Our Community</h2>
            <p>Connect with fellow learners, share your projects, and get feedback from experienced developers.</p>
            <a href="community.php">Join Now</a>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-col">
                <h3>C0DiA</h3>
                <p>Making quality education accessible to everyone.</p>
            </div>

            <div class="footer-col">
                <h4>Explore</h4>
                <p>Course Catalog</p>
                <p>Masterclasses</p>
                <p>Free Resources</p>
            </div>

            <div class="footer-col">
                <h4>Company</h4>
                <p>About Us</p>
                <p>Careers</p>
                <p>Contact</p>
            </div>

            <div class="footer-col">
                <h4>Support</h4>
                <p>Help Center</p>
                <p>Privacy Policy</p>
                <p>Terms of Service</p>
            </div>
        </div>
    </footer>

</body>
</html>
