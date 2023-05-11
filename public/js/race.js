$(document).ready( function () {
    var form = document.getElementById("annonce");
    
    // récupération de l'élément select pour l'espece'
    const especeSelect = document.getElementById('annonce_animal_espece');
    // écouteur d'événement sur le changement de la sélection de l'espece
    especeSelect.addEventListener('change', () => {
      const selectedEspeceId = especeSelect.value;
  
      // envoi de la requête AJAX pour récupérer les races associées à l'espèce sélectionnée
    fetch(`/espece/fetch/${selectedEspeceId}`)
        .then(response => response.json())
        .then(races => {
          // récupération de l'élément select pour les races
          const raceSelect = document.getElementById('annonce_animal_race');
  
          // suppression des options existantes
          raceSelect.innerHTML = '';
          
          // ajout des nouvelles options pour chaque race associée à l'espèce sélectionnée
          JSON.parse(races).forEach(race => {
            const option = document.createElement('option');
            option.value = race.id;
            option.textContent = race.nom;
            raceSelect.appendChild(option);
          });
        });
    });
});