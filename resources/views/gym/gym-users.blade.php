@extends('layouts.trainerLayout')
@section('content')
<div class="backLink mb-2">
  <a href="{{route('gym-index')}}">
      <i class="fas fa-chevron-left"></i><span>  Back</span>
  </a>
</div>
<div class="page-title">
    Current Gym Users Count: <span class="redIcon">10</span>
</div>
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
</table>
    @include('partials/profile/profile-modal')
@endsection