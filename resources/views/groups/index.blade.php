@extends('base')

@section('main')
<div class="col-sm-12">
</div>
<div class="row">
     @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div><br />
    @endif
    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}  
    </div>
    @endif
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
                    <td>{{$match->id}}</td>
                    <td><a href="{{ route('matches.show',$match->id)}}">{{$match->first_team}} vs {{$match->second_team}}</a></td>
                    <td>{{$match->round_number}}</td>
                    <td>{{$match->status}}</td>
                    <td><a href="{{ route('matches.edit',$match->id)}}">Start Match</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
        </div>
        @endsection