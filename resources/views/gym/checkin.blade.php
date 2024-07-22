<div class="modal fade" id="checkInModal" tabindex="-1" aria-labelledby="checkInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: white; border: none;">
            <div class="modal-header border-bottom-0">
                <div class="pagetitle">
                    <h1>User Check In</h1>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 20px"></button>
            </div>
            <div class="modal-body border-0">
                <div class="form-container">
                    <form action="{{ route('gym-checkin-post') }}" method="POST">
                        @csrf
                        <label for="set" class="form-label"><strong>Check In Verification Code:</strong></label>
                        <input type="text" id="check_in_code" name="check_in_code" class="form-control p-2">
                        <div class="modal-footer">
                             <button type="submit" class="btn midBtn redBtn">Check In</button>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

