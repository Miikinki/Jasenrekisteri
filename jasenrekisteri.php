<?php include('process.php'); ?>
<?php
include "config.php";

// Check user login or not
if(!isset($_SESSION['uname'])){
    header('Location: kirjaudu.php');
}

// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: kirjaudu.php');
}
?>
<!DOCTYPE html>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Jäsenrekisteri</title>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="tyylit123.css">
	
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

	</head>
	<body>
	<!-- Tarkistaa kerran löytyykö tiedostoa, jos ei löydy, lopeta ohjelman suorittaminen, koska sovellus ei toimi ilman -->
	<?php require_once 'process.php'; ?> 

	<?php

	//Jos session viesti on asetettu, tulosta viesti index.php sivulle käyttäen bootstrapin luokkaa, joka vaihtaa viestin värin perustuen "msg_typeen"
	if(isset($_SESSION['message'])): ?>
	
	<div class="alert alert-<?=$_SESSION['msg_type']?>"> 
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Suoritit toiminnon:</strong>
	<?php
		echo $_SESSION['message']; 
		unset($_SESSION['message']);
	?>
	</div>
	<?php endif ?>

	
	<?php
		//yhdistä tietokantaan
		$mysqli = new mysqli('mysql04.domainhotelli.fi','jnvrlywv_admin','salasana123','jnvrlywv_crudnaytto') or die (mysqli_error($mysqli));
		//varastoidaan "data" nimisen tietokannan tiedot "result"-muuttujaan
		$result = $mysqli->query("SELECT * FROM kayttajat") or die($mysqli->error);
		?>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="#"><i class="fa fa-database fa-lg"></i></a>
    <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="fpsboosti.fi/index.html">Koti</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Rekisteri</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Ota yhteyttä</a>
    </li>
  </ul>
</nav>



  <div class="jumbotron">
    <h1>Jäsenrekisteri</h1>      
  </div>
  

	<div class="container">

	 <form action="process.php" method="POST">
	 <input type="hidden" name="id" value="<?php echo $id; ?>">
	  <div class="form-row">
		<div class="form-group col-md-3">
		<!-- formin arvoiksi asetetaan nimi, sukunimi ja osoitteen muuttujat -->
		  <label for="inputName">Etunimi</label>
		<input type="text" name="name" maxlength="10" class="form-control" value="<?php echo $name; ?>" placeholder="Etunimi" required>
		</div>
		<div class="form-group col-md-3">
				  <label for="inputLastname">Sukunimi</label>
		<input type="text" name="lastname" maxlength="15" class="form-control" value="<?php echo $lastname; ?>" placeholder="Sukunimi" required>
		</div>
		<div class="form-group col-md-3">
				  <label for="inputLastname">Osoite</label>
		<input type="text" name="address" maxlength="25" class="form-control" value="<?php echo $address; ?>" placeholder="Osoite" required>
		</div>
		</div>
		 <div class="form-row">
	<div class="form-group col-md-3">
		  <label for="inputaddress">Paikkakunta</label>
		<input type="text" name="city" maxlength="15" class="form-control" value="<?php echo $city; ?>"  placeholder="Paikkakunta" required>
	</div>
		<div class="form-group col-md-3">
		  <label for="number">Puhelinnumero</label>
		<input type="text" name="phonenumber" maxlength="15" class="form-control" value="<?php echo $phonenumber; ?>" placeholder="Puhelinnumero" required>
		</div>
	<div class="form-group col-md-3">
		  <label for="email">Sähköposti</label>
		<input type="email" name="email" maxlength="45" class="form-control" value="<?php echo $email; ?>" placeholder="Sähköposti" required>
		</div>
      </select>
    </div>

		<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#contact"><i class="fa fa-plus fa-fw"></i>Lisää uusi jäsen</button>
	
		<button type="submit" name="update" class="btn btn-dark"> <i class="fa fa-exchange"></i> Päivitä</button>
		
		<button class="btn btn-dark"  onclick="location.reload();"> <i class="fa fa-refresh"></i></button>
		
	</form>	
		</div>	
		<div class="table-responsive">
			<table class="table table-sm  table-hover table table-striped table-dark table-dark">
				<thead>
					<tr>
						<th>Jäsentunnus</th>
						<th>Etunimi</th>
						<th>Sukunimi</th>
						<th>Osoite</th>
						<th>Paikkakunta</th>
						<th>Puhelinnumero</th>
						<th>Sähköposti</th>
						<th>Toiminto</th>
					</tr>
                </thead>
				<?php
				//Haetaan fetch_assoc ja while-loopin avulla dataa tietokannasta ja varastoidaan tulokset row-muuttujaan, joka näyttää ne HTML-tablessa
				//fetch_assoc hakee tiedot tietokannasta ja while-silmukka pyörii kunnes kaikki tiedot on haettu
					while ($row = $result->fetch_assoc()): ?>
					<tr>
						<td><?php echo $row['ID']; ?></td>
						<td><?php echo $row['Etunimi']; ?></td>
						<td><?php echo $row['Sukunimi']; ?></td>
						<td><?php echo $row['Osoite']; ?></td>
						<td><?php echo $row['Paikkakunta']; ?></td>
						<td><?php echo $row['Puhelinnumero']; ?></td>
						<td><?php echo $row['Sahkoposti'];?></td>
						<td>
						<!--muokataan sarakkeen ID:n avulla -->
						<a href="jasenrekisteri.php?edit=<?php echo $row['ID']; ?>" 
						class="btn btn-primary"><i class="fa fa-pencil fa-fw"></i>Muokkaa</a>
						<!-- Delete link-buttoni -->
		
						<a href="process.php?delete=<?php echo $row['ID']; ?>"
						class="btn btn-primary"><i class="fa fa-trash-o fa-lg"></i> Poista</a>
						</td>
					</tr>
			<?php endwhile; ?>
		</table>
		</div>
	    <form method='post' action="">
            <input type="submit" value="Kirjaudu ulos" name="but_logout">
        </form>
		

