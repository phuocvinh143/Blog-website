<html>

<head>
  <title>Test</title>
  <meta charset="UTF-8" />
  <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">
  <!-- <link href="styles/style.css" rel="stylesheet"> -->
  <script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <form method="post" id="identifier" class="form-group">

    <div id="quillArea"></div>

    <textarea name="text" style="display:none" id="hiddenArea"></textarea>
    <input type="submit" value="Save" name="post_content"/>

  </form>
  <script>
    var quill = new Quill('#quillArea', {
            placeholder: 'Enter Detail',
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }]
                ]
            }
        });
    $("#identifier").on("submit",function(){
      $("#hiddenArea").val($("#quillArea").html());
    });
  </script>

</body>

</html>