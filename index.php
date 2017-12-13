<!DOCTYPE html>
<html>
	<head>
		<title>AC - site personnel</title>
		<meta charset="UTF-8">
		<link rel="icon" type="image/png" href="images/logo/logo_AC_red_2.png" />
		<link type="text/css" rel="stylesheet" href="css/general.css"/>
		<link type="text/css" rel="stylesheet" href="css/index.css"/>
		<link type="text/css" rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css"/>

		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.12.1/jquery-ui.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				$("section#introduction #competences #img_muscle").hover(function(){	
					$(".muscle_img_1").switchClass("muscle_img_1", "muscle_img_2", 1200);
				},function() {
					$(".muscle_img_2").switchClass("muscle_img_2", "muscle_img_1", 1200);
				});

				$("section#introduction #mon_cv #img_cv").hover(function(){
					
					$(".cv_img_1").switchClass("cv_img_1", "cv_img_2", 1200);
				},function() {
					$(".cv_img_2").switchClass("cv_img_2", "cv_img_1", 1200);
				});
			});
		</script>
	</head>
	<body>
		<?php
		include 'includes/navBar.php';
		?>
		<section id="index">
			<div id="couche">
				<header id="banner">
					<div id="container">
						<img id="bannerLogo" src="images/logo/logo_AC_black_2.png"/>
						<h1>site personnel</h1>
					</div>
				</header>
				<section id="introduction">
					<div id="competences">
						<div id="container">
							<h2>Mes compétences</h2>
							<div id="content">
								<div id="img_muscle" class="img muscle_img_1">
								</div>
								<p>
									Via divers modules développés par mes soins, je vous présente mes capacités en développement web.
								</p>
							</div>
						</div>
					</div>
					<div id="mon_cv">
						<div id="container">
							<h2>Mon CV</h2>
							<div id="content">
								<div id="img_cv" class="img cv_img_1">
								</div>
								<p>
									Je suis actuellement en recherche d'emploi en tant que développeur web.
								</p>
								<br>
								<a id="monCv" href="document/CERDAN_Alexandre_CV.pdf" download>Télécharger le CV</a>
							</div>
						</div>
					</div>
				</div>
			</section>
			<footer>
				<?php
				include 'includes/footer.php';
				?>
			</footer>
		</section>
	</body>
</html>