<footer class="page-footer font-small bg-dark pt-4">
  <div class="container">
    <ul class="list-unstyled list-inline text-center">
      <li class="list-inline-item">
        <a class="btn-fb mx-1">
          <i class="fa fa-facebook fa-2x"></i>
        </a>
      </li>
      <li class="list-inline-item">
        <a class="bird-button mx-1">
          <i class="fa fa-twitter fa-2x"> </i>
        </a>
      </li>
      <li class="list-inline-item">
        <a class="btn-google mx-1">
          <i class="fa fa-google fa-2x"> </i>
        </a>
      </li>
	    <li class="list-inline-item">
        <a class="btn-ig mx-1">
          <i class="fa fa-instagram fa-2x"></i>
        </a>
      </li>
	     <li class="list-inline-item">
        <a class="btn-utube mx-1">
          <i class="fa fa-youtube fa-2x"></i>
        </a>
      </li>
      <li class="list-inline-item">
        <a class="btn-linked mx-1">
          <i class="fa fa-linkedin fa-2x"></i>
        </a>
      </li>
    </ul>
  <div class="footer-copyright text-center py-3">© 2019 Copyright:
    <a href="https://fpsboosti.fi"> Jasenrekisteri.fi</a>
  </div>
</footer>



	
	  <div class="modal fade" id="contact" role="dialog">
	   
		<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h5>Lisää uusi henkilö jäsenrekisteriin.</h5>
			</div>
			
			<form class="contact" action="process.php" method="post">
				<div class="modal-body">
			 
			<div class="form-group">
			<label for="contact-name" class="col-sm-2 control-label">Nimi</label>
			<div class="col-sm-10">
					<input type="text" name="name" maxlength="10" class="form-control" value="<?php echo $name; ?>" placeholder="Etunimi" required>
			</div>
			</div>
				<div class="form-group">
			<label for="contact-lastname" class="col-sm-2 control-label">Sukunimi</label>
			<div class="col-sm-10">
				<input type="text" name="lastname" maxlength="15" class="form-control" value="<?php echo $lastname; ?>" placeholder="Sukunimi" required>
			</div>
			</div>
				<div class="form-group">
			<label for="contact-address" class="col-sm-2 control-label">Osoite</label>
			<div class="col-sm-10">
				<input type="text" name="address" maxlength="25" class="form-control" value="<?php echo $address; ?>"  placeholder="Osoite" required>
				</div>
				</div>
				<div class="form-group">
			<label for="contact-city" class="col-sm-2 control-label">Paikkakunta</label>
			<div class="col-sm-10">
			<input type="text" name="city" maxlength="15" class="form-control" value="<?php echo $city; ?>" placeholder="Paikkakunta" required>
			</div>
			</div>
					<div class="form-group">
			<label for="contact-" class="col-sm-2 control-label">Puhelinnumero</label>
			<div class="col-sm-10">
			<input type="text" name="phonenumber" maxlength="15" class="form-control" value="<?php echo $phonenumber; ?>" placeholder="Puhelinnumero" required>
			</div>
			</div>
					<div class="form-group">
			<label for="contact-email" class="col-sm-2 control-label">Sähköposti</label>
			<div class="col-sm-10">
			<input type="email" name="email" maxlength="45" class="form-control" value="<?php echo $email; ?>" placeholder="Sähköposti" required>
			</div>
			</div>
		
		<div class="modal-footer">
		<a class="btn btn-danger" data-dismiss="modal">Sulje</a>
		<button type="submit" name="save" class="btn btn-primary"> <i class="fa fa-address-book"></i> Lisää</button>
		</div>
		</div>
		</div>
		
		
		
		
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	</body>

    