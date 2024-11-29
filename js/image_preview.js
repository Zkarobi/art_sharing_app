document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('image-preview');
    const resizeContainer = document.getElementById('resize-container');
    const widthInput = document.getElementById('resize-width');
    const heightInput = document.getElementById('resize-height');

    imageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                resizeContainer.style.display = 'block';
            };

            reader.readAsDataURL(file); // Convert the file to a data URL
        } else {
            preview.src = '';
            preview.style.display = 'none';
            resizeContainer.style.display = 'none';
        }
    });

    // Handle resizing inputs
    widthInput.addEventListener('input', function () {
        preview.style.width = `${widthInput.value}px`;
    });

    heightInput.addEventListener('input', function () {
        preview.style.height = `${heightInput.value}px`;
    });
});
