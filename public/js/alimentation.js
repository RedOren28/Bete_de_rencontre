// récupération de l'élément select pour le régime
const regimeSelect = document.getElementById('regime');

// écouteur d'événement sur le changement de la sélection du régime
regimeSelect.addEventListener('change', () => {
  const selectedRegimeId = regimeSelect.value;

  // envoi de la requête AJAX pour récupérer les alimentations associées au régime sélectionné
  fetch(`/annonce/create`)
    .then(response => response.json())
    .then(alimentations => {
      // récupération de l'élément select pour les alimentations
      const alimentationSelect = document.getElementById('alimentation');

      // suppression des options existantes
      alimentationSelect.innerHTML = '';

      // ajout des nouvelles options pour chaque alimentation associée au régime sélectionné
      alimentations.forEach(alimentation => {
        const option = document.createElement('option');
        option.value = alimentation.id;
        option.textContent = alimentation.nom;
        alimentationSelect.appendChild(option);
      });
    });
});
