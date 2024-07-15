<div class="report-filter">
  <a href="#">
      <i class="material-symbols-outlined redIcon no-wrap">tune</i><span>  Total Workout Time(hours)</span>
  </a>
</div>
<div class=" my-3">
  <div class="pgtabs pgtab2 btn-group btn-group-sm" id="report-tab">
      <a href="#" class="btn " aria-current="page">Daily</a>
      <a href="#" class="btn activeTab">Monthly</a>
      <a href="#" class="btn  ">Annually</a>
  </div>
</div>
<div class="leaderboardcontainer inter mt-4">
    <div class="row text-center mb-4 align-items-end">
      <div class="col-4 blackCol">
        <div class="leader smaller">
          <img data-bs-toggle="modal" data-bs-target="#viewProfile" class="leaderboardImg rounded-circle" src="https://cdn-icons-png.flaticon.com/512/186/186037.png" alt="Jackson">
          <div class="crown bronze" style = "background-image: url('{{ asset('/img/crown.png') }}');"></div>
          <div class="leader-name">Jackson</div>
          <div class="leader-score">9.2</div>
        </div>
      </div>
      <div class="col-4 redCol">
        <div class="leader firstPlace">
          <img data-bs-toggle="modal" data-bs-target="#viewProfile" class="leaderboardImg rounded-circle" src="https://cdn-icons-png.flaticon.com/512/186/186037.png" alt="Eiden">
          <div class="crown gold" style = "background-image: url('{{ asset('/img/crown.png') }}');"></div>
          <div class="leader-name">Eiden</div>
          <div class="leader-score">10.0</div>
        </div>
      </div>
      <div class="col-4 blackCol">
        <div class="leader smaller">
          <img data-bs-toggle="modal" data-bs-target="#viewProfile" class="leaderboardImg rounded-circle" src="https://cdn-icons-png.flaticon.com/512/186/186037.png" alt="Emma Aria">
          <div class="crown silver" style = "background-image: url('{{ asset('/img/crown.png') }}');"></div>
          <div class="leader-name">Emma Aria</div>
          <div class="leader-score">9.0</div>
        </div>
      </div>
    </div>
    <div class="leaderboard-container mt-3">
      <table class="table table-borderless">
        <tbody>
          <!-- Repeat this block for the first 10 users -->
          @for ($i = 1; $i <= 20; $i++)
          <tr data-bs-toggle="modal" data-bs-target="#viewProfile">
            <td class="rank">{{ $i + 3 }}</td>
            <td class="player-info">
              <img class="leaderboardImg rounded-circle" src="https://cdn-icons-png.flaticon.com/512/186/186037.png" alt="Sebastian">
              Sebastian
            </td>
            <td class="score">8.0</td>
          </tr>
          @endfor
        </tbody>
      </table>
      
    </div>
    
  </div>
  <table class="table inter table-borderless highlighted-player" >
      <tr>
          <td class="rank">15</td>
          <td class="player-info">
              <img class="leaderboardImg rounded-circle" src="https://cdn-icons-png.flaticon.com/512/186/186037.png" alt="Username">
              Username (You)
          </td>
          <td class="score">5.8</td>
      </tr>
      
  </table>

  @include('partials.profile.profile-modal')

    
