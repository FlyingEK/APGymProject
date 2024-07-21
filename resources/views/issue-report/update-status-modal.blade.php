<div class="modal fade" id="updateIssueModal" tabindex="-1" aria-labelledby="updateIssueModalLabel" aria-hidden="true">
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
                    <form id="habitModal" action="{{ route('issue-status-update',$issue->issue_id) }}" method="POST" class="issueForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <select class="form-select select2 p-2 w-100" id="issueType" name="status" aria-label="Issue Type">
                                @if($issue->status == 'pending')
                                    <option value="reported" selected>Status: Reported</option>
                                @elseif($issue->status == 'reported')
                                    <option value="resolved" selected>Status: Resolved</option>
                                @endif
                            </select>
                            @error('status')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control p-2" id="comment" name="comment" placeholder="Add comment/reply" aria-label="Comment">
                        </div>

                        <div class="modal-footer">
                                <button type="submit" class="btn midBtn redBtn">Update</button>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
