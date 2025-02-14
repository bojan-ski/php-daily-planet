const toggleSectionVisibility = (checkbox, sectionClass) => {
    document.querySelector(sectionClass).classList.toggle('hidden', !checkbox.checked);
    document.querySelector(sectionClass).classList.toggle('block', checkbox.checked);
};

document.querySelector('.select-option-one').addEventListener('change', e => {
    toggleSectionVisibility(e.target, '.section_two');
});

document.querySelector('.select-option-two').addEventListener('change', e => {
    toggleSectionVisibility(e.target, '.section_three');
});
