<form action="/upload" method="POST" enctype="multipart/form-data">

    @csrf

    <input type="file" name="photo" id="photo">
     

     @if(isset($path))
        <img src="{{ asset('storage/' . $path) }}" width="300"  height="250">
    @endif
    <button type="submit">Upload</button>

</form>