const backBtn = document.querySelector('.back-btn');

if (backBtn) {
    backBtn.addEventListener('click', () => {
        history.go(-1);
    })
}