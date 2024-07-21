<div class="modal fade" id="rejectIssueModal" tabindex="-1" aria-labelledby="rejectIssueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: white; border: none;">
            <div class="modal-header border-bottom-0">
                <div class="pagetitle">
                    <h1>{{$issue->title}}</h1>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 20px"></button>
            </div>
            <div class="modal-body border-0">
                <div class="form-container">
                    <form id="rejectModal" method="POST" action="{{ route('issue-status-update',$issue->issue_id) }}"  class="issueForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="rejected">
                        <div class="mb-3">
                            <input type="text" class="form-control p-2" id="comment" name="comment" placeholder="Reason of rejection" aria-label="Comment">
                        </div>

                        <div class="modal-footer">
                                <button type="submit" id="rejectBtn" class="btn midBtn redBtn">Reject</button>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
       $('#rejectBtn').on("click", function(e){
            e.preventDefault();
           swal.fire({
               title: 'Are you sure?',
               text: "You want to reject this issue!",
               icon: 'warning',
               showCancelButton: true,
               customClass: {
                   confirmButton: 'btn redBtn',
                   cancelButton: 'btn blueBtn'
               },
               confirmButtonText: 'Yes, Reject it!',
               cancelButtonText: 'No, keep it',
               reverseButtons: true
           }).then((result) => {
               if (result.isConfirmed) {
                   $('#rejectModal').submit();
               }
           });
       });
    });
</script>