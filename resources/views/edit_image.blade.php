<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Image Update</title>
</head>

<body>
  <form action="{{ route('image.update', $image->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <img src="{{ asset('/storage/' . $image->image) }}" height="200" width="200" alt="{{ $image->image }}"
      id="image">
    <input type="file" name="image"
      onchange="document.querySelector('#image').src = window.URL.createObjectURL(this.files[0])">
    <input type="submit" value="Update">
  </form>

</body>

</html>
