<?php
//require für Datenbankverbindungseinstellungen
require_once(dirname(__DIR__) . '/globalconfig.php');
session_start();


if (!empty($_POST)) {

    $pdo = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name, $db_user, $db_pass);
    $pdo->exec("set names utf8");


    //$sql = "SELECT * FROM " . $db_pref . "_alles WHERE strecke=" . $_GET['strecke'] . " ORDER BY km_i ASC";

    $start = strtotime($_POST['fin-start']);
    $start = date('Y-m-d', $start);

    $ende = strtotime($_POST['fin-ende']);
    $ende = date('Y-m-d', $ende);


    $sqlabfrage = 'INSERT INTO ' . $db_pref . '_projekte (projektname, ortgeo, ansprechpartner, projektleiter, start, ende, zusatz, erstelltvon, benutzer, status) VALUES (:u_projektname, :u_ortgeo, :u_ansprechpartner, :u_projektleiter, :u_start, :u_ende, :u_zusatz, :u_erstelltvon, :u_benutzer, :u_status)';
    $sql = $pdo->prepare($sqlabfrage);

    //echo $sql;

    $notice_name = htmlspecialchars($_POST['fin-name'], ENT_QUOTES);
    $notice_ansprech = htmlspecialchars($_POST['fin-ansprechpartner'], ENT_QUOTES);
    $notice_projekt = htmlspecialchars($_POST['fin-projektleiter'], ENT_QUOTES);
    $notice_zusatz = htmlspecialchars($_POST['fin-zusatz'], ENT_QUOTES);
    //$notice_status = htmlspecialchars($_POST['fin-statusnr'], ENT_QUOTES);


    $sql->bindParam(':u_projektname', $notice_name);
    //$tmp_a = serialize(htmlspecialchars($_POST['fin-orte']);
    $sql->bindParam(':u_ortgeo', $_POST['fin-orte']);
    $sql->bindParam(':u_ansprechpartner', $notice_ansprech);
    $sql->bindParam(':u_projektleiter', $notice_projekt);
    $sql->bindParam(':u_start', $start);
    $sql->bindParam(':u_ende', $ende);
    $sql->bindParam(':u_zusatz', $notice_zusatz);
    $sql->bindParam(':u_erstelltvon', $_SESSION['user']['userid']);
    //$tmp_b = serialize(htmlspecialchars($_POST['fin-benutzerids']);
    $sql->bindParam(':u_benutzer', $_POST['fin-benutzerids']);;
    $sql->bindParam(':u_status', $_POST['fin-statusnr'], PDO::PARAM_INT);

    $sql->execute();

    //$antwort = $sql->fetch();
    //echo $antwort;

    $id = $pdo->lastInsertId();

    header('location:../projectdetail.php?projectid=' . $id . '&c');


} else {
    echo 'leer';
}
?>