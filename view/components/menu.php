<header>
	<nav class="navbar navbar-expand-lg navbar-light bg-light  ">
	  	<a class="navbar-brand" href="index.php">
		    <img src="assets/img/design/logo.png"/>
	  	</a>
	  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	   		<span class="navbar-toggler-icon"></span>
	  	</button>
	  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	    	<ul class="navbar-nav mr-auto">
	      		<li class="nav-item">
	        		<a class="nav-link" href="index.php?controller=ranking">Classement</a>
	      		</li>
	      		<li class="nav-item">
	        		<a class="nav-link" href="index.php?controller=bet">Pronostic</a>
	      		</li>
		      	<li class="nav-item">
		        	<a class="nav-link" href="index.php?controller=result">Résultat</a>
		      	</li>
		      	<li class="nav-item">
		       		<a class="nav-link" href="index.php?controller=league">Ligue 1</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="nav-link" href="index.php?controller=dayPoint">Score</a>
		      	</li>
	    	</ul>
	    	<ul class="navbar-nav ml-auto">
	      		<?php 
	      		if(isset($_SESSION['pseudo']))
	      		{
	      		?>
	      			<li class="nav-item">
	        			<a class="nav-link" href="index.php?controller=profil"><?= $_SESSION['pseudo'];?></a>
	      			</li>
			      	<li class="nav-item">
			        	<a class="nav-link" href="index.php?controller=connection&action=deconnection"><i class="fas fa-lock-open" alt="deconnexion" title="déconnexion"></i></a>
			      	</li>
		      		<?php if($_SESSION['admin'] == 1)
		      		{
		      		?>
			      		<li class="nav-item">
			       			<a class="nav-link" href="index.php?controller=admin">Admin</a>
			      		</li>
			      	<?php
		      		}
	      		}
	      		else
	      		{
	      		?>
		      		<li class="nav-item">
			        	<a class="nav-link" href="index.php?controller=connection&action=connection"><i class="far fa-user" alt="connexion" title="connexion"></i></a>
			      	</li>
		      	<?php
	      		}
	      		?>
		      
	    	</ul>
	  	</div>
	</nav>
</header>