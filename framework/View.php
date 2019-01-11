<?php

class View 
{

	private $_file;
	private $_title;
	// CONSTRUCTEUR
	public function __construct($action) 
	{

		// CREATION DE LA VUE EN FONCTION DE L ACTION
		$this->_file = "view/view" . $action . ".php";
	}

	// GENERER ET AFFICHER LA VUE
	public function display($data=array()) 
	{
		//GENERER LA PARTIE SPECIFIQUE DE LA VUE
		$content = $this->generateHtml($this->_file, $data);
	    // RECUPERATION DU CHEMIN DU SITE POUR LA REECRITURE DES URI
	  //  $racineWeb = Configuration::getParam("racineWeb", "/");
		//GENERER LE TEMPLATE AVEC LES PARAMETRE TITLE ET CONTENT
		$resultsHtml = $this->generateHtml('view/template.php',array('title' => $this->_title, 'content' => $content));
		
		// RENVOI LA VUE 
		echo $resultsHtml;
	}

	//GENERER UN FICHIER VUE ET RENVOI LE RESULTAT
	private function generateHtml($file, $data) {

		if (file_exists($file)) 
		{
			//REND LES ELEMENTS DU TABLEAU $DATA ACCESSIBLE DANS LA VUE
			extract($data);

			//DEMARRAGE DE LA TEMPORISATION DE SORTIE
			ob_start();

			//ON INCLUT LE FICHIER VUE ET ON PLACE LE RESULTAT DANS LE TAMPON
			require $file;

			//RENVOI DU TAMPON DE SORTIE
			return ob_get_clean();
		}
		else 
		{
			//ON LEVE UNE EXCEPTION SI LE FICHIER EST INTROUVABLE
			throw new Exception('Le fichier ' . $file . ' est introuvable');
		}
	}
}
