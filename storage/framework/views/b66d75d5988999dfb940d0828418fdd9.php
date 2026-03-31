

<?php
use Illuminate\Support\Facades\DB;

$user = session('username');

// NOTIFICATIONS COUNT
$notif_count = DB::table('notifications')
    ->where('username', $user)
    ->where('is_read', 0)
    ->count();

// GET NOTIFICATIONS
$notes = DB::table('notifications')
    ->where('username', $user)
    ->orderBy('id', 'desc')
    ->limit(5)
    ->get();

// GET POSTS
$posts = DB::table('posts')->orderBy('id','desc')->get();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>C0DiA Dashboard</title>
<link rel="stylesheet" href="<?php echo e(asset('dashboard.css')); ?>">
</head>
<body>

<!-- Notification bell -->
<div class="notif-bell" onclick="toggleNotif()">
    🔔
    <?php if($notif_count > 0): ?>
        <span class="notif-count"><?php echo e($notif_count); ?></span>
    <?php endif; ?>
</div>

<div id="notif-list" style="display:none; position:absolute; top:50px; right:20px; background:#222; color:#fff; padding:10px; border-radius:10px;">
    <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p>
            <b><?php echo e($n->sender); ?></b>
            <?php echo e($n->type == 'like' ? 'liked' : 'commented on'); ?> your post.
        </p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!-- MARK READ -->
    <form method="POST" action="<?php echo e(route('dashboard')); ?>">
        <?php echo csrf_field(); ?>
        <button name="read_notifications">Mark all as read</button>
    </form>
</div>

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

    <div class="feed">
        <h2>Welcome back 👋 <?php echo e(session('username')); ?></h2>

        <!-- POST FORM -->
        <form method="POST" action="<?php echo e(route('dashboard')); ?>">
            <?php echo csrf_field(); ?>
            <div class="post-box">
                <input type="text" name="content" placeholder="What's on your code?" required>
                <button type="submit" name="post">Post</button>
            </div>
        </form>

        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php
        $likeCount = DB::table('reactions')->where('post_id', $row->id)->count();

        $comments = DB::table('comments')
            ->where('post_id', $row->id)
            ->orderBy('id','asc')
            ->get();
        ?>

        <div class="post">
            <div class="post-header">
                <div class="avatar"></div>
                <div>
                    <h4><?php echo e($row->username); ?></h4>
                    <small><?php echo e($row->created_at ?? 'just now'); ?></small>
                </div>
            </div>

            <p><?php echo e($row->content); ?></p>

            <p><?php echo e($likeCount); ?> Likes</p>

            <div class="post-actions">

                <!-- LIKE -->
                <form method="POST" action="<?php echo e(route('dashboard')); ?>" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="post_id" value="<?php echo e($row->id); ?>">
                    <button name="like">👍 Like</button>
                </form>

                <!-- COMMENT -->
                <form method="POST" action="<?php echo e(route('dashboard')); ?>" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="post_id" value="<?php echo e($row->id); ?>">
                    <input type="text" name="comment" placeholder="Comment..." required>
                    <button name="comment_btn">💬</button>
                </form>

                <!-- DELETE -->
                <?php if($row->username == session('username')): ?>
                    <button onclick="openModal('post', <?php echo e($row->id); ?>)">🗑 Delete</button>
                <?php endif; ?>

            </div>

            <!-- COMMENTS -->
            <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="margin-left:20px; font-size:14px;">
                    <b><?php echo e($c->username); ?>:</b> <?php echo e($c->comment); ?>


                    <?php if($c->username == session('username')): ?>
                        <button style="background:red;color:white;border:none;border-radius:5px;margin-left:5px;"
                            onclick="openModal('comment', <?php echo e($c->id); ?>)">Delete</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- RIGHT BAR -->
    <div class="card">
    <h3>Your Courses</h3>

    <?php
    $courses = DB::table('user_courses')->where('username', $user)->get();
    ?>

    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $width = $course->progress;
        $status = $course->completed ? "Completed" : "$width%";
        ?>

        <p><?php echo e($course->course_name); ?> (<?php echo e($status); ?>)</p>
        <div class="progress"><div style="width:<?php echo e($width); ?>%"></div></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

</div>

<script>
function toggleNotif(){
    var list = document.getElementById('notif-list');
    list.style.display = (list.style.display == 'none') ? 'block' : 'none';
}

function openModal(type, id){
    alert("Delete functionality not yet connected in Laravel 😅");
}
</script>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\Codia\laravel_app\resources\views/dashboard.blade.php ENDPATH**/ ?>