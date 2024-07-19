<div class="modal fade" id="viewProfile" tabindex="-1" aria-labelledby="viewProfileLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: white; border: none;">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 20px"></button>
            </div>
            <div class="modal-body border-0">
                <div class="d-flex justify-content-center profile-container flex-column align-items-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/186/186037.png" alt="Profile Picture" class="rounded-circle" style="width: 100px; height: 100px;">

                    <div style="font-size:20px;"><b>Username</b>&nbsp;<i class="fas fa-mars" style="color: rgb(66, 170, 223);"></i>
                    </div>
                    {{-- @if($user->gender)
                    @if($user->gender == 'male')
                        <i class="fas fa-mars" style="color: rgb(66, 170, 223);"></i>
                    @elseif($user->gender == 'female')
                        <i class="fas fa-venus" style="color: rgb(245, 89, 89);" ></i>
                    @endif
                    @endif --}}
                    <div style="color: gray;">tp020202@mail.apu.edu.my</div>
                    <div class="d-flex justify-content-center mt-2 badgeModal">
                        <img src="{{ asset('/img/champBadge1.png') }}" class="badgeImg" alt="Warrior Badge" data-toggle="tooltip" data-placement="bottom" title="Obtained first place once in monthly leaderboard">
                        <img src="{{ asset('/img/warriorBadge30.png') }}" class="badgeImg" alt="Champ Badge">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
