@if (session('success'))
    <strong>
        {{ session('success') }}
    </strong>
@endif

<form action="{{ url('store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <p>
        Upload File <input type="file" name="file_upload" />
    </p>
    <button type="submit" name="submit">Submit</button>
</form>