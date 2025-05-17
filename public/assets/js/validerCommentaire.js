function validerCommentaire() {
    const pseudo = document.getElementById('pseudo').value.trim();
    const contenu = document.getElementById('contenu').value.trim();
    if (pseudo === "" || contenu === "") {
        alert("Veuillez remplir tous les champs.");
        return false;
    }
    return true;
}