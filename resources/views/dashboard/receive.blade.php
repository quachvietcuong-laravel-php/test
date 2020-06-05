@include('dashboard.layouts.header')
    
	  <br>

	 <a href="{{ route('contracts.all') }}">Back to index</a>
	<div class="container">
  <h2>Contracts Receive</h2>           
  <table class="table table-condensed" style="text-align: center;">
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
    <thead>
      	<tr>
  		    <th>ID</th>
  		    <th>Name</th> 
  		    <th>Description</th>
  		    <th>Value</th>
  		    <th>User Name Share</th>
      	</tr>
    </thead>
    <tbody>
	  	@forelse($receive as $re)
		  	<tr>
			    <td>{{ $re->contracts->id }}</td>
			    <td>{{ $re->contracts->name }}</td>
			    <td>{{ $re->contracts->description }}</td>
			    <td>{{ $re->contracts->value }}</td>
			    <td>{{ $re->usersend->name }}</td>
		  	</tr>
		  @empty
  			<tr>
  				<td colspan="7" style="text-align: center;">Empty</td>
  			</tr>
		  @endforelse
    </tbody>
  </table>
  <dir style="text-align: center;">{{ $receive->links() }}</dir>
</div>
</body>
</html>
