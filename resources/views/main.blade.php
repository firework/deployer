@extends('layouts.main')

@section('content')
	<div class="mdl-grid">
		<div class="mdl-layout-spacer"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<form method="POST" action="deploy">
				{{ csrf_field() }}
				<h1 class="mdl-typography--headline">Deployer</h1>

				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width">
					<select name="server" class="mdl-textfield__input">
						@foreach ($servers as $server)
							<option>{{ $server }}</option>
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
		</div>
		<div class="mdl-layout-spacer"></div>
	</div>
@endsection
