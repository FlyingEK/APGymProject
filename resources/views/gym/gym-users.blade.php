@extends('layouts.trainerLayout')
@section('content')
<div class="backLink mb-2">
  <a href="{{route('gym-index')}}">
      <i class="fas fa-chevron-left"></i><span>  Back</span>
  </a>
</div>
<div class="page-title">
    Current Gym Users Count: <span class="redIcon">{{$currentUserCount}}</span>
</div>
<table class="table table-borderless bg-white">
    <tbody>
      <!-- Repeat this block for the first 10 users -->
      @forelse ($currentUsers as $user)
      <tr data-bs-toggle="modal" data-bs-target="#viewProfile" data-id={{$user->gymUser->user->user_id}}>
        <td class="player-info">
          <img class="leaderboardImg rounded-circle" src="{{ asset('storage/'.$user->gymUser->user->image) }}" alt="profile">
          {{ $user->gymUser->user->first_name }} {{ $user->gymUser->user->last_name }}
        </td>
        <td class="">{{$user->entered_at}}</td>
      @empty
      <tr>
        <td colspan="2">No users</td>
      </tr>
      @endforelse
    </tbody>
</table>
    @include('partials/profile/profile-modal')
@endsection

@push('script')
<script>
$(document).ready(function () {
  $('#viewProfile').on('shown.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var user_id = button.data('id');
      console.log('Document ready');

      $.ajax({
          url: '{{ route("profile-details") }}',
          type: 'GET',
          data: { id: user_id },
          success: function (response) {
              if (response.success){
                  var user = response.user;
                  const modal = $('#viewProfile');
                  displayDetails(user, modal);
              }
          },
          error: function(xhr, status, error) {
              console.error('Error fetching profile details:', error);
          }
      });
  });

  function displayDetails(user, modal) {
      modal.find('.username').text(user.username);
      if(user.image) {
          modal.find('.profileImg').attr('src', '{{ asset('storage') }}/' + user.image);
      }
      modal.find('.profileName').text(user.first_name + ' ' + user.last_name);

      var icon = '';
      if(user.gender && user.gender == 'male') {
          icon = '<i class="fas fa-mars" style="color: rgb(66, 170, 223);"></i>';
      } else if(user.gender && user.gender == 'female') {
          icon = '<i class="fas fa-venus" style="color: rgb(245, 89, 89);"></i>';
      }
      modal.find('.profileGender').html(icon);
  }
});
</script>
@endpush