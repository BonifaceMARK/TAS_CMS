<div class="modal fade" id="finishModal{{ $tasFile->id }}" tabindex="-1" role="dialog" aria-labelledby="finishModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{ route('finish.case', ['id' => $tasFile->id]) }}" method="POST"> @csrf <div class="modal-header">
            <h5 class="modal-title" id="finishModalLabel">Finish Case</h5>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="fine_fee">Fine Fee</label>
              <input type="number" step="0.01" class="form-control" id="fine_fee" name="fine_fee" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Finish</button>
          </div>
        </form>
      </div>
    </div>
  </div>