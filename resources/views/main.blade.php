@extends('layouts.main')

@section('scripts')
	@parent

	<script type="text/javascript">
		var dialog = document.querySelector('dialog'),
			showDialogButton = document.querySelector('#fire'),
			formDeploy = document.querySelector('form');

		if (! dialog.showModal) {
		  dialogPolyfill.registerDialog(dialog);
		}

		showDialogButton.addEventListener('click', function() {
		  dialog.showModal();
		});

		dialog.querySelector('.close').addEventListener('click', function() {
		  dialog.close();
		});

		dialog.querySelector('.accept').addEventListener('click', function() {
		  formDeploy.submit();
		});
	</script>
	
@endsection

@section('content')
	<div class="mdl-grid">
		<div class="mdl-layout-spacer"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<h1 class="mdl-typography--headline">Deployer</h1>
			@if($servers->count() > 0)

				@if (count($errors) > 0)
	                <div class="alert alert-danger">
	                    <ul>
							@if($errors->has('server_id'))
								<li>Please, select a server</li>
							@elseif($errors->has('branch'))
								<li>Please, select a branch</li>
							@endif
	                    </ul>
	                </div>
	            @endif

				<form method="POST" action="{{ route('deploy') }}" dialog="dialogFire">
					{{ csrf_field() }}

					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width">
						<select name="server_id" class="mdl-textfield__input">
							<option disabled selected>Select a Server</option>

							@foreach ($servers as $server)
								<option value="{{ $server->id }}">{{ $server->name }}</option>
							@endforeach
						</select>

						<label class="mdl-textfield__label" for="server">Server</label>


					</div>

					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width">
						<select name="branch" class="mdl-textfield__input">
							<option disabled selected>Select a Branch</option>

							@foreach ($branches as $branch)
								<option>{{ $branch }}</option>
							@endforeach
						</select>

						<label class="mdl-textfield__label" for="branch">Branch</label>
					</div>

					<button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="fire">Fire!</button>
				</form>

			@else
				<h3>Welcome </h3>
				<p> Please, first register a server clicking <a href="{{ route('server.create')}}">here</a> </p>
			@endif
		</div>
		<div class="mdl-layout-spacer"></div>
	</div>
@endsection

@section('body')
	<dialog class="mdl-dialog">
		{{-- <h4 class="mdl-dialog__title">Are you sure?</h4> --}}

		<div class="mdl-dialog__content">
			<p>Are you sure?</p>
		</div>

		<div class="mdl-dialog__actions">
			<button type="button" class="mdl-button accept">Yes</button>
			<button type="button" class="mdl-button close">Cancel</button>
		</div>
	</dialog>
@endsection
