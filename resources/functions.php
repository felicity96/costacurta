<?php

use PHPMailer\PHPMailer\PHPMailer;
//require '../vendor/autoload.php';


//*************************** SYSTEM FUNCTIONS ****************************

// redirect to a page
function redirect($location) {

    return header("Location: $location ");

}

// crea un messaggio
function set_message($msg, $alert_type) {

    if(!empty($msg)) {
        $_SESSION['message'] = $msg;
        $_SESSION['alert'] = $alert_type;
    }
    else {
        $msg = "";
        $alert_type = "";
    }

}

// mostra un messaggio
function display_message() {

if(isset($_SESSION['message']) && isset($_SESSION['alert'])) {
    
$alert = <<<DELIMETER

<div class="alert {$_SESSION['alert']} w-50 text-center" role="alert">
    {$_SESSION['message']}
</div>

DELIMETER;

echo $alert;

unset($_SESSION['message']);
}

}

// fa una query al database
function query($sql){

    global $connection;

    return mysqli_query($connection, $sql);

}

// conferma la query
function confirm($result){

    global $connection;

    if(!$result) {
        die("QUERY FAILED " . mysqli_error($connection));
    }

}


function escape_string($string) {

    global $connection;

    return mysqli_real_escape_string($connection, $string);

}

function fetch_array($result){

    return mysqli_fetch_array($result);

}

// ritorna il path per le immagini
function display_image($image) {

    return "uploads" . DS . $image;

}

//*************************** GETTERS ****************************

// getter per i dati degli studi
function get_studi() {

    $query = query("SELECT * FROM studi");
    confirm($query);

    $studi = [];

    while($row = fetch_array($query)) {
        array_push($studi, $row);
    }

    return $studi;

}

// getter per i dati dello studio
function get_studio_data($id) {

    $query = query("SELECT * FROM studi WHERE studio_id = '{$id}' ");
    confirm($query);

    $row = fetch_array($query);
    return $row;

}

// getter per i dati dell'admin
function get_admin_data() {

    $query = query("SELECT * FROM users WHERE user_id = '{$_SESSION['user']}' ");
    confirm($query);

    $row = fetch_array($query);
    return $row;

}

// ritorna il numero di slide
function get_tot_slides($studio) {

    $query = query("SELECT COUNT(*) as total FROM slides WHERE studio_id = '{$studio}' ");
    confirm($query);

    $row = fetch_array($query);
    return $row['total'];

}

// ritorna il numero di aree 
function get_tot_areas() {

    $query = query("SELECT COUNT(*) as total FROM aree");
    confirm($query);

    $row = fetch_array($query);
    return $row['total'];

}

// ritorna il numero di articoli
function get_tot_art() {

    $query = query("SELECT COUNT(*) as total FROM articoli");
    confirm($query);

    $row = fetch_array($query);
    return $row['total'];

}

// getter per i dati del profilo
function get_profile() {

    $query = query("SELECT * FROM profilo ORDER BY pro_id DESC LIMIT 1");
    confirm($query);

    $row = fetch_array($query);
    return $row;

}

//*************************** FRONT FUNCTIONS ****************************

// mostra il contenuto del body della pagina dinamicamente
function show_main_content() {

    if($_SERVER['REQUEST_URI'] == "/costacurta/public/" || $_SERVER['REQUEST_URI'] == "/costacurta/public/index.php" ) {
        include(TEMPLATE_FRONT . "/main.php");
    }

    if(isset($_GET['chisono'])) {
        include(TEMPLATE_FRONT . "/chisono.php");
    }

    if(isset($_GET['aree'])) {
        include(TEMPLATE_FRONT . "/aree.php");
    }

    if(isset($_GET['studio'])) {
        include(TEMPLATE_FRONT . "/studio.php");
    }

    if(isset($_GET['articoli'])) {
        include(TEMPLATE_FRONT . "/articoli.php");
    }

    if(isset($_GET['contatti'])) {
        include(TEMPLATE_FRONT . "/contatti.php");
    }

    if(isset($_GET['login'])) {
        include(TEMPLATE_FRONT . "/login.php");
    }

}

// manda una email dal form della pagina dei contatti
function send_email() {

    if(isset($_POST['submit'])) {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $toEmail = "annacb21@gmail.com";

        $mail = new PHPMailer();

        /*
        Host: smtp.mailtrap.io
        Port: 25 or 465 or 587 or 2525
        Username: 7118daa26bcca3
        Password: d35b5a76b761b8
        Auth: PLAIN, LOGIN and CRAM-MD5
        TLS: Optional (STARTTLS on all ports)
        */

        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = '7118daa26bcca3';
        $mail->Password = 'd35b5a76b761b8';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 2525;

        $mail->setFrom($email, $name);
        $mail->addAddress('annacb21@gmail.com', 'Anna');
        $mail->Subject = 'New message from your website';
        $mail->isHTML(true);
        $mail->Body = $message;

        if($mail->send()) {
            set_message("La tua email è stata inviata con successo", "alert-success");
        } 
        else {
            set_message("Oops, qualcosa è andato storto: " . $mail->ErrorInfo, "alert-danger");  
        }
        redirect("../public/index.php?contatti");

    }

}

// fa il login dell'admin
function login() {

    if(isset($_POST['login'])) {

        $username = escape_string($_POST['username']);
        $psw = escape_string($_POST['psw']);

        $query = query("SELECT * FROM users WHERE username = '{$username}' LIMIT 1");
        confirm($query);

        $row = fetch_array($query);

        if(mysqli_num_rows($query) == 0 || password_verify($psw, $row['password']) === false) {
            set_message("La tua password o il tuo username sono sbagliati", "alert-danger");
            redirect("../public/index.php?login");
        }
        else {
            $_SESSION['user'] = $row['user_id'];
            redirect("admin/");
        }

    }

}

// mostra i thumbnails delle slide
function get_area_thumbnails() {

$query = query("SELECT * FROM aree ORDER BY area_id DESC");
confirm($query);

while($row = fetch_array($query)) {
    
$area_thumb = <<<DELIMETER

<div class="col-xs-6 col-md-3 mb-3">
    <div class="card" style="width: 20rem; height: 15rem;">
        <div class="card-body">
            <h5 class="card-title text-info">{$row['area_name']}</h5>
            <p class="card-text">{$row['area_desc']}</p>
        </div>
    </div>
</div>

DELIMETER;

echo $area_thumb;
    
}
    
}

//*************************** BACK FUNCTIONS ****************************

// mostra il contenuto del body della pagina dinamicamente
function show_admin_content() {

    if($_SERVER['REQUEST_URI'] == "/costacurta/public/admin/" || $_SERVER['REQUEST_URI'] == "/costacurta/public/admin/index.php" ) {
        include(TEMPLATE_BACK . "/dashboard.php");
    }

    if(isset($_GET['account'])) {
        include(TEMPLATE_BACK . "/account.php");
    }

    if(isset($_GET['profile'])) {
        include(TEMPLATE_BACK . "/profile.php");
    }

    if(isset($_GET['areas'])) {
        include(TEMPLATE_BACK . "/areas.php");
    }

    if(isset($_GET['gallery'])) {
        include(TEMPLATE_BACK . "/gallery.php");
    }

    if(isset($_GET['articles'])) {
        include(TEMPLATE_BACK . "/articles.php");
    }

    if(isset($_GET['edit_account'])) {
        include(TEMPLATE_BACK . "/edit_account.php");
    }

    if(isset($_GET['delete_slide'])) {
        include(TEMPLATE_BACK . "/delete_slide.php");
    }

    if(isset($_GET['delete_area'])) {
        include(TEMPLATE_BACK . "/delete_area.php");
    }

    if(isset($_GET['edit_area'])) {
        include(TEMPLATE_BACK . "/edit_area.php");
    }

    if(isset($_GET['edit_art'])) {
        include(TEMPLATE_BACK . "/edit_art.php");
    }

    if(isset($_GET['delete_art'])) {
        include(TEMPLATE_BACK . "/delete_art.php");
    }

    if(isset($_GET['edit_profile'])) {
        include(TEMPLATE_BACK . "/edit_profile.php");
    }

    if(isset($_GET['logout'])) {
        include(TEMPLATE_BACK . "/logout.php");
    }

}

// mostra il contenuto del body della pagina dinamicamente
function get_admin_h1() {

    $title = "";

    if($_SERVER['REQUEST_URI'] == "/costacurta/public/admin/" || $_SERVER['REQUEST_URI'] == "/costacurta/public/admin/index.php" ) {
        $title = "Dashboard";
    }

    if(isset($_GET['account'])) {
        $title = "Account";
    }

    if(isset($_GET['profile'])) {
        $title = "Profilo";
    }

    if(isset($_GET['areas'])) {
        $title = "Aree di intervento";
    }

    if(isset($_GET['gallery'])) {
        $title = "Gallery foto";
    }

    if(isset($_GET['articles'])) {
        $title = "Articoli";
    }

    if(isset($_GET['edit_account'])) {
        $title = "Modifica dati account";
    }

    if(isset($_GET['edit_area'])) {
        $title = "Modifica area di intervento";
    }

    if(isset($_GET['edit_art'])) {
        $title = "Modifica articolo";
    }

    if(isset($_GET['edit_profile'])) {
        $title = "Modifica profilo";
    }

    echo $title;

}

// modifica account admin
function update_account() {

    if(isset($_POST['update'])) {

        $username = escape_string($_POST['username']);
        $email = escape_string($_POST['email']);

        $query = query("UPDATE users SET username = '{$username}', email = '{$email}' WHERE user_id = '{$_SESSION['user']}' ");
        confirm($query);

        redirect("../../public/admin/index.php?account");

    }

}

// modifica password admin
function update_password($psw) {

    if(isset($_POST['updatePsw'])) {

        $current_psw = escape_string($_POST['current_psw']);
        $new_psw = escape_string($_POST['new_psw']);

        if($current_psw == $psw) {

            $query = query("UPDATE users SET password = '{$new_psw}' WHERE user_id = '{$_SESSION['user']}' ");
            confirm($query);

            redirect("../../public/admin/index.php?account");

        }
        else {
            
            set_message("Password attuale non corretta", "alert-danger");
            redirect("../../public/admin/index.php?edit_account");

        }

    }

}

// ritorna la slide (foto) corrente
function get_active_slide($studio) {

$query = query("SELECT * FROM slides WHERE studio_id = '{$studio}' ORDER BY slide_id DESC LIMIT 1");
confirm($query);

$row = fetch_array($query);

$img = display_image($row['slide_image']);

$slide = <<<DELIMETER

<div class="carousel-item active">
    <img src="../resources/{$img}" class="d-block w-100" alt="{$row['slide_title']}">
</div>

DELIMETER;

echo $slide;


}

// getter per le slide (foto) degli studi
function get_slides($studio) {

$query = query("SELECT * FROM slides WHERE studio_id = '{$studio}' AND slide_id NOT IN (SELECT MAX(slide_id) FROM slides WHERE studio_id = '{$studio}' ORDER BY slide_id DESC) ORDER BY slide_id DESC");
confirm($query);

while($row = fetch_array($query)) {

$img = display_image($row['slide_image']);

$slides = <<<DELIMETER

<div class="carousel-item">
    <img src="../resources/{$img}" class="d-block w-100" alt="{$row['slide_title']}">
</div>

DELIMETER;

echo $slides;
    
}

}

// aggiunge una slide (foto)
function add_slide() {

    if(isset($_POST['upload'])) {

        $title = escape_string($_POST['title']);
        $img = escape_string($_FILES['file']['name']);
        $img_loc = escape_string($_FILES['file']['tmp_name']);
        $studio = escape_string($_POST['study']);

        move_uploaded_file($img_loc, UPLOADS . DS . $img);

        $query = query("INSERT INTO slides(slide_title, slide_image, studio_id) VALUES ('{$title}', '{$img}', '{$studio}') ");
        confirm($query);

        set_message("Foto aggiunta correttamente", "alert-success");
        redirect("../../public/admin/index.php?gallery");

    }

}

// mostra i thumbnails delle slide
function get_slides_thumbnails() {

$query = query("SELECT * FROM slides ORDER BY slide_id DESC");
confirm($query);

while($row = fetch_array($query)) {

$img = display_image($row['slide_image']);

$slides_thumb = <<<DELIMETER

<div class="col-xs-6 col-md-3 mb-3">
    <img src="../../resources/{$img}" alt="{$row['slide_title']}" class="img-thumbnail img-fluid">

    <button type="button" class="btn btn-danger close-modal" data-toggle="modal" data-target="#deleteModal">X</button>

    <div class="modal fade" role="dialog" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Elimina foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Sei sicuro di voler eliminare questa foto?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                <a href="../../public/admin/index.php?delete_slide&id={$row['slide_id']}&img={$row['slide_image']}" role="button" class="btn btn-danger">Conferma eliminazione</a>
            </div>
            </div>
        </div>
    </div>
</div>

DELIMETER;

echo $slides_thumb;
    
}

}

// aggiunge un'area di intervento
function add_area() {

    if(isset($_POST['add'])) {

        $name = escape_string($_POST['name_area']);
        $desc = escape_string($_POST['desc']);

        $query = query("INSERT INTO aree(area_name, area_desc) VALUES ('{$name}', '{$desc}') ");
        confirm($query);

        set_message("Area aggiunta correttamente", "alert-success");
        redirect("../../public/admin/index.php?areas");

    }

}

// ritorna la lista delle aree di intervento
function get_areas() {

$query = query("SELECT * FROM aree");
confirm($query);

while($row = fetch_array($query)) {

$aree = <<<DELIMETER

<li class="list-group-item d-flex justify-content-between align-items-center">
    <p class="pr-5">{$row['area_name']}</p>
    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
        <a href="../../public/admin/index.php?edit_area&id={$row['area_id']}" role="button" class="btn btn-warning">Modifica</a>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAreaModal">Elimina</button>
    </div>
</li>
<div class="modal fade" role="dialog" id="deleteAreaModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Elimina area di intervento</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <p>Sei sicuro di voler eliminare l'area di intervento?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
            <a href="../../public/admin/index.php?delete_area&id={$row['area_id']}" role="button" class="btn btn-danger">Conferma eliminazione</a>
        </div>
        </div>
    </div>
</div>

DELIMETER;

echo $aree;
    
}

}

// modifica area di intervento
function update_area() {

    if(isset($_POST['update'])) {

        $name = escape_string($_POST['name_area']);
        $desc = escape_string($_POST['desc']);

        $query = query("UPDATE aree SET area_name = '{$name}', area_desc = '{$desc}' WHERE area_id = " . escape_string($_GET['id']) . " ");
        confirm($query);

        redirect("../../public/admin/index.php?areas");

    }

}

// aggiunge un articolo
function add_article() {

    if(isset($_POST['publish'])) {

        $autore = escape_string($_POST['autore']);
        $titolo = escape_string($_POST['titolo']);
        $desc = escape_string($_POST['desc']);
        $articolo = escape_string($_POST['articolo']);
        $foto = escape_string($_FILES['foto']['name']);
        $foto_loc = escape_string($_FILES['foto']['tmp_name']);

        move_uploaded_file($foto_loc, UPLOADS . DS . $foto);

        $query = query("INSERT INTO articoli(autore, titolo, short_desc, corpo, art_data, foto) VALUES ('{$autore}', '{$titolo}', '{$desc}', '{$articolo}', now(), '{$foto}') ");
        confirm($query);

        set_message("Articolo pubblicato correttamente", "alert-success");
        redirect("../../public/admin/index.php?articles");

    }
    
}

// ritorna lista di articoli
function get_articles() {

$query = query("SELECT * FROM articoli ORDER BY art_data DESC");
confirm($query);

while($row = fetch_array($query)) {

$img = display_image($row['foto']);
$data = preg_replace('/^(.{4})-(.{2})-(.{2})$/','$3-$2-$1', $row['art_data']);

$art_thumb = <<<DELIMETER

<div class="col-xs-6 col-md-3 mb-3">
    <div class="card" style="width: 18rem;">
        <a href="../../public/admin/index.php?edit_art&id={$row['art_id']}"><img src="../../resources/{$img}" class="card-img-top" alt=""></a>
        <div class="card-body">
            <h5 class="card-title">{$row['titolo']}</h5>
            <p class="card-text">{$row['short_desc']}</p>
            <p class="card-text"><small class="text-muted">{$data}</small></p>
        </div>
    </div>
</div>

DELIMETER;

echo $art_thumb;
    
}    

}

// modifica l'articolo
function update_art() {

    if(isset($_POST['update'])) {

        $autore = escape_string($_POST['autore']);
        $titolo = escape_string($_POST['titolo']);
        $desc = escape_string($_POST['desc']);
        $articolo = escape_string($_POST['articolo']);
        $foto = escape_string($_FILES['foto']['name']);
        $foto_loc = escape_string($_FILES['foto']['tmp_name']);

        if(empty($foto)) {

            $get_foto = query("SELECT foto FROM articoli WHERE art_id = " . escape_string($_GET['id']) . " ");
            confirm($get_foto);

            $result = fetch_array($get_foto);
            $foto = $result['foto'];

        }

        move_uploaded_file($foto_loc, UPLOADS . DS . $foto);

        $query = query("UPDATE articoli SET autore = '{$autore}', titolo = '{$titolo}', short_desc = '{$desc}', corpo = '{$articolo}', foto = '{$foto}' WHERE art_id = " . escape_string($_GET['id']) . " ");
        confirm($query);

        redirect("../../public/admin/index.php?articles");

    }

}

// modifica il profilo
function update_profile() {

    if(isset($_POST['update'])) {

        $desc = escape_string($_POST['desc']);
        $foto = escape_string($_FILES['foto']['name']);
        $foto_loc = escape_string($_FILES['foto']['tmp_name']);
        $cv = escape_string($_FILES['cv']['name']);
        $cv_loc = escape_string($_FILES['cv']['tmp_name']);

        if(empty($foto)) {

            $get_foto = query("SELECT pro_foto FROM profilo ORDER BY pro_id DESC LIMIT 1");
            confirm($get_foto);

            $result = fetch_array($get_foto);
            $foto = $result['pro_foto'];

        }

        if(empty($cv)) {

            $get_cv = query("SELECT pro_cv FROM profilo ORDER BY pro_id DESC LIMIT 1");
            confirm($get_cv);

            $result = fetch_array($get_cv);
            $cv = $result['pro_cv'];

        }

        move_uploaded_file($foto_loc, UPLOADS . DS . $foto);
        move_uploaded_file($cv_loc, UPLOADS . DS . $cv);

        $query = query("UPDATE profilo SET pro_desc = '{$desc}', pro_foto = '{$foto}', pro_cv = '{$cv}' ORDER BY pro_id DESC LIMIT 1");
        confirm($query);

        redirect("../../public/admin/index.php?profile");

    }

}


?>