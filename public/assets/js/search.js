const input = document.getElementById('championSearch');
const resultsContainer = document.getElementById('championResults');

input.addEventListener('keyup', function () {
    const query = this.value.toLowerCase();
    resultsContainer.innerHTML = '';

    if (query.length === 0) return;

    fetch(`app/controllers/search_champion.php?query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(champion => {
                const championItem = document.createElement('div');
                championItem.classList.add('champion-item');

                // Image du champion (grâce à la riot_key)
                const championImg = document.createElement('img');
                championImg.src = `https://ddragon.leagueoflegends.com/cdn/15.7.1/img/champion/${champion.riot_key}.png`;
                championImg.alt = champion.nom;

                // Nom du champion
                const championName = document.createElement('span');
                championName.textContent = champion.nom;

                // Assemble les éléments
                championItem.appendChild(championImg);
                championItem.appendChild(championName);

                // Au clic : remplir l’input et rediriger
                championItem.addEventListener('click', () => {
                    input.value = champion.nom;
                    resultsContainer.innerHTML = '';
                    window.location.href = `search_results.php?champion=${encodeURIComponent(champion.nom)}`;
                });

                resultsContainer.appendChild(championItem);
            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des champions depuis la base :', error);
        });
});

const searchForm = document.getElementById('searchForm');

searchForm.addEventListener('submit', function (e) {
    const query = input.value.trim();
    if (!query) {
        e.preventDefault();
        alert('Veuillez entrer un nom de champion avant de lancer la recherche.');
    }
});