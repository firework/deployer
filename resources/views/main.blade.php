@extends('layouts.main')

@section('content')
	<div class="mdl-grid">
		<div class="mdl-layout-spacer"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<h1 class="mdl-typography--headline">Deployer</h1>

			@if($servers->count() > 0)
				<form method="POST" action="{{ route('deploy') }}">
					{{ csrf_field() }}

					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width">
						<select name="server_id" class="mdl-textfield__input">
							@foreach ($servers as $server)
								<option value="{{ $server->id }}">{{ $server->name }}</option>
							@endforeach
						</select>

						<label class="mdl-textfield__label" for="server">Select a server</label>
					</div>

					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width">
						<select name="branch" class="mdl-textfield__input">
							@foreach ($branches as $branch)
								<option>{{ $branch }}</option>
							@endforeach
						</select>

						<label class="mdl-textfield__label" for="branch">Select a branch</label>
					</div>

					<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Fire!</button>
				</form>
			@else
				<h3>Welcome </h3>
				<p>
					Please, first register a server clicking <a href="{{ route('server.create')}}">here</a>.
				</p>
			@endif
		</div>
		<div class="mdl-layout-spacer"></div>
	</div>
@endsection
