let offset = 0;
const articleList = document.getElementById('articleList');
const loadMoreBtn = document.getElementById('loadMore');

function loadArticles() {
    fetch(`app/models/load_articles.php?offset=${offset}`)
        .then(response => response.text())
        .then(data => {
        articleList.insertAdjacentHTML('beforeend', data);
        offset += 3;
        if ((data.match(/<article>/g) || []).length < 3) {
            loadMoreBtn.style.display = 'none';
        }
        })
        .catch(err => console.error('Erreur chargement articles :', err));
    }

loadMoreBtn.addEventListener('click', loadArticles);

// Charger les 3 premiers articles dès l’arrivée sur la page
window.addEventListener('DOMContentLoaded', loadArticles);
