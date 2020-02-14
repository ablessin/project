<?php
    include("templates/top.php");
    include("db.php");

    //si on a des données dans $_POST, 
    //c'est que le form a été soumis
    if(!empty($_POST)){
        //par défaut, on dit que le formulaire est entièrement valide
        //si on trouve ne serait-ce qu'une seule erreur, on 
        //passera cette variable à false
        //git
        $formIsValid = true;
        $firstname = strip_tags($_POST['firstname']);
        $lastname = strip_tags($_POST['lastname']);
        $company = strip_tags($_POST['company']);
        $title = strip_tags($_POST['title']);
        $message = strip_tags($_POST['message']);

    //tableau qui stocke nos éventuels messages d'erreur
	$errors = [];

	//si le author est vide...
	if(empty($firstname) ){
		//on note qu'on a trouvé une erreur ! 
		$formIsValid = false;
		$errors[] = "Veuillez renseigner votre prénom !";
	}
	//mb_strlen calcule la longueur d'une chaîne
	elseif(mb_strlen($firstname) == 1){
		$formIsValid = false;
		$errors[] = "Votre prénom est trop court.";
	}
	elseif(mb_strlen($firstname) > 50){
		$formIsValid = false;
		$errors[] = "Votre prénom est trop long !";
    }
    if (empty($company)){
        $formIsValid = false;
        $errors[]="Vous n'avez pas saisi le nom de votre entreprise.";
    }
    if (empty($title)){
        $formIsValid = false;
        $errors[]="Vous n'avez pas saisi le titre de votre commentaire.";
    }
	if(empty($message)){
		$formIsValid = false;
		$errors[] = "Vous avez oublié de rentrer un commentaire.";
	}

//si le formulaire est toujours valide... 

if ($formIsValid == true){
//on écrit tout d'abord notre requête SQL, dans une variable
$sql = "INSERT INTO messages 
		(lastname, firstname, company, title, comment, created_date)
		VALUES 
		(:lastname, :firstname, :company, :title, :message, NOW())";

$stmt = $pdo->prepare($sql);
$stmt->execute([
	":lastname" => $lastname,
    ":firstname" => $firstname,
    ":company" => $company,
    ":title" => $title,
	":message" => $message,
]);
}
    }
?>
<div class="title" id="recomm">
    <h2 class="titre"> Recommandations </h1>
</div>
    <div class="content" id="recommandation">
        <div class="comment">
            <div class="recommandationstext">
                <h4>Il vous le faut</h4>
                    <ul>
                        <li>Je recommande cet individu, travail en groupe parfaitement.</li>
                        <li>L'openspace est son terrain de jeu.</li>
                        <li>LOL</li>
                    </ul>
            </div>
            <div class ="auteur">
                <ul>
                    <li>Google</li> 
                    <li>Un peu tout</li>
                    <li>Silicon Valley</li>
                    <li>Bill Gates</li>
                </ul>
            </div>
        </div>
                </div>
                <div class="new">
                <h2>Ajouter un message !</h2>
		        <form method="post">
	                <div> 
	                    <label for="lastname">Votre nom</label>
	                    <input type="text" name="lastname" id="lastname">
                    </div>
                    <div> 
	                    <label for="firstname">Votre prénom</label>
	                    <input type="text" name="firstname" id="firstname">
                    </div>
                    <div> 
	                    <label for="company">Votre entreprise</label>
	                    <input type="text" name="company" id="company">
                    </div>
                    <div> 
	                    <label for="title">Votre titre</label>
	                    <input type="text" name="title" id="title">
	                </div>  
	                <div> 
	                    <label for="message">Votre message</label>
	                    <textarea name="message" id="message"></textarea>
	                </div>          
                    <?php 
                        //affiche les éventuelles erreurs de validations
                        if (!empty($errors)) {
                            foreach ($errors as $error) {
                            echo '<div>' . $error . '</div>';
                            }
                        }   
                    ?>
	                <button>Envoyer !</button>
	            </form>
            </div>
        </div>
<?php 
    include("templates/bottom.php");
?>