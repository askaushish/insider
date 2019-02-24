@extends('base')

@section('main')
<div class="col-sm-12">
</div>
<div class="row">
     
    <div class="col-sm-12">
        <h1 class="display-3">Teams</h1> 
        <div>
            <a style="margin: 19px;" href="{{ route('groups.create')}}" class="btn btn-primary">New Group</a>
        </div> 
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $team)
                <tr>
                    <td>{{$team->team_id}}</td>
                    <td>{{$team->team_name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
        </div>
        @endsection