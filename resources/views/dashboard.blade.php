{{-- resources/views/dashboard.blade.php --}}

@php
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
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>C0DiA Dashboard</title>
<link rel="stylesheet" href="{{ asset('dashboard.css') }}">
</head>
<body>

<!-- Notification bell -->
<div class="notif-bell" onclick="toggleNotif()">
    🔔
    @if($notif_count > 0)
        <span class="notif-count">{{ $notif_count }}</span>
    @endif
</div>

<div id="notif-list" style="display:none; position:absolute; top:50px; right:20px; background:#222; color:#fff; padding:10px; border-radius:10px;">
    @foreach($notes as $n)
        <p>
            <b>{{ $n->sender }}</b>
            {{ $n->type == 'like' ? 'liked' : 'commented on' }} your post.
        </p>
    @endforeach

    <!-- MARK READ -->
    <form method="POST" action="{{ route('dashboard') }}">
        @csrf
        <button name="read_notifications">Mark all as read</button>
    </form>
</div>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>C0DiA</h2>
   <a href="{{ route('dashboard') }}">🏠 Home</a>
    <a href="#">👤 Profile</a> <!-- If you add a profile route, update this -->
    <a href="{{ route('course') }}">📚 Courses</a>
    <a href="#">🏆 Certificates</a> <!-- Optional: add route later -->
    <a href="{{ route('logout') }}">🚪 Logout</a>
</div>

<!-- MAIN -->
<div class="main">

    <div class="feed">
        <h2>Welcome back 👋 {{ session('username') }}</h2>

        <!-- POST FORM -->
        <form method="POST" action="{{ route('dashboard') }}">
            @csrf
            <div class="post-box">
                <input type="text" name="content" placeholder="What's on your code?" required>
                <button type="submit" name="post">Post</button>
            </div>
        </form>

        @foreach($posts as $row)

        @php
        $likeCount = DB::table('reactions')->where('post_id', $row->id)->count();

        $comments = DB::table('comments')
            ->where('post_id', $row->id)
            ->orderBy('id','asc')
            ->get();
        @endphp

        <div class="post">
            <div class="post-header">
                <div class="avatar"></div>
                <div>
                    <h4>{{ $row->username }}</h4>
                    <small>{{ $row->created_at ?? 'just now' }}</small>
                </div>
            </div>

            <p>{{ $row->content }}</p>

            <p>{{ $likeCount }} Likes</p>

            <div class="post-actions">

                <!-- LIKE -->
                <form method="POST" action="{{ route('dashboard') }}" style="display:inline;">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $row->id }}">
                    <button name="like">👍 Like</button>
                </form>

                <!-- COMMENT -->
                <form method="POST" action="{{ route('dashboard') }}" style="display:inline;">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $row->id }}">
                    <input type="text" name="comment" placeholder="Comment..." required>
                    <button name="comment_btn">💬</button>
                </form>

                <!-- DELETE -->
                @if($row->username == session('username'))
                    <button onclick="openModal('post', {{ $row->id }})">🗑 Delete</button>
                @endif

            </div>

            <!-- COMMENTS -->
            @foreach($comments as $c)
                <div style="margin-left:20px; font-size:14px;">
                    <b>{{ $c->username }}:</b> {{ $c->comment }}

                    @if($c->username == session('username'))
                        <button style="background:red;color:white;border:none;border-radius:5px;margin-left:5px;"
                            onclick="openModal('comment', {{ $c->id }})">Delete</button>
                    @endif
                </div>
            @endforeach

        </div>

        @endforeach
    </div>

    <!-- RIGHT BAR -->
    <div class="card">
    <h3>Your Courses</h3>

    @php
    $courses = DB::table('user_courses')->where('username', $user)->get();
    @endphp

    @foreach($courses as $course)
        @php
        $width = $course->progress;
        $status = $course->completed ? "Completed" : "$width%";
        @endphp

        <p>{{ $course->course_name }} ({{ $status }})</p>
        <div class="progress"><div style="width:{{ $width }}%"></div></div>
    @endforeach

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
