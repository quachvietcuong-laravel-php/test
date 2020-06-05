@include('dashboard.layouts.header')
    
	  <br>
	  <a href="{{ route('contracts.all') }}">Back to index</a>
	<div class="container">
  <h2>Contracts Share</h2>           
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
		    <th>Name contracts</th> 
		    <th>User receive</th>
		    <th>Method</th>
      	</tr>
    </thead>
    <tbody>
      	<form action="{{ route('contracts.postShareShow') }}" method="POST">
	  		{{ csrf_field() }}
	  		@if(count($share) > 0)
	  			<div>
		  			<input type="submit" class="btn btn-primary rsl" name="hidechose" value="Hide chose">
		  			<input type="submit" class="btn btn-primary rsl" name="showchose" value="Show chose">
	  			</div>
	  		@endif
		  	@forelse($share as $sh)
			  	<tr>
			  		<td><input type="checkbox" value="{{ $sh->id }}" name="checked[]"></td>
				    <td>{{ $sh->contracts->name }}</td>
				    <td>{{ $sh->userreceive->name }}</td>
				    <td>
				    	@if($sh->status == 0)
				    		<a class="btn btn-outline-danger" href="{{ route('contracts.getShareShowH' , ['id' => $sh->id]) }}">Hide contracts</a>
				    	@else
				    		<a class="btn btn-outline-success" href="{{ route('contracts.getShareShowS' , ['id' => $sh->id]) }}">Show contracts</a>
				    	@endif
				    </td>
			  	</tr>
			@empty
				<tr><td colspan="7" style="text-align: center;">Empty</td></tr>
			@endforelse
		</form>
    </tbody>
  </table>
  <div class="row" style="text-align: center;">{{ $share->links() }}</div>
</div>
</body>
</html>
