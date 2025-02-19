const selectOptionOne = document.querySelector('.select-option-one');
const selectOptionTwo = document.querySelector('.select-option-two');

const toggleSectionVisibility = (checkbox, sectionClass) => {
    document.querySelector(sectionClass).classList.toggle('hidden', !checkbox.checked);
    document.querySelector(sectionClass).classList.toggle('block', checkbox.checked);
};

if (selectOptionOne) {
    selectOptionOne.addEventListener('change', e => {
        toggleSectionVisibility(e.target, '.section_two');
    });
}

if (selectOptionTwo) {
    selectOptionOne.addEventListener('change', e => {
        toggleSectionVisibility(e.target, '.section_three');
    });
}
