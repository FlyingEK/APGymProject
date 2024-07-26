<div>
    <div class="row">
        <div class="col-6">
            <div class="dropdown">
                <button class="report-filter redIcon border-none dropdown-toggle" style="border:none; background:transparent;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter redIcon"></i><span class="redIcon">  Set Filter</span>
                </button>
                <ul class="dropdown-menu boardFilter">
                    <li><button class="dropdown-item {{ $filter === 'hour' ? 'activeTab' : '' }}" id="hour" wire:click="setFilter('hour')">Total Workout Hours</button></li>
                    <li><button class="dropdown-item {{ $filter === 'weight' ? 'activeTab' : '' }}" id="maxWeight">Maximum Weight</button></li>
                </ul>
            </div>
        </div>
        <div wire:ignore id="equipmentSelect" class="d-none col-6"> 
            {{-- //wire:model="equipmentId" wire:change="setEquipment($event.target.value)" --}}
            <select class="select2 form-control form-select mb-3"  name="equipment_id" id="equipment_id">
                <option value="" data-has-weight="0" selected>Choose an equipment...</option>
                @foreach($allEquipments as $equip)
                    <option value="{{ $equip->equipment_id }}" data-has-weight="{{ $equip->has_weight }}" {{$equipmentId == $equip->equipment_id? "selected":""}}>{{ $equip->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="my-3">
        <div class="pgtabs pgtab2 btn-group btn-group-sm" id="report-tab">
            <button wire:click="setPeriod('daily')" class="btn text-white {{ $period === 'daily' ? 'activeTab' : '' }}">Daily</button>
            <button wire:click="setPeriod('overall')" class="btn text-white {{ $period === 'overall' ? 'activeTab' : '' }} ">Overall</button>
        </div>
    </div>

    <div class="leaderboardcontainer inter mt-4">
        <div class="row text-center mb-4 align-items-end">
            <div class="col-4 blackCol">
                <div class="leader smaller">
                    <img data-bs-toggle="modal" data-bs-target="#viewProfile" 
                    data-id="{{ isset($topOverall[1]['gym_user']['user']['user_id']) ? $topOverall[1]['gym_user']['user']['user_id'] : '' }}"
                    class="leaderboardImg rounded-circle" src="{{ isset($topOverall[1]) && isset($topOverall[1]['gym_user']['user']['image']) ? asset('storage/' . $topOverall[1]['gym_user']['user']['image']) : asset('/img/user.jpg') }}">
                    <div class="crown bronze" style="background-image: url('{{ asset('/img/crown.png') }}');"></div>
                    <div class="leader-name">{{isset($topOverall[1])&& $topOverall[1]['gym_user']['user']['username']?$topOverall[1]['gym_user']['user']['username']:"-"}}</div>
                    <div class="leader-score">
                        @if(!isset($topOverall[1]))
                        N/A
                        @endif
                        @isset($topOverall[1]['max_weight'])
                        {{$topOverall[1]['max_weight']}}kg
                        @endisset
                        @isset($topOverall[1]['total_duration'])
                        {{$topOverall[1]['total_duration']}} hour{{$topOverall[1]['total_duration']>1?'s':''}}
                        @endisset
                    </div>
                </div>
            </div>
            <div class="col-4 redCol">
                <div class="leader firstPlace">
                    <img data-bs-toggle="modal" data-bs-target="#viewProfile" 
                    data-id="{{isset($topOverall[0])&& $topOverall[0]['gym_user']['user']['user_id']?$topOverall[0]['gym_user']['user']['user_id']:""}} "
                    class="leaderboardImg rounded-circle" src="{{ isset($topOverall[0]) && isset($topOverall[0]['gym_user']['user']['image']) ? asset('storage/' . $topOverall[0]['gym_user']['user']['image']) : asset('/img/user.jpg') }}">
                    <div class="crown gold" style="background-image: url('{{ asset('/img/crown.png') }}');"></div>
                    <div class="leader-name">{{isset($topOverall[0])&& $topOverall[0]['gym_user']['user']['username']?$topOverall[0]['gym_user']['user']['username']:"-"}}</div>
                    <div class="leader-score">
                        @if(!isset($topOverall[0]))
                        N/A
                        @endif
                        @isset($topOverall[0]['max_weight'])
                        {{$topOverall[0]['max_weight']}}kg
                        @endisset
                        @isset($topOverall[0]['total_duration'])
                        {{$topOverall[0]['total_duration']}} hour{{$topOverall[0]['total_duration']>1?'s':''}}
                        @endisset
                    </div>
                </div>
            </div>
            <div class="col-4 blackCol">
                <div class="leader smaller">
                    <img data-bs-toggle="modal" data-bs-target="#viewProfile" 
                    data-id="{{isset($topOverall[2])&& $topOverall[2]['gym_user']['user']['user_id']?$topOverall[2]['gym_user']['user']['user_id']:""}}"
                    class="leaderboardImg rounded-circle" src="{{ isset($topOverall[2]) && isset($topOverall[2]['gym_user']['user']['image']) ? asset('storage/' . $topOverall[2]['gym_user']['user']['image']) : asset('/img/user.jpg') }}">
                    <div class="crown silver" style="background-image: url('{{ asset('/img/crown.png') }}');"></div>
                    <div class="leader-name">{{isset($topOverall[2])&& $topOverall[2]['gym_user']['user']['username']?$topOverall[2]['gym_user']['user']['username']:"-"}}</div>
                    <div class="leader-score">                        
                        @if(!isset($topOverall[2]))
                        N/A
                        @endif
                        @isset($topOverall[2]['max_weight'])
                        {{$topOverall[2]['max_weight']}}kg
                        @endisset
                        @isset($topOverall[2]['total_duration'])
                        {{$topOverall[2]['total_duration']}} hour{{$topOverall[2]['total_duration']>1?'s':''}}
                        @endisset
                    </div>
                </div>
            </div>
        </div>

        <div class="leaderboard-container mt-3">
            <table class="table table-borderless">
                <tbody>
                    <!-- Repeat this block for the first 10 users -->
                    @forelse($restOverall as $index => $leader)
                        <tr data-bs-toggle="modal" data-bs-target="#viewProfile" data-id= "{{ $leader->gym_user->user->user_id}}">
                            <td class="rank">{{ $index + 4 }}</td>
                            <td class="player-info">
                                <img class="leaderboardImg rounded-circle" src="https://cdn-icons-png.flaticon.com/512/186/186037.png" alt="Sebastian">
                                {{ $leader->gym_user->user->name }}
                            </td>
                            <td class="score">{{ $leader->result }}</td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan=3 class="text-center"> No user yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <table class="table inter table-borderless highlighted-player">
        <tr>
            @php
            // if($currentUserOverallPosition->isNotEmpty()){
            //     $position = $currentUserOverallPosition
            // }else if($currentUserDailyPosition no empty){

            // }else{
            //     $position="N/A";
            // }
            $name = $currentUser->username;
            $position = 'N/A';
            $result = '-';
            if(isset($currentUserOverall ) && !empty($currentUserOverall )){
                $position = $currentUserOverallPosition;
                $result = isset($currentUserOverall->max_weight)?$currentUserOverall->max_weight:$currentUserOverall->total_duration;
            } elseif(isset($currentUserDaily ) && !empty($currentUserDaily )){
                $position = $currentUserDailyPosition;
                $result = isset($currentUserDaily->max_weight)?$currentUserDaily->max_weight:$currentUserDaily->total_duration;
            } 
            @endphp

            <td class="rank">{{$position}}</td>
            <td class="player-info">
                <img class="leaderboardImg rounded-circle" src="https://cdn-icons-png.flaticon.com/512/186/186037.png" alt="Username">
                {{$name }}(You)
            </td>
            <td class="score">{{$result}}</td>
        </tr>
    </table>

    @include('partials.profile.profile-modal')

    <script>
// document.addEventListener('livewire:load', function () {
//         Livewire.hook('message.processed', (message, component) => {
//             $('#equipment_id').select2({
//                 placeholder: 'Choose an equipment...'
//             });
//         });
//     });
    $(document).ready(function() {
        $('#equipment_id').select2();
        $('#equipment_id').on('change', function (e) {
            var data = $('#equipment_id').select2("val");
            @this.setEquipment(data);
        });
    });

            $('#maxWeight').on('click', function() {
                $('#equipmentSelect').removeClass('d-none');
                $('#equipmentSelect').addClass('d-flex');
                $('#equipmentSelect').addClass('justify-content-end');
            });

            $('#hour').on('click', function() {
                $('#equipmentSelect').addClass('d-none');
                $('#equipmentSelect').removeClass('d-flex');
                $('#equipmentSelect').removeClass('justify-content-end');
            });

            
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
                  var achievement = response.achievement;
                  console.log(achievement);
                  const modal = $('#viewProfile');
                  displayDetails(user, achievement, modal);
              }
          },
          error: function(xhr, status, error) {
              console.error('Error fetching profile details:', error);
          }
      });
  });

  function displayDetails(user, achievement, modal) {
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
      modal.find('.badgeModal').empty();
      for (let i = 0; i < achievement.length; i++) {
          modal.find('.badgeModal').append('<img src="{{ asset('storage') }}/' + achievement[i].achievement.image + '" class="badgeImg" alt="Warrior Badge" data-toggle="tooltip" data-placement="bottom" title="' + achievement[i].achievement.condition + '">');
      }
  }
});


    </script>


</div>
