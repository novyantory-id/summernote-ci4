<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

<!-- CDN Summernote CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css">

    <style>
        /* fix dropdown icon */
        .note-editor .dropdown-toggle::after {
            all: unset;
        }

        .note-editor .note-dropdown-menu {
            box-sizing: content-box;
        }

        .note-editor .note-modal-footer {
            box-sizing: content-box;
        }
    </style>
</head>

<body>
    <textarea name="" id="summernote" cols="30" rows="10"></textarea>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- CDN Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Hello stand alone ui',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],

                callbacks: {
                    onImageUpload: function(files) {
                        uploadImages(files);
                    },
			onMediaDelete: function(target) {
                        $.delete(target[0].src);
                    }
                }
            });

        });

        function uploadImages(files) {
            var formData = new FormData();
            $.each(files, function(i, file) {
                formData.append('images[]', file);
            });
            $.ajax({
                url: '<?= base_url('upload-images') ?> ',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $.each(response.images, function(i, imageUrl) {
                        $('#summernote').summernote('insertImage', imageUrl);
                    });
                }
            });
        }

	$.delete = function(imageUrl) {
            $.ajax({
                url: '<?= base_url('delete-gambar') ?>',
                type: 'POST',
                data: {
                    imageUrl: imageUrl
                },
                success: function(response) {
                    console.log('Image deleted:', response);
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting image', error);
                }
            });
        }
    </script>
</body>

</html>
