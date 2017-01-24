<?php $this->layout('layout', ['title' => 'Mon espace',
'link1'=>'',
'link2'=>'link2',
'link3'=>'',
'link4'=>'',
'link5'=>'',
'displayConnectLink' =>$connectLinkChoice]); ?>

<?php $this->start('main_content'); ?>

<!--navigation  choix de l'user-->
<div class="userChoice">
	<a class="userChoice_icons" href="<?= $this->url("user_home"); ?>"><span class="glyphicon glyphicon-user"></span>MON&nbsp;COMPTE</a>&nbsp;&nbsp;
	<a class="userChoice_icons" href="<?= $this->url("projects_home"); ?>"><span class="glyphicon glyphicon-list-alt"></span>UTILISATEUR</a>&nbsp;&nbsp;
	<a class="userChoice_icons" href="<?= $this->url("news_edit"); ?>"><span class="glyphicon glyphicon-globe"></span>NEWS</a>
</div>

<div class="userContent">

	<?php if (isset($errorModifyCoordinates)){
		$feedback='Problème lors de la mise à jour de vos coordonnées. Veuillez réessayer.';
	} else {
		$feedback='';
	}?>

	<!--Formulaire compte utilisateur  -->
	<div class="main-login_modify">
		<form class="form-inscription" method="post" action="<?= $this->url("user_modifyCoordinates"); ?>">
		 	<h3 class="form_section center">Mes données utilisateur</h3>

			<span class="asterix obligatoire center">* Champs Obligatoires</span>

			<label for="lastname">Votre Nom<span class="asterix">*</span> : </label>
			<input type="text" name="lastname" placeholder="Nom" value="<?= $_SESSION['user']['lastname']?>" required>

			<label for="firstname">Votre Prénom<span class="asterix">*</span> : </label>
			<input type="text" name="firstname" placeholder="Prénom" value="<?= $_SESSION['user']['firstname']?>" required>

			<label for="email">Votre E-mail<span class="asterix">*</span> : </label>
			<input type="email" name="email" placeholder="E-Mail" value="<?= $_SESSION['user']['mail']?>" required>

			<label for="numTel">Votre Numéro de Téléphone : </label>
			<input type="text" name="numTel" placeholder="Téléphone (Optionnel)" value="<?= $_SESSION['user']['phone']?>">

			<input type="hidden" name="form_name" value="modifyCoordinates">
			<input class="input-submit" type="submit" name="inscription" value="Modifier">

			<p class="center">
				<?=$feedback?>
			</p>
		</form>
	</div>
</div>

<?php $this->stop('main_content') ?>
