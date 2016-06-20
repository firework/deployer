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
	<div class="container">
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
				@if($servers->count() > 0 && $tasks->count() > 0)
					<form method="POST" action="{{ route('deploy') }}" dialog="dialogFire">
						{{ csrf_field() }}

						<div class="mdl-grid">
							<h1 class="mdl-typography--headline">Deployer</h1>

							<div class="mdl-cell mdl-cell--12-col">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{$errors->has('server_id') ? 'is-invalid' : ''}}">
									<select name="server_id" class="mdl-textfield__input">
										<option disabled selected>Select a Server</option>

										@foreach ($servers as $server)
											<option value="{{ $server->id }}">{{ $server->name }}</option>
										@endforeach
									</select>

									<label class="mdl-textfield__label" for="server">Server</label>
								</div>

								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{$errors->has('task_id') ? 'is-invalid' : ''}}">
									<select name="task_id" class="mdl-textfield__input">
										<option disabled selected>Select a Task</option>

										@foreach ($tasks as $task)
											<option value="{{ $task->id }}">{{ $task->name }}</option>
										@endforeach
									</select>

									<label class="mdl-textfield__label" for="server">Task</label>
								</div>

								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{$errors->has('branch') ? 'is-invalid' : ''}}">
									<select name="branch" class="mdl-textfield__input">
										<option disabled selected>Select a Branch</option>

										@foreach ($branches as $branch)
											<option>{{ $branch }}</option>
										@endforeach
									</select>

									<label class="mdl-textfield__label" for="branch">Branch</label>
								</div>

								<button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="fire">Fire!</button>
							</div>
						</div>
					</form>
				@else
					<h3>Welcome </h3>
					@if($servers->count() < 1)
						<p> Please, first register a server clicking <a href="{{ route('server.create')}}">here.</a> </p>
					@elseif($tasks->count() < 1)
						<p> Please, first register a task clicking <a href="{{ route('task.create')}}">here</a>.</p>
					@endif
				@endif
			</div>
		</div>
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
