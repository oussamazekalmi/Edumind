function checkNone(){
    document.getElementById('create_user').checked = false;
    document.getElementById('create_user').disabled = true;

    document.getElementById('update_user').checked = false;
    document.getElementById('update_user').disabled = true;

    document.getElementById('delete_user').checked = false;
    document.getElementById('delete_user').disabled = true;
    let successMessage = document.getElementByClassName('text-danger');
        if (successMessage.length()) {
            successMessage.forEach(element => {
                successMessage.style.transition = 'opacity 0.5s ease';
                successMessage.style.opacity = '0';
            setTimeout(() => successMessage.remove(), 3000); // Supprime après l'animation
            });
        }
}

