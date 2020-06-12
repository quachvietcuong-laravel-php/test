@include('dashboard.layouts.header')
    

    <a href="{{ route('contracts.all') }}">Back to index</a>
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(count($errors) > 0)
        <div class="alert alert-danger">
            @foreach($errors->all() as $err)
                {{ $err }} <br>
            @endforeach
        </div>
    @endif
    <form  action="{{ route('contracts.postEdit' , ['id' => $contracts['id']]) }}" method="POST">
        {{ csrf_field() }}
      <div>
        <label for="exampleInputEmail1">Name</label>
        <input type="text" name="name" placeholder="name" class="form-control" value="{{ $contracts->name }}">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">description</label>
        <input type="text" name="description" placeholder="description" class="form-control" value="{{ $contracts->name }}">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">value</label>
        <input type="text" name="value" placeholder="value" class="form-control" value="{{ $contracts->name }}">
      </div>
      <button type="submit" name="edit" class="btn btn-primary">Edit</button>
    </form>
</div>
</body>
</html>