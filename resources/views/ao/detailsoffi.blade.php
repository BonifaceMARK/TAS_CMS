<form method="POST" action="{{ route('officers.update', ['id' => $officer->id]) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="officerName" class="form-label">Apprehending Officer</label>
        <input type="text" class="form-control" id="officerName" name="officer"
            value="{{ old('officer', $officer->officer) }}">
    </div>

    <div class="mb-3">
        <label for="department" class="form-label">Department</label>
        <input type="text" class="form-control" id="department" name="department"
            list="departmentList" value="{{ old('department', $officer->department) }}">
        <datalist id="departmentList">
            <option value="CALAX">
            <option value="TPLEX">
            <option value="DO MMDA">
            <option value="DO-LES-FED">
            <option value="DO-NLEX">
            <option value="DO-STARTOLL">
            <option value="MCX">
            <option value="NLEX">
            <option value="PCG">
            <option value="SKYWAY">
            <option value="SLEX">
            <option value="STARTOLL">
            <option value="LES">
            <!-- Add more options as needed -->
        </datalist>
    </div>
    <button type="submit" class="btn btn-primary">Update Officer</button>
</form>