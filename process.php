<?php

session_start();

//Yhdistä mysqli tietokantaan
$mysqli = new mysqli('mysql04.domainhotelli.fi', 'jnvrlywv_admin','salasana123', 'jnvrlywv_crudnaytto') or die (mysqli_error($mysqli));

//asetetaan stringit tyhjiksi, ja asetetaan niihin tiedot vasta kun "edit" nappulaa painetaan käyttöliittymässä
$name = '';
$lastname = '';
$address = '';
$city = '';
$phonenumber = '';
$email = '';


$id = 0;
$update = false;
//Jos Save nappia painetaan, tallenna "name" ja "address" tiedot tietokantaan "kayttajat" tauluun käyttämällä esimääriteltyä $_POST muuttujaa
//$_POST muuttujan avulla kerätään tiedot HTML-formista ja lähetetään tietokantaan
if (isset($_POST['save'])){
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
	$city = $_POST['city'];
    $phonenumber = $_POST['phonenumber'];
	$email = $_POST['email'];

    $mysqli->query("INSERT INTO kayttajat (Etunimi, Sukunimi, Osoite, Paikkakunta, Puhelinnumero, Sahkoposti) VALUES('$name', '$lastname', '$address', '$city', '$phonenumber', '$email')") or
            die($mysqli->error);

            $_SESSION['message'] = "Jäsen lisätty jäsenrekisteriin.";
            $_SESSION['msg_type'] = "primary";
            
    //ohjaa käyttäjä takaisin index.php sivulle header-funktion avulla
	header("location: jasenrekisteri.php");
}

//Jos Delete nappia painetaan, poista tiedot "kayttajat" taulusta ID:n avulla, joka saadaan esimääritelyllä $_GET['delete'] muuttujalla
if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM kayttajat WHERE ID=$id") or die($mysqli->error());

    $_SESSION['message'] = "Jäsen poistettu jäsenrekisteristä.";
    $_SESSION['msg_type'] = "danger";

         //ohjaa käyttäjä takaisin index.php sivulle header-funktion avulla
	header("location: jasenrekisteri.php");
}

//Jos Edit nappia painetaan, haetaan "kayttajat" taulusta tiedot HTML-formiin muokattavaksi
if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM kayttajat WHERE id=$id") or die($mysqli->error());
    //hakee vanhat tiedot taulusta ja määritellään muuttujat
    if($result->num_rows){
		$row = $result->fetch_array();
		$name = $row['Etunimi'];
		$lastname = $row['Sukunimi'];
        $address = $row['Osoite'];
		$city = $row['Paikkakunta'];
        $phonenumber = $row['Puhelinnumero'];
		$email = $row['Sahkoposti'];
}
}
//Jos Update nappia painetaan, päivitetään uudet tiedot vanhojen tilalle
if (isset($_POST['update'])){
	$id = $_POST['id'];
	$name = $_POST['name'];
	$lastname = $_POST['lastname'];
    $address = $_POST['address'];
	$city = $_POST['city'];
    $phonenumber = $_POST['phonenumber'];
	$email = $_POST['email'];
	
    $mysqli->query("UPDATE kayttajat SET Etunimi='$name', Sukunimi='$lastname', Osoite='$address', Paikkakunta='$city', Puhelinnumero='$phonenumber', Sahkoposti='$email' WHERE id=$id") or die($mysqli->error);

    $_SESSION['message'] = "Jäsenrekisterin tiedot päivitetty.";
    $_SESSION['msg_type'] = "success";
    
    header("location: jasenrekisteri.php");
}