document.getElementById('btn_voir_commentaire').addEventListener('click', function() {
    const commentaireSection = document.getElementById('commentaire');
    commentaireSection.classList.toggle('hidden'); // Ajoute ou retire la classe 'hidden'
});