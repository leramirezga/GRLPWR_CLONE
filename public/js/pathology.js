document.addEventListener('DOMContentLoaded', function () {
    const pathologyTrue = document.getElementById('pathology1');
    const pathologyFalse = document.getElementById('pathology2');

    pathologyTrue.addEventListener('change', function () {
        if (pathologyTrue.checked) {
            $("#pathology-description").show();
        }
    });

    pathologyFalse.addEventListener('change', function () {
        if (pathologyFalse.checked) {
            $("#pathology-description").hide();
        }
    });
});
