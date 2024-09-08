tinymce.init({
    selector:'.tinymce-default',
    height:500,
    plugins: [
        "code",
        "image",
        "table",
        "fullscreen",
        "preview",
        "searchreplace",
        "lists",
        "advlist"
    ],
    toolbar: "undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
    convert_urls: false,
});
 