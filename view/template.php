<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php  echo  $title;  ?></title>
		<base href="<?= $racineWeb ?>" >
	</head>
	<body>
		<div id="main">
			<header>
				<div id="menucss">
					<ul>
						<li>
							<a href="index.php">Accueil</a>
						</li>
					</ul>
				</div>
			</header>
			<div id="content">
				<?php echo $content;  ?>
			</div>
		</div>
		<footer>
				Pied du document
		</footer>
	</body>
</html>
