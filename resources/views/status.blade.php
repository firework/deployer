@extends('layout')

@section('content')
    <div>
        @foreach ($deploys as $deploy)
            <div class="deploy"><b>Deploy {{$deploy->server}}</b> -  <b>Branch:</b> {{$deploy->branch}} -  <b>Started</b> {{$deploy->created_at->format('d/m/Y H:i:s')}} - <b>Finished</b> {{$deploy->updated_at->format('d/m/Y H:i:s')}} </div>
            <div style="text-align: left; border: 1px solid #CCC;">
                @foreach ($deploy->outputs as $output)
                    <div>{!! nl2br($output->output) !!}</div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection