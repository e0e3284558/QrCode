<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<H1>上传Excel批量转成IMG</H1>
<form action="ex"  method="post"  enctype="multipart/form-data" >
    {{csrf_field()}}
    <input type="file"  name="fileUpload" value="">
    <input type="submit" value="上传文件">
</form>
</body>
</html>