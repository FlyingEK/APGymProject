@extends('layouts.userLayout')
@section('content')
<table class="table table-borderless">
    <tbody>
      <!-- Repeat this block for the first 10 users -->
      @for ($i = 1; $i <= 20; $i++)
      <tr data-bs-toggle="modal" data-bs-target="#viewProfile">
        <td class="player-info">
          <img class="leaderboardImg rounded-circle" src="https://cdn-icons-png.flaticon.com/512/186/186037.png" alt="Sebastian">
          Sebastian
        </td>
        <td class="enterDate">Date time</td>
      </tr>
      @endfor
    </tbody>
@endsection