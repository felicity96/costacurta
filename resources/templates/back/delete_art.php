<?php

    if(isset($_GET['id']) && isset($_GET['img'])) {

        $query = query("DELETE FROM articoli WHERE art_id = '{$_GET['id']}' ");
        confirm($query);

        $img_path = UPLOADS . DS . $_GET['img'];
        unlink($img_path);

        set_message("Articolo eliminato con successo", "alert-success");
        redirect("../../public/admin/index.php?articles");

    }
    else {

        redirect("../../public/admin/index.php?articles");

    }

?>