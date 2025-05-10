document.addEventListener('DOMContentLoaded', function() {
  const contactForm = document.getElementById('contact-form');
  
  if (contactForm) {
    // Chercher ou créer l'élément pour les réponses
    let formResponse = document.querySelector('.form-response');
    
    if (!formResponse) {
      // Créer l'élément s'il n'existe pas encore
      formResponse = document.createElement('div');
      formResponse.className = 'form-response';
      formResponse.style.display = 'none';
      
      // Insérer l'élément au début du formulaire
      contactForm.parentNode.insertBefore(formResponse, contactForm);
    }
    
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Désactiver le bouton pendant le traitement
      const submitButton = this.querySelector('button[type="submit"]');
      submitButton.disabled = true;
      submitButton.innerHTML = 'Envoi en cours...';
      
      // Récupérer les données du formulaire
      const formData = new FormData(this);
      formData.append('action', 'contact_form_submit');
      
      // Envoyer la requête AJAX
      fetch(ajaxurl || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        // Afficher le message de réponse
        formResponse.style.display = 'block';
        formResponse.className = 'form-response ' + (data.success ? 'success' : 'error');
        formResponse.textContent = data.message;
        
        // Réinitialiser le formulaire si envoi réussi
        if (data.success) {
          contactForm.reset();
        }
        
        // Réactiver le bouton
        submitButton.disabled = false;
        submitButton.innerHTML = 'Envoyer';
      })
      .catch(error => {
        console.error('Erreur:', error);
        
        // Afficher un message d'erreur générique
        if (formResponse) {
          formResponse.style.display = 'block';
          formResponse.className = 'form-response error';
          formResponse.textContent = 'Une erreur est survenue. Veuillez réessayer.';
        }
        
        // Réactiver le bouton
        submitButton.disabled = false;
        submitButton.innerHTML = 'Envoyer';
      });
    });
  }
});