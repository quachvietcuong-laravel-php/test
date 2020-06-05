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
    <form  action="{{ route('contracts.postShare' , ['id' => $contracts->id]) }}" method="POST">
        {{ csrf_field() }}
      <div>
        <label for="exampleInputEmail1">Name contracts</label>
        <input readonly="" type="text" name="name" placeholder="name_contracts" class="form-control" value="{{ $contracts->name }}">
        <input type="hidden" value="{{ $contracts->id }}" name="id_contracts">
      </div>

        @forelse($user as $us)
        <div class="form-check form-check-inline" style="margin: 10px 0 10px 0;">
          <input class="form-check-input" type="checkbox" name="checked[]"  value="{{ $us->id }}">
          <label class="form-check-label" >{{ $us->name }}</label>
        </div>
        @empty
          empty
        @endforelse
      <br>

      <button type="submit" name="share" class="btn btn-primary">Share</button>
    </form>
</div>
</body>
</html>