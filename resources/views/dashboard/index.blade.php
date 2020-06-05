@include('dashboard.layouts.header')
    
	  <br>
	<div style="margin: 0 auto; text-align: center;" >
		<a class="btn btn-primary" href="{{ route('contracts.getAdd') }}">Add new</a>
		<a class="btn btn-primary" href="{{ route('contracts.getDelAll') }}">Delete all</a>
		<a class="btn btn-primary" href="{{ route('contracts.getReceive') }}">Receice contracts</a>
		<a class="btn btn-primary" href="{{ route('contracts.getShareShow') }}">Share contracts</a>
	</div>

	<div class="container">
  <h2>All Contracts</h2>           
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

    <script language="JavaScript">
		function toggle(source) {
			checkboxes = document.getElementsByName('checked[]');
			for(var i=0, n=checkboxes.length;i<n;i++) {
			    checkboxes[i].checked = source.checked;
			}
		}

		$(document).ready(function() {
		    var $submit = $(".rsl").hide(),
	        $cbs = $('input[name="checked[]"]').click(function() {
	            $submit.toggle( $cbs.is(":checked") );
	        });
	        $cba = $('input[name="all"]').click(function() {
	            $submit.toggle( $cba.is(":checked") );
	        }); 
		});
	</script>

    <thead>
      	<tr>
        	<th><input type="checkbox" name="all" onClick="toggle(this)" /> Checked All<br/></th>
		    <th>ID</th>
		    <th>Name</th> 
		    <th>Description</th>
		    <th>Value</th>
		    <th>User Name</th>
		    <th>Method</th>
      	</tr>
    </thead>
    <tbody>
      <form action="{{ route('contracts.postChose') }}" method="POST">
	  		{{ csrf_field() }}
	  		@if(count($contracts) > 0)
	  			<div>
		  			<input type="submit" class="btn btn-primary rsl" name="delchose" value="Del chose">
		  			<input type="submit" class="btn btn-primary rsl" name="sendchose" value="Send chose">
		  			<input type="submit" class="btn btn-primary rsl" name="sharechose" value="Share chose">
	  			</div>
	  		@endif
		  	@forelse($contracts as $ct)
			  	<tr>
			  		<td><input type="checkbox" value="{{ $ct->id }}" name="checked[]"></td>
				    <td>{{ $ct->id }}</td>
				    <td>{{ $ct->name }}</td>
				    <td>{{ $ct->description }}</td>
				    <td>{{ $ct->value }}</td>
				    <td>{{ $ct->user->name }}</td>
				    <td>
				    	<a class="btn btn-outline-primary" href="{{ route('contracts.getEdit' , ['id' => $ct->id]) }}">Edit</a>
				    	<a class="btn btn-outline-primary" href="{{ route('contracts.getDel' , ['id' => $ct->id]) }}"href="">Del</a>
				    	<a class="btn btn-outline-primary" href="{{ route('contracts.getSend' , ['id' => $ct->id]) }}">Send</a>
				    	<a class="btn btn-outline-primary" href="{{ route('contracts.getShare' , ['id' => $ct->id]) }}">Share</a>
				    </td>
			  	</tr>
			@empty
				<tr>
					<td colspan="7" style="text-align: center;">Empty</td>
				</tr>
			@endforelse
		</form>
    </tbody>
  </table>
  <div class="row" style="text-align: center;">{{ $contracts->links() }}</div>
</div>
</body>
</html>
