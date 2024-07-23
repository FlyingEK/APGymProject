<div class="modal fade" id="viewProfile" tabindex="-1" aria-labelledby="viewProfileLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: white; border: none;">
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title" id="viewProfileLabel">Profile</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 20px"></button>
            </div>
            <div class="modal-body border-0">
                <div class="d-flex justify-content-center profile-container flex-column align-items-center">
                    <img src="{{asset('/img/user.jpg') }}" alt="Profile Picture" class="rounded-circle profileImg" style="width: 100px; height: 100px;">

                    <div style="font-size:20px;"><b class="username"></b>&nbsp;<span class="profileGender"></span></div>
                    </div>
                    <div style="color: gray;font-size:18px;" class=" text-center profileName"></div>
                    <div class="d-flex justify-content-center mt-2 badgeModal">
                        <img src="{{ asset('/img/champBadge1.png') }}" class="badgeImg" alt="Warrior Badge" data-toggle="tooltip" data-placement="bottom" title="Obtained first place once in monthly leaderboard">
                        <img src="{{ asset('/img/warriorBadge30.png') }}" class="badgeImg" alt="Champ Badge">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
