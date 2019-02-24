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
        <h1 class="display-3">{{$secondTeam}} Innings</h1> 

        <table class="table table-striped">
            <thead>
                <tr>
                    <td>Over</td>
                    <td>Batsman</td>
                    <td>Bowler</td>
                    <td>Runs</td>
                    <td>Score</td>
                </tr>
            </thead>
            <tbody>
                @foreach($secondInningsReords as $secondInningsReord)
                <tr>
                    <td>{{$secondInningsReord->over_number}}</td>
                    <td>{{$secondInningsReord->batsmen}}</td>
                    <td>{{$secondInningsReord->bowler}}</td>
                    <td>{{$secondInningsReord->runs_scored}}</td>
                    <td>{{$secondInningsReord->total_runs_till_this_over}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="col-sm-12">
        <h1 class="display-3">{{$firstTeam}} Innings</h1> 

        <table class="table table-striped">
            <thead>
                <tr>
                    <td>Over</td>
                    <td>Batsman</td>
                    <td>Bowler</td>
                    <td>Runs</td>
                    <td>Score</td>
                </tr>
            </thead>
            <tbody>
                @foreach($firstInningsReords as $firstInningsReord)
                <tr>
                    <td>{{$firstInningsReord->over_number}}</td>
                    <td>{{$firstInningsReord->batsmen}}</td>
                    <td>{{$firstInningsReord->bowler}}</td>
                    <td>{{$firstInningsReord->runs_scored}}</td>
                    <td>{{$firstInningsReord->total_runs_till_this_over}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection