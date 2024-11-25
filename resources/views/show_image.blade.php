<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>show image</title>
</head>

<body>
  @forelse ($images as $image)
    <div>
      <img src="{{ asset('/storage/' . $image->image) }}" alt="{{ $image->image }}" height="200" width="200">
      <a href="{{ route('image.edit', $image->id) }}">Update</a>
      <form action="{{ route('image.destroy', $image->id) }}" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete">
      </form>
    </div>
  @empty
    <div>No data found</div>
  @endforelse
</body>

</html>
