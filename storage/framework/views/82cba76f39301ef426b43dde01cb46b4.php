<?php
use Illuminate\Support\Facades\DB;

$user = session('username'); // get logged-in username

// get courses if needed (optional, depends on your design)
$courses = DB::table('user_courses')->where('username', $user)->get();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>C0DiA Courses</title>
<link rel="stylesheet" href="<?php echo e(asset('course.css')); ?>">

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>C0DiA</h2>
   <a href="<?php echo e(route('dashboard')); ?>">🏠 Home</a>
    <a href="#">👤 Profile</a> <!-- If you add a profile route, update this -->
    <a href="<?php echo e(route('course')); ?>">📚 Courses</a>
    <a href="#">🏆 Certificates</a> <!-- Optional: add route later -->
    <a href="<?php echo e(route('logout')); ?>">🚪 Logout</a>
</div>

<!-- MAIN -->
<div class="main">

    <div class="header">📚 Courses</div>

    <div class="container">

        <div class="course-grid">

            <div class="course-card">
                <h3>C Programming</h3>
                <p>Learn the fundamentals of C and low-level programming.</p>
                <a href="c_course.php" class="enroll-btn">Enroll Now</a>
            </div>

            <div class="course-card">
                <h3>C++ Programming</h3>
                <p>Master object-oriented programming with C++.</p>
                <a href="cpp_course.php" class="enroll-btn">Enroll Now</a>
            </div>

            <div class="course-card">
                <h3>Java Programming</h3>
                <p>Build powerful applications using Java.</p>
                <a href="java_course.php" class="enroll-btn">Enroll Now</a>
            </div>

            <div class="course-card">
                <h3>Python Programming</h3>
                <p>Explore Python for web, data science, and more.</p>
                <a href="python_course.php" class="enroll-btn">Enroll Now</a>
            </div>

            <div class="course-card">
                <h3>Web Development</h3>
                <p>Learn HTML, CSS, and JavaScript to build websites.</p>
                <a href="<?php echo e(route('html.course')); ?>" class="enroll-btn" class="enroll-btn">Enroll Now</a>
            </div>

        </div>

    </div>

</div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\Codia\laravel_app\resources\views/course.blade.php ENDPATH**/ ?>