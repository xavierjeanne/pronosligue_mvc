<header>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  	<a class="navbar-brand" href="index.php">
		    Pronosligue
	  	</a>
	  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	   		<span class="navbar-toggler-icon"></span>
	  	</button>
	  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	    	<ul class="navbar-nav mr-auto">
	      		<li class="nav-item">
	        		<a class="nav-link" href="bet">Pronostic</a>
	      		</li>
	      		<li class="nav-item">
	        		<a class="nav-link" href="ranking">Classement</a>
	      		</li>
		      	<li class="nav-item">
		        	<a class="nav-link" href="results">Résultat</a>
		      	</li>
		      	<li class="nav-item">
		       		<a class="nav-link" href="league">Ligue 1</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="nav-link" href="score">Score</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="nav-link" href="bonus">Bonus</a>
		      	</li>
		     	<li class="nav-item">
		        	<a class="nav-link" href="pub">Pub</a>
		      	</li>
	    	</ul>
	    	<ul class="navbar-nav ml-auto">
	      		<?php 
	      		if(isset($_SESSION['pseudo']))
	      		{
	      		?>
	      			<li class="nav-item">
	        			<a class="nav-link" href="profil"><?= $_SESSION['pseudo'];?></a>
	      			</li>
			      	<li class="nav-item">
			        	<a class="nav-link" href="connection/deconnection">Déconnexion</a>
			      	</li>
			      	<li class="nav-item">
		       			<a class="nav-link" href="notification">Notification</a>
		      		</li>
		      		<?php if($_SESSION['admin'] == 1)
		      		{
		      		?>
			      		<li class="nav-item">
			       			<a class="nav-link" href="admin">Admin</a>
			      		</li>
			      	<?php
		      		}
	      		}
	      		else
	      		{
	      		?>
		      		<li class="nav-item">
			        	<a class="nav-link" href="connection/connection">Connexion</a>
			      	</li>
		      	<?php
	      		}
	      		?>
		      
	    	</ul>
	  	</div>
	</nav>
</header>