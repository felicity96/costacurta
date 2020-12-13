function validatePassword() {

    var output = true;
    var currentPassword = document.updateForm.current_psw;
    var newPassword = document.updateForm.new_psw;
    var confirmPassword = document.updateForm.confirm_psw;

    if(!currentPassword.value) {
        currentPassword.focus();
        document.getElementById("current_psw_msg").innerHTML = "Inserisci la password attuale";
        output = false;
    }
    if(!newPassword.value) {
        newPassword.focus();
        document.getElementById("new_psw_msg").innerHTML = "Inserisci la nuova password";
        output = false;
    }
    if(!confirmPassword.value) {
        confirmPassword.focus();
        document.getElementById("confirm_psw_msg").innerHTML = "Conferma la nuova password";
        output = false;
    }

    if(newPassword.value != confirmPassword.value) {
        newPassword.value = "";
        confirmPassword.value = "";
        newPassword.focus();
        document.getElementById("confirm_psw_msg").innerHTML = "Le password non corrispondono";
        output = false;
    } 	

    return output;
}

function formReset(id) {
    document.getElementById(id).reset();
}