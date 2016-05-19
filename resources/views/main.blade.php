@extends('layout')

@section('content')
	<form method="POST" action="deploy">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div>
            <label>Select a server:</label>
            <select name="server">
                @foreach ($servers as $server)
                    <option>{{ $server }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Select a branch:</label>
            <select name="branch">
                @foreach ($branches as $branch)
                    <option>{{ $branch }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-danger">Fire!</button>
    </form>
@endsection
