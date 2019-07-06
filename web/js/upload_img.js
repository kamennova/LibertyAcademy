/* let imageTypes = ['jpeg', 'jpg', 'png'];

function showImage(src, target) {
    let fr = new FileReader();
    fr.onload = function (e) {
        target.src = this.result;
    };
    fr.readAsDataURL(src.files[0]);

}

let uploadImage = function (obj) {
    let val = obj.value;
    let lastInd = val.lastIndexOf('.');
    let ext = val.slice(lastInd + 1, val.length);
    if (imageTypes.indexOf(ext) !== -1) {
        let id = $(obj).data('target');
        let src = obj;
        let target = $(id)[0];
        showImage(src, target);
    }
    else {

    }
}; */

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