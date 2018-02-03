@extends('layouts.main')

@section('scripts')
	@parent
	<script type="text/javascript" src="{{ mix('js/pages/home.js') }}"></script>
@endsection

@section('content')
	<div class="container">
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
				@if($servers->count() > 0)
					<form method="POST" action="{{ route('post.deploy') }}" dialog="dialogFire">
						{{ csrf_field() }}

						<div class="mdl-grid">
							<h1 class="mdl-typography--headline">Deployer</h1>

							<div class="mdl-cell mdl-cell--12-col">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{$errors->has('server_id') ? 'is-invalid' : ''}}">
									<select name="server_id" class="mdl-textfield__input" id="select-server">
										<option
											disabled
											value="-1"
											{{ $selectedServer === -1 ? 'selected' : '' }}
										>
											Select a Server
										</option>

										@foreach ($servers as $server)
											<option
												value="{{ $server->id }}"
												{{ $server->id == $selectedServer ? 'selected': '' }}
											>
												{{ $server->name }}
											</option>
										@endforeach
									</select>

									<label class="mdl-textfield__label" for="server">Server</label>
								</div>

								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{$errors->has('task_id') ? 'is-invalid' : ''}}">
									<select name="task_id" class="mdl-textfield__input" id="select-task">
										<option
											disabled
											value="-1"
											{{ $selectedTask === -1 ? 'selected' : '' }}
										>
											Select a Task
										</option>

										@foreach ($tasks as $task)
											<option
												value="{{ $task->id }}"
												{{ $task->id == $selectedTask ? 'selected': '' }}
											>
												{{ $task->name }}
											</option>
										@endforeach
									</select>

									<label class="mdl-textfield__label" for="server">Task</label>
								</div>

								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{$errors->has('branch') ? 'is-invalid' : ''}}">
									<select name="branch" class="mdl-textfield__input" id="select-branch">
										<option
											disabled
											value="-1"
											{{ $selectedBranch === -1 ? 'selected' : '' }}
										>
											Select a Branch
										</option>

										@foreach ($branches as $branch)
											<option
												value="{{ $branch }}"
												{{ $branch == $selectedBranch ? 'selected': '' }}
											>
												{{ $branch }}
											</option>
										@endforeach
									</select>

									<label class="mdl-textfield__label" for="branch">Branch</label>
								</div>

								<div id="progress-bar">
									<div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
								</div>

								<button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="fire">Fire!</button>
							</div>
						</div>
					</form>
				@else
					<h3>Welcome </h3>
					@if($servers->count() < 1)
						<p> Please, first register a server clicking <a href="{{ route('server.create')}}">here.</a> </p>
					@endif
				@endif
			</div>
		</div>
	</div>
@endsection
