

@section('title', env('APP_NAME'))

@include('layouts.title')

<body>
    <style>
        /* Hide the spinner arrows for number input */
        input[type="number"] {
            -moz-appearance: textfield; /* Firefox */
        }
    
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .capitalize {
    text-transform: uppercase;
    }
    </style>
  <!-- ======= Header ======= -->
@include('layouts.header')

  <!-- ======= Sidebar ======= -->
 @include('layouts.sidebar')

  <main id="main" class="main">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif



<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Contest Case - Input</h5>
                    <!-- Form Start -->
                    <form method="POST" action="{{ route('submitForm.tas') }}" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6">
                            <label for="validationTooltipdate" class="form-label">Date Received</label>
                            <input type="date" name="date_received" class="form-control" id="validationTooltipdate" required>
                            <div class="invalid-tooltip">
                                Please input date.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationTooltipCaseno" class="form-label">Case no.</label>
                            <input type="number" name="case_no" class="form-control" id="validationTooltipCaseno" min="1" max="9999999" required>
                            <div class="invalid-tooltip">
                                Please enter a valid Case no. (Number only)
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationTooltipofficer" class="form-label">Apprehending Officer</label>
                            <input type="text" name="apprehending_officer" class="form-control" id="validationTooltipofficer" list="nameList" required autocomplete="off">
                            <div class="invalid-tooltip">
                                Please provide an Apprehending Officer.
                            </div>
                            <datalist id="nameList">
                                @foreach($officers as $officer)
                                    <option value="{{ $officer->officer }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-6">
                            <label for="validationTooltipdriver" class="form-label">Driver</label>
                            <input type="text" name="driver" class="form-control" id="validationTooltipdriver" required>
                            <div class="invalid-tooltip">
                                Please provide a Driver.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationTooltipTypeOfVehicle" class="form-label">Type of Vehicle</label>
                            <input type="text" name="typeofvehicle" class="form-control" id="validationTooltipTypeOfVehicle" required>
                            <div class="invalid-tooltip">
                                Please provide the type of vehicle.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationTooltipplate" class="form-label">Plate no.</label>
                            <input type="text" name="plate_no" class="form-control" id="validationTooltipplate" required>
                            <div class="invalid-tooltip">
                                Please provide a Plate no.
                            </div>
                        </div>
                        <div class="col-md-6">
        <label class="form-label">Violation</label>
        <div class="row g-3">
            <div class="col-md-9">
                <input type="text" name="violation" class="form-control" id="validationTooltipViolation" list="violations" autocomplete="off" required>
                <datalist id="violations">
                    <!-- Populate options dynamically using PHP or JavaScript -->
                    @foreach($violations as $violation)
                        <option value="{{ $violation->code }}">{{ $violation->violation }}</option>
                    @endforeach
                </datalist>
                <div class="invalid-tooltip">
                    Please provide a violation.
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#violationsModal">Choose Violations</button>
            </div>
        </div>
    </div>
                        <div class="col-md-6">
                            <label for="validationTooltipStatus" class="form-label">Status</label>
                            <select name="status" class="form-control" id="validationTooltipStatus" required>
                                <option value="in-progress">In Progress</option>
                                <option value="closed">Closed</option>
                                <option value="settled">Settled</option>
                                <option value="unsettled">Unsettled</option>
                            </select>
                            <div class="invalid-tooltip">
                                Please select a status.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationTooltipTransac" class="form-label">Transaction No.</label>
                            <input type="text" name="transaction_no" class="form-control" id="validationTooltipTransac" placeholder="(TRX-LETAS) NO. ONLY">
                            <div class="invalid-tooltip">
                                Please provide a Transaction No.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationTooltipTOP" class="form-label">TOP</label>
                            <input type="text" name="top" class="form-control" id="validationTooltipTOP">
                        </div>
                        <div class="col-md-6">
                            <label for="validationTooltipContac" class="form-label">Contact no.</label>
                            <input type="text" name="contact_no" class="form-control" id="validationTooltipContac" value="-" required>
                            <div class="invalid-tooltip">
                                Please provide a Contact no.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationTooltipFile" class="form-label">File Attachment (optional)</label>
                            <input type="file" name="file_attachment[]" class="form-control" id="validationTooltipFile" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple>
                            <div class="invalid-tooltip">
                                Please attach a file (Max size: 5MB).
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Submit form</button>
                        </div>
                    </form>
                    <!-- Form End -->
                </div>
            </div>
        </div>
    </div>
</div>

    


    <script>
    // JavaScript for click functionality
    function selectViolation(code) {
        // Your code to handle the selected violation
        console.log('Selected violation:', code);
    }
</script>
<div class="modal fade" id="violationsModal" tabindex="-1" aria-labelledby="violationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="violationsModalLabel">List of Violations</h5>
                <input type="text" id="violationSearch" class="form-control" placeholder="Search..." style="width: 300px; margin-left: 40px;">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table" id="violationsTable">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Violation</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($violations as $violation)
                        <tr>
                            <td>{{ $violation->code }}</td>
                            <td>{{ $violation->violation }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" onclick="selectViolation('{{ $violation->code }}')">Select</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('violationSearch').addEventListener('keyup', function () {
        var input = document.getElementById('violationSearch');
        var filter = input.value.toLowerCase();
        var table = document.getElementById('violationsTable');
        var trs = table.getElementsByTagName('tr');
        
        // Loop through all table rows, and hide those who don't match the search query
        for (var i = 1; i < trs.length; i++) { // start at 1 to skip the header row
            var tds = trs[i].getElementsByTagName('td');
            var match = false;
            for (var j = 0; j < tds.length; j++) {
                if (tds[j].textContent.toLowerCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }
            trs[i].style.display = match ? '' : 'none';
        }
    });
});
</script>
  <script>
    function selectViolation(selectedViolation) {
      var input = document.getElementById('validationTooltipViolation');
      // Split the input value into an array of violations
      var currentViolations = input.value.split(',').map(violation => violation.trim());
      // Trim and split the selectedViolation
      var selectedViolations = selectedViolation.split('-').map(violation => violation.trim());
  
      // Check if the selected violation is already in the list
      var isDuplicate = currentViolations.includes(selectedViolations[0]);
      
      if (!isDuplicate) {
        if (input.value === '') {
          input.value = selectedViolation;
        } else {
          input.value += ', ' + selectedViolation;
        }
      }
      $('#violationsModal').modal('hide'); // Close the modal after selecting a violation
    }


</script>

    
  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>
