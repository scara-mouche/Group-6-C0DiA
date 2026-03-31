<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HTML Course</title>
<link rel="stylesheet" href="<?php echo e(asset('html.css')); ?>">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>C0DiA</h2>
    <a href="<?php echo e(route('dashboard')); ?>">🏠 Home</a>
    <a href="<?php echo e(route('course')); ?>">📚 Courses</a>
    <a href="#">🏆 Certificates</a>
    <a href="<?php echo e(route('logout')); ?>">🚪 Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<div class="lesson-box">

<?php if(!$showQuiz): ?>

    <h2>Lesson 1: Introduction to Web Development and HTML Basics</h2>

    <p><b>HTML - </b> stands for HyperText Markup Language. It provides the structure and content of the webpage (e.g., headings, paragraphs, images, forms) <br>
    <b>CSS - </b> stands for Cascading Style Sheets. It handles the design, layout, and visual styling of the webpage (e.g., colors, fonts spacing). <br>
    <b>JavaScript - </b> Adds interactivity and dynamic behavior to the webpage (e.g., animations, form validation, fetching data dynamically).
    </p>

    <h3>Basic Structure:</h3>
<pre>
&lt;html&gt;
&lt;head&gt;
&lt;title&gt;My Page&lt;/title&gt;
&lt;link rel="stylesheet" href="style.css"&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;h1&gt; Hello World!&lt;/h1&gt;
&lt;/body&gt;
&lt;/html&gt;
</pre>

<h3>Explanation of Each Line:</h3>

<pre>
&lt;html&gt;
This is the root element of an HTML document.
All content of the webpage must be placed inside this tag.

&lt;head&gt;
This section contains metadata or information about the webpage.
Content inside this section is not displayed directly on the page.

&lt;title&gt;My Page&lt;/title&gt;
This defines the title of the webpage.
It appears on the browser tab.

&lt;link rel="stylesheet" href="style.css"&gt;
This links an external CSS file to the HTML document.
The "rel" attribute specifies the relationship as a stylesheet.
The "href" attribute specifies the location of the CSS file.

&lt;/head&gt;
This closes the head section.

&lt;body&gt;
This section contains all the visible content of the webpage.

&lt;h1&gt;Hello World!&lt;/h1&gt;
This is a heading element.
The &lt;h1&gt; tag represents the largest heading.

&lt;/body&gt;
This closes the body section.

&lt;/html&gt;
This closes the HTML document.
</pre>

<h3>Important Notes:</h3>

<ul>
<li>HTML is used to define the structure of a webpage.</li>
<li>CSS is used to style and design the webpage.</li>
<li>JavaScript is used to add functionality and interactivity.</li>
<li>Most HTML elements have both opening and closing tags.</li>
<li>Example: &lt;h1&gt; ... &lt;/h1&gt;</li>
</ul>

<h2>Lesson 1.1: Types of HTML Elements</h2>

<p>HTML elements define the structure and content of a webpage. Each element consists of an opening tag, content, and a closing tag. Common types of elements include headings, paragraphs, images, links, and comments.</p>

<h3>1. Headings</h3>
<p>Headings are used to create titles and subtitles. HTML provides six levels of headings: <code>&lt;h1&gt;</code> to <code>&lt;h6&gt;</code>. <code>&lt;h1&gt;</code> represents the most important heading, and <code>&lt;h6&gt;</code> the least.</p>

<pre>
&lt;h1&gt;Main Title&lt;/h1&gt;
&lt;h2&gt;Sub Title&lt;/h2&gt;
&lt;h3&gt;Section Heading&lt;/h3&gt;
</pre>

<h3>2. Paragraphs</h3>
<p>Paragraphs are defined with the <code>&lt;p&gt;</code> tag. They group sentences together and automatically add spacing above and below the text.</p>

<pre>
&lt;p&gt;This is a paragraph of text. It can contain multiple sentences.&lt;/p&gt;
&lt;p&gt;Another paragraph for clarity.&lt;/p&gt;
</pre>

<h3>3. Images</h3>
<p>Images are displayed using the <code>&lt;img&gt;</code> tag. This tag is self-closing and requires the <code>src</code> attribute to specify the image file and the <code>alt</code> attribute for alternative text.</p>

<pre>
&lt;img src="logo.png" alt="Website Logo"&gt;
&lt;img src="photo.jpg" alt="A beautiful scenery"&gt;
</pre>

<h3>4. Links</h3>
<p>Links are created using the <code>&lt;a&gt;</code> tag. The <code>href</code> attribute specifies the URL. Clicking the link navigates the user to the destination.</p>

<pre>
&lt;a href="https://www.example.com"&gt;Visit Example&lt;/a&gt;
&lt;a href="page2.html"&gt;Go to Page 2&lt;/a&gt;
</pre>

<h3>5. Comments</h3>
<p>Comments are used to leave notes inside HTML code. They are not displayed in the browser.</p>

<pre>
&lt;!-- This is a comment. It will not appear on the webpage. --&gt;
&lt;!-- Remember to update the image paths --&gt;
</pre>



    <form method="POST" action="<?php echo e(route('html.quiz')); ?>">
        <?php echo csrf_field(); ?>
        <button>Quiz Now</button>
    </form>

<?php else: ?>

    <h2>Lesson 1 Quiz</h2>

    <form method="POST" action="<?php echo e(route('html.submit')); ?>">
        <?php echo csrf_field(); ?>

        <p>1. What does HTML stand for?</p>
        <input type="radio" name="q1" value="a"> Hyper Text Markup Language <br>
        <input type="radio" name="q1" value="b"> Home Text Markup Language <br>

        <p>2. Which tag is for paragraph?</p>
        <input type="radio" name="q2" value="a"> &lt;p&gt; <br>
        <input type="radio" name="q2" value="b"> &lt;h1&gt; <br>

        <p>3. HTML is used for?</p>
        <input type="radio" name="q3" value="a"> Styling <br>
        <input type="radio" name="q3" value="b"> Structure <br>

        <p>4. True or False: HTML is a programming language</p>
        <input type="radio" name="q4" value="a"> True <br>
        <input type="radio" name="q4" value="b"> False <br>

        <p>5. Which tag creates title?</p>
        <input type="radio" name="q5" value="a"> &lt;title&gt; <br>
        <input type="radio" name="q5" value="b"> &lt;body&gt; <br>

        <br>
        <button type="submit">Submit Quiz</button>
    </form>

<?php endif; ?>

</div>
</div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\Codia\laravel_app\resources\views/html_course.blade.php ENDPATH**/ ?>