$(document).on('change', '.image-upload .form-group input[type=file]', function () {
    if (this.files && this.files[0]) {
        let reader = new FileReader();
        let preview = document.querySelector('.thumbnail');

        reader.onload = function () {
            let image = new Image();
            image.title = this.files[0].name;
            image.src = reader.result;

            let old_img = preview.querySelector('img');

            if (old_img !== null) {
                preview.removeChild(old_img);
            }

            preview.appendChild(image);
        }.bind(this);

        reader.readAsDataURL(this.files[0]);
    }
});