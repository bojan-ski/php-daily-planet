document.addEventListener('DOMContentLoaded', function () {
    const articlesContainer = document.querySelector('.articles-container');
    const loadMoreBtn = document.querySelector('.load-more-mtn');

    if (!articlesContainer || !loadMoreBtn) return;

    let offset = 12;

    loadMoreBtn.addEventListener('click', async function () {        
        try {
            let response = await fetch('/articles/loadMoreArticles', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'offset=' + offset
            });

            let data = await response.text();          

            articlesContainer.insertAdjacentHTML('beforeend', data);
            offset += 12;
        } catch (error) {
            console.error('Error loading more articles:', error);
        }
    });
});