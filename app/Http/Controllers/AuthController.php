<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Show signup form
    public function signupForm()
    {
        return view('signup');
    }

    // Handle signup submission
    public function signup(Request $request)
    {
        $request->validate([
            'first' => 'required|max:50',
            'last' => 'required|max:50',
            'username' => 'required|max:30|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|size:8|regex:/^(?=.*[\d\W]).{8}$/',
            'confirm_password' => 'required|same:password',
        ]);

        DB::table('users')->insert([
            'first' => $request->first,
            'last' => $request->last,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('home')->with('success', 'Account created! Please login.');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('users')
            ->where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Account not found.');
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->route('home')->with('error', 'Incorrect password.');
        }

        // Store session
        Session::put('user_id', $user->id);
        Session::put('username', $user->username);
        Session::put('first', $user->first);
        Session::put('role', $user->role);

        DB::table('login_logs')->insert([
            'username' => $user->username,
            'login_time' => now()
        ]);

        return redirect()->route('dashboard');
    }

    // Logout
    public function logout()
    {
        Session::flush();
        return redirect()->route('home');
    }

    // Dashboard
    public function dashboard()
    {
        $user = Session::get('username');

        $posts = DB::table('posts')->orderBy('id', 'desc')->get();
        $notif_count = DB::table('notifications')
            ->where('username', $user)
            ->where('is_read', 0)
            ->count();

        $notes = DB::table('notifications')
            ->where('username', $user)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        $courses = DB::table('user_courses')
            ->where('username', $user)
            ->get();

        return view('dashboard', compact('posts','notif_count','notes','courses'));
    }

    // Handle posts, likes, comments, notifications
    public function handlePost(Request $request)
    {
        $user = Session::get('username');

        // ADD POST
        if ($request->has('post')) {
            DB::table('posts')->insert([
                'username' => $user,
                'content' => $request->content,
                'created_at' => now()
            ]);
        }

        // LIKE / UNLIKE
        if ($request->has('like')) {
            $post_id = $request->post_id;

            $exists = DB::table('reactions')
                ->where('post_id', $post_id)
                ->where('username', $user)
                ->exists();

            if (!$exists) {
                DB::table('reactions')->insert([
                    'post_id' => $post_id,
                    'username' => $user
                ]);

                $owner = DB::table('posts')->where('id', $post_id)->value('username');

                if ($owner != $user) {
                    DB::table('notifications')->insert([
                        'username' => $owner,
                        'type' => 'like',
                        'post_id' => $post_id,
                        'sender' => $user
                    ]);
                }
            } else {
                DB::table('reactions')
                    ->where('post_id', $post_id)
                    ->where('username', $user)
                    ->delete();
            }
        }

        // COMMENT
        if ($request->has('comment_btn')) {
            $post_id = $request->post_id;

            DB::table('comments')->insert([
                'post_id' => $post_id,
                'username' => $user,
                'comment' => $request->comment
            ]);

            $owner = DB::table('posts')->where('id', $post_id)->value('username');

            if ($owner != $user) {
                DB::table('notifications')->insert([
                    'username' => $owner,
                    'type' => 'comment',
                    'post_id' => $post_id,
                    'sender' => $user
                ]);
            }
        }

        // MARK NOTIFICATIONS AS READ
        if ($request->has('read_notifications')) {
            DB::table('notifications')
                ->where('username', $user)
                ->update(['is_read' => 1]);
        }

        return redirect()->route('dashboard');
    }

    public function course()
{
    $user = session('username'); // get current user
    $courses = DB::table('user_courses')->where('username', $user)->get();
    return view('course', compact('courses'));
}

//html
public function htmlCourse()
{
    $user = session('username');

    $progress = DB::table('user_progress')
        ->where('username', $user)
        ->where('course_name', 'HTML')
        ->first();

    if(!$progress){
        DB::table('user_progress')->insert([
            'username' => $user,
            'course_name' => 'HTML',
            'current_lesson' => 1
        ]);

        $current_lesson = 1;
    } else {
        $current_lesson = $progress->current_lesson;
    }

    return view('html_course', [
    'current_lesson' => $current_lesson,
    'showQuiz' => false
]);
}

public function completeLesson(Request $request)
{
    $user = session('username');

    DB::table('user_progress')
        ->where('username', $user)
        ->where('course_name', 'HTML')
        ->increment('current_lesson');

    return redirect()->route('html.course');
}

//html
public function htmlQuiz()
{
    return view('html_course', ['showQuiz' => true]);
}

public function submitQuiz(Request $request)
{
    $score = 0;

    if($request->q1 == 'a') $score++;
    if($request->q2 == 'a') $score++;
    if($request->q3 == 'b') $score++;
    if($request->q4 == 'b') $score++;
    if($request->q5 == 'a') $score++;

    if($score >= 4){ // 75% (4/5)
        DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name','HTML')
            ->increment('current_lesson');

        return redirect()->route('html.course')->with('success','Passed!');
    } else {
        return redirect()->route('html.course')->with('error','Failed. Try again.');
    }
}
}
