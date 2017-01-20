<?php

namespace Controller;

use \W\Controller\Controller;

class DefaultController extends Controller
{

	/**
	 * Page d'accueil par défaut
	 */
	public function home()
	{
		$this->show("default/home", ['connectLinkChoice' => false]);
	}

	/**
	 * redirection: navigation pure
	 */
	public function nav($target)
	{
		if ($target=="fabrication_additive"){
		$this->show("DMIcontent/$target", ['connectLinkChoice' => true]);
		} else {
		$this->show("DMIcontent/$target", ['connectLinkChoice' => false]);
		}
	}

	public function news()
	{
		var_dump('News');
		$this->show("default/home", ['connectLinkChoice' => false]);
	}

}
