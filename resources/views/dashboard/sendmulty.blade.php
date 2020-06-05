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
    <form  action="{{ route('contracts.postSendMulty') }}" method="POST">
        {{ csrf_field() }}
      
        <div class="form-group">
          <label for="exampleInputEmail1">Users name</label>
          <select name="id_users" class="form-control form-control-sm">
            @forelse($user as $us)
              <option value="{{ $us->id }}">{{ $us->name }}</option>
            @empty
              empty
            @endforelse
          </select>
        </div>
      

      <button type="submit" name="send" class="btn btn-primary">Send</button>
    </form>
</div>
</body>
</html>