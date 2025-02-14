<?php
$content = isset($_GET['content']) ? $_GET['content'] : 'home';
$pages = ['home', 'introduction', 'contract'];
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
		<title>Jeremy Calhoun's Jubilant Cheetah ~ WEB250 ~ <?php echo ucfirst($content) ?> </title>
		<link rel="stylesheet" type="text/css" href="./styles/default.css">
		<link rel="icon" type="image/x-icon" href="./images/favicon.png">
		<script src="https://lint.page/kit/880bd5.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<aside>
            <nav>
                <a href="index.html"><img src="./images/clover2.png" alt="Three leaf clover"></a>
                <ul class="page-links">
                    <h3 class="sidebar-headings">Pages</h3>
                    <li><a href="index.php?content=home">Home</a></li>
                    <li><a href="index.php?content=contract">Contract</a></li>
                    <li><a href="index.php?content=introduction">Introduction</a></li>
                </ul>
                <ul class="social-links">
                    <h3 class="sidebar-headings">External links</h3>
                    <li><a href="https://github.com/jcalhou9">GitHub</a></li>
                    <li><a href="https://jcalhou9.github.io/">GitHub.io</a></li>
                    <li><a href="https://jcalhou9.github.io/web115/">WEB115</a></li>
                    <li><a href="https://jcalhou9.github.io/web215/">WEB215</a></li>
                    <li><a href="https://jcalhou9.github.io/web250/">WEB250</a></li>
                    <li><a href="https://www.freecodecamp.org/jcalhou9">freeCodeCamp</a></li>
                    <li><a href="https://www.codecademy.com/profiles/jcalhou9">Codecademy</a></li>
                    <li><a href="https://jsfiddle.net/u/jcalhou9/fiddles/">JSFiddle</a></li>
                    <li><a href="https://www.linkedin.com/in/jeremy-calhoun-3aab016a/">Linkedin</a></li>
                </ul>
            </nav>
		</aside>
		<header>
			<h1>Jeremy Calhoun's Jubilant Cheetah ~ WEB250</h1>
		</header>
		<main>
			<?php include "components/" . $content . '.html'; ?>
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