function showDropdown(dropdownId) {
  var dropdown = document.getElementById(dropdownId);
  dropdown.classList.add("show");
}

function hideDropdown(dropdownId) {
  var dropdown = document.getElementById(dropdownId);
  dropdown.classList.remove("show");
}

var svg = document.querySelector(".connect-svg");
svg.addEventListener("mouseover", function() {
  var dropdown = document.getElementById("dropdownMenuButton2");
  dropdown.classList.add("show");
});

svg.addEventListener("mouseout", function() {
  var dropdown = document.getElementById("dropdownMenuButton2");
  dropdown.classList.remove("show");
});

function toggleForm() {
  var form = document.getElementById("nouveauServiceForm");
  if (form.style.display === "none") {
    form.style.display = "block";
  } else {
    form.style.display = "none";
  }
}

function openEditForm(id) {
  // Afficher la div de modification
  const editFormContainer = document.getElementById('editFormContainer');
  const editVoitureId = document.getElementById('editVoitureId');
  editFormContainer.style.display = 'block';
  editVoitureId.value = id;
  editFormContainer.scrollIntoView({ behavior: 'smooth' });
}

function afficherDescription(event) {
  // Récupérer la description du service à partir de l'attribut data-description
  const description = event.target.getAttribute('data-description');

  // Mettre à jour le contenu du modal avec la description du service
  const modalBody = event.target.closest('.modal-content').querySelector('.modal-body');
  modalBody.innerHTML = '<p>' + description + '</p>';
}

// Ajouter un gestionnaire d'événement à chaque bouton de service
const boutonsServices = document.querySelectorAll('.btn[data-bs-toggle="modal"]');
boutonsServices.forEach((bouton) => {
  bouton.addEventListener('click', afficherDescription);
});
