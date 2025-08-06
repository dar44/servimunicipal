document.addEventListener("DOMContentLoaded", () => {
    const imageInput = document.getElementById("image");
    const newImagePreview = document.getElementById("newImagePreview");
    const previewImage = document.getElementById("previewImage");
    const existingImagePreview = document.getElementById(
        "existingImagePreview"
    );

    imageInput.addEventListener("change", function (e) {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = (e) => {
                newImagePreview.classList.remove("d-none");
                previewImage.src = e.target.result;

                if (existingImagePreview) {
                    existingImagePreview.style.display = "none";
                }
            };

            reader.readAsDataURL(file);
        } else {
            newImagePreview.classList.add("d-none");
            if (existingImagePreview) {
                existingImagePreview.style.display = "block";
            }
        }
    });

    const restoreState = () => {
        if (existingImageUrl && !imageInput.files.length) {
            existingImagePreview.style.display = "block";
            newImagePreview.classList.add("d-none");
        }
    };

    restoreState();
});
