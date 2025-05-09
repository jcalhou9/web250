<?php
//handles valid pages and default to home if not
$content = isset($_GET['content']) ? $_GET['content'] : 'home';
$pages = ['home', 'introduction', 'contract', 'introductionForm'];
if(!in_array($content, $pages)) {
    $content = 'home';
}
?>

<!DOCTYPE html>

<!-- Jeremy Calhoun -->
<!-- WEB250-N850 Spring 25 -->

<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Jeremy Calhoun's Jubilant Cheetah ~ WEB250 ~ <?= ucfirst($content) ?> </title>
		<link rel="stylesheet" type="text/css" href="./styles/default.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
		<link rel="icon" type="image/x-icon" href="./images/favicon.png">
		<script src="https://lint.page/kit/880bd5.js" crossorigin="anonymous"></script>
        <!-- script only if introductionForm -->
        <?php if ($content === 'introductionForm'): ?>
            <script src="scripts/introductionForm.js" defer></script>
        <?php endif; ?>
	</head>
	<body>
		<aside>
            <nav>
                <a href="index.php?content=home"><img src="./images/clover2.png" alt="Three leaf clover"></a>
                <h3 class="sidebar-headings">PHP pages</h3>
                <ul class="page-links">
                    <!-- sets content to selected page -->
                    <li><a href="index.php?content=home">Home</a></li>
                    <li><a href="index.php?content=contract">Contract</a></li>
                    <li><a href="index.php?content=introduction">Introduction</a></li>
                    <li><a href="index.php?content=introductionForm">Introduction Form</a></li>
                    <li><a href="../fizzbuzz.html">Fuzz Buzz</a></li>
                    <li><a href="../">Static Website</a></li>
                </ul>
                <h3 class="sidebar-headings">External pages</h3>
                <ul class="page-links">
                    <li><a href="../multipage_sites/superduper_static/">Superduper Static</a></li>
                    <li><a href="../multipage_sites/superduper_php/">Superduper PHP</a></li>
                    <li><a href="../joyofphp/src/">Joy of PHP</a></li>
                    <li><a href="../joyofphp/src/samsusedcars.html">Sam's Used Cars</a></li>
                    <li><a href="../carapp">Jeremy's Used Cars</a></li>
                    <li><a href="../carapp2">Jubilant Cheetah's Used Cars</a></li>
                    <li><a href="project">Worklog Manager</a></li>
                    
                </ul>
                <h3 class="sidebar-headings">External links</h3>
                <ul class="page-links">
                    <li><a href="https://github.com/jcalhou9">GitHub</a></li>
                    <li><a href="https://jcalhou9.github.io/">GitHub.io</a></li>
                    <li><a href="https://jcalhou9.github.io/web115/">WEB115</a></li>
                    <li><a href="https://jcalhou9.github.io/web215/">WEB215</a></li>
                    <li><a href="https://www.freecodecamp.org/jcalhou9">freeCodeCamp</a></li>
                    <li><a href="https://www.codecademy.com/profiles/jcalhou9">Codecademy</a></li>
                    <li><a href="https://jsfiddle.net/u/jcalhou9/fiddles/">JSFiddle</a></li>
                    <li><a href="https://www.linkedin.com/in/jeremy-calhoun-3aab016a/">Linkedin</a></li>
                </ul>
            </nav>
		</aside>
		<header>
			<h1>Jeremy Calhoun's Jubilant Cheetah ~ WEB250 ~ PHP</h1>
		</header>
		<main>
			<?php include "components/" . $content . '.php'; ?>
		</main>
		<footer>
			<p><i>Created by Jeremy Calhoun, 
                <a href="https://www.freecodecamp.org/certification/jcalhou9/responsive-web-design">RWD</a>
                and
                <a href="https://www.freecodecamp.org/certification/jcalhou9/javascript-algorithms-and-data-structures-v8">JADS</a>
                Certified</i></p>
		</footer>
	</body>
</html>