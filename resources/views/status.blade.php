@extends('layouts.main')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <table class="mdl-data-table mdl-js-data-table w100">
                <thead>
                    <tr>
                        <th class="mdl-data-table__cell--non-numeric">Server</th>
                        <th class="mdl-data-table__cell--non-numeric">Branch</th>
                        <th class="mdl-data-table__cell--non-numeric">Started</th>
                        <th class="mdl-data-table__cell--non-numeric">Finished</th>
                        <th class="mdl-data-table__cell--non-numeric">Output</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deploys as $deploy)
                        <tr>
                            <td class="mdl-data-table__cell--non-numeric">{{ $deploy->server ? $deploy->server->name : $deploy->serverWithTrashed->name }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ $deploy->branch }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ $deploy->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ $deploy->updated_at->format('d/m/Y H:i:s') }}</td>
                            <td class="mdl-data-table__cell--non-numeric">
                                @if(! $deploy->outputs->isEmpty())
                                    <div class="code">
                                        @foreach ($deploy->outputs as $output)
                                            {!! nl2br($output->output) !!}
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- @foreach ($deploys as $deploy)
        <div class="deploy">
        <b>Deploy {{$deploy->server}}</b> -  <b>Branch:</b> {{$deploy->branch}} -  <b>Started</b> {{$deploy->created_at->format('d/m/Y H:i:s')}} - <b>Finished</b> {{$deploy->updated_at->format('d/m/Y H:i:s')}}
    </div>
    <div style="text-align: left; border: 1px solid #CCC;">
    @foreach ($deploy->outputs as $output)
    <div>{!! nl2br($output->output) !!}</div>
@endforeach
</div>
@endforeach --}}
</div>
@endsection
