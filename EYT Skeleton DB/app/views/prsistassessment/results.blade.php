

@extends('layout')

@section('content')

<input type="hidden" name="game" value="prsistassessment" />

<div class="well">
    <div class="row">
        <div class="col-sm-3">
            <label>Test Name:</label>
            <select id="test_name">
                <option value="all">All Tests</option>
                @foreach ($tests as $key => $test)
                <option {{{ ($test_name == $test->test_name) ? "selected" : "" }}} value="{{ $key }}">{{ $test->test_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3">
            <label>Date From:</label>
            <input type="text" id="date_start" placeholder="dd/mm/yyyy" value="{{{ $start or '' }}}" />
        </div>
        <div class="col-sm-3">
            <label>Date To:</label>
            <input type="text" id="date_end" placeholder="dd/mm/yyyy" value="{{{ $end or '' }}}" />
        </div>
        <div class="col-sm-3">
            <a class="btn btn-primary" id="btnPrsistAssessmentFilter">Submit</a>
        </div>
    </div>
</div>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th colspan="2"><a class="btn btn-warning btn-xs btn-block" id="btnPrsistAssessmentCSV">CSV</a></th>
        <th><a href="?order=test_name">Study Name</a></th>
        <th><a href="?order=game_type">Game Type</a></th>
        <th><a href="?order=assessor_name">Assessor</a></th>
        <th><a href="?order=child_id">Child ID</a></th>
        <th><a href="?order=session_id">Session ID</a></th>
        <th><a href="?order=room">Room</a></th>
        <th><a href="?order=dob">DOB</a></th>
        <th><a href="?order=age">Age</a></th>
        <th><a href="?order=sex">Sex</a></th>
        <!-- <th><a href="?order=score">Score</a></th> -->
        <th><a href="?order=played_at">Played At</a></th>
        <th class="text-center"><i class="glyphicon glyphicon-trash"></i></th>
        <th class="text-center">
            <a id="btnDeleteGames" class="btn btn-danger btn-block btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php $lastID = 0; ?>
    @foreach ($games as $game)
        <tr id="row{{ $game->id }}">
            <td><a class="btn btn-info btn-sm" href="/prsistassessment/game/{{ $game->id }}">View Scores</a></td>
            <td><button class="btnViewGame btn btn-primary btn-xs" data-game_id="{{$game->id}}" data-game_type="prsistassessment"><i class="glyphicon glyphicon-info-sign"></i></button></td>
            <td>{{{ empty($game->test_name) ? '.' : $game->test_name }}}</td>
            <td>{{{ empty($game->game_type) ? '.' : $game->game_type }}}</td>
            <td>{{{ empty($game->assessor_name) ? '.' : $game->assessor_name }}}</td>
            <td>{{{ empty($game->child_id) ? '.' : $game->child_id }}}</td>
            <td>{{{ empty($game->session_id) ? '.' : $game->session_id }}}</td>
            <td>{{{ empty($game->room) ? '.' : $game->room }}}</td>
            <td>
                @if ($game->dob == "")
                .
                @else
                {{ date("d/m/Y",strtotime($game->dob)) }}
                @endif
            </td>
            <td>{{ $game->age }}</td>
            <td>
                @if ($game->sex == 0)
                .
                @else
                    {{ ($game->sex == 1) ? "Male" : "Female" }}
                @endif
            </td>
            <!-- <td>{{ $game->score }}</td> -->
            <td>{{ date("h:i A, d/m/Y",strtotime($game->played_at)) }}</td>
            <td class="text-center"><a class="btn btn-danger btn-xs btnDeleteGame" data-last_id="{{ $lastID }}" data-game_id="{{ $game->id }}" data-game_type="prsistassessment" data-confirm="0"><i class="glyphicon glyphicon-trash"></i></a></td>
            <td class="text-center"><input class="deleteGames" type="checkbox" data-game_id="{{ $game->id }}"></td>
            <?php $lastID = $game->id; ?>
        </tr>
    @endforeach
    </tbody>
</table>

@stop