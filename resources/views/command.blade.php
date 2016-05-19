@extends('layout')

@section('content')
    <form method="POST" action="save_command">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div>
            <p><label>Deployment commands:</label></p>
            <textarea name="command" style="width:500px; height:300px">{{$commands}}</textarea>
        </div>                    
        <button type="submit">Save</button>
    </form>
@endsection