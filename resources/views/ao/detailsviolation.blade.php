<form method="POST" action="{{ route('edit.violation', ['id' => $violation->id]) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="violationcode" class="form-label">Violation Code</label>
        <input type="text" class="form-control" id="violationcode" name="violationcode"
               value="{{ old('violationcode', $violation->code) }}">
    </div>
    <div class="mb-3">
        <label for="violationdesp" class="form-label">Violation Description</label>
        <input type="text" class="form-control" id="violationdesp" name="violationdesp"
               value="{{ old('violationdesp', $violation->violation) }}">
    </div>
    <button type="submit" class="btn btn-primary">Update Violation</button>
</form>