@extends('base')

@section('main')
<div class="col-sm-12">
</div>
<div class="row">
     
    <div class="col-sm-12">
        <h1 class="display-3">Group Fixtures</h1> 
         
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Teams</td>
                    <td>Round</td>
                    <td>Result</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach($matches as $match)
                <tr>
                    <td>{{$match->match_id}}</td>
                    <td><a >{{$match->first_team}} vs {{$match->second_team}}</a></td>
                    <td>{{$match->round_number}}</td>
                    <td>{{$match->status}}</td>
                    <td><a href="{{ route('scores.create')}}">Start Match</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
        </div>
        @endsection