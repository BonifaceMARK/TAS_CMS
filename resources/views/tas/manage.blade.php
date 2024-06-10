@extends('layouts.title')

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



    <div class="container-fluid"> <!-- Make the container wider -->
        <div class="row justify-content-center">
            <div class="col-lg-12"> <!-- Adjusted the width of the column -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Contest Case - Input <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#violationsModal">
                            View Violations
                          </button></h5>
    
                        <!-- Form Start -->
                        <form method="POST" action="{{ route('submitForm.tas') }}" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipdate" class="form-label">Date Received</label>
                                <input type="date" name="date_received" class="form-control" id="validationTooltipdate" required>
                                <div class="invalid-tooltip">
                                    Please input date.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipCaseno" class="form-label">Case no.</label>
                                <input type="number" name="case_no" class="form-control" id="validationTooltipCaseno" min="1" max="9999999" required>
                                <div class="invalid-tooltip">
                                    Please enter a valid Case no. (Number only)
                                </div>
                            </div>
                            
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipofficer" class="form-label">Apprehending Officer</label>
                                <input type="text" name="apprehending_officer" class="form-control" id="validationTooltipofficer"  list="nameList" required autocomplete="off">
                                <div class="invalid-tooltip">
                                    Please provide a Apprehending Officer.
                                </div>
                                <datalist id="nameList">
                                    @foreach($officers as $officer)
                                    <option value="{{ $officer->officer }}">
                                        @endforeach
                                </datalist>

                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipdriver" class="form-label">Driver</label>
                                <input type="text" name="driver" class="form-control" id="validationTooltipdriver" required>
                                <div class="invalid-tooltip">
                                    Please provide a Driver.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipplate" class="form-label">Plate no.</label>
                                <input type="text" name="plate_no" class="form-control" id="validationTooltipplate" required>
                                <div class="invalid-tooltip">
                                    Please provide a Plate no.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipViolation" class="form-label">Violation</label>
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
                            
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipTransac" class="form-label">Transaction No.</label>
                                <input type="text" name="transaction_no" class="form-control" id="validationTooltipTransac" placeholder="(TRX-LETAS) NO. ONLY">
                                <div class="invalid-tooltip">
                                    Please provide a Transaction No.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipTOP" class="form-label">TOP</label>
                                <input type="text" name="top" class="form-control" id="validationTooltipTOP">
                            </div>
                            
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipContac" class="form-label">Contact no.</label>
                                <input type="text" name="contact_no" class="form-control" id="validationTooltipContac" value="-" required>
                                <div class="invalid-tooltip">
                                    Please provide a Contact no.
                                </div>
                            </div>
                            
                            <div class="col-md-6 position-relative">
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




    


<!-- Modal -->
<div class="modal fade" id="violationsModal" tabindex="-1" aria-labelledby="violationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="violationsModalLabel">List of Violations</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @foreach($violations as $violation)
          <p class="violation" onclick="selectViolation('{{ $violation->code }}')">
            <strong>{{ $violation->code }}</strong> - {{ $violation->violation }}
          </p>
          @endforeach
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    function addViolation() {
        var violationContainer = document.getElementById('violationContainer');
        var newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.name = 'violation[]'; // Use an array to handle multiple violations
        newInput.className = 'form-control violation-input mt-2';
        newInput.required = true;
        violationContainer.appendChild(newInput);

        // Create a "Minus" button
        var minusButton = document.createElement('button');
        minusButton.type = 'button';
        minusButton.className = 'btn btn-danger mt-2';
        minusButton.textContent = 'Remove';
        minusButton.onclick = function() {
            violationContainer.removeChild(newInput);
            violationContainer.removeChild(minusButton);
        };
        violationContainer.appendChild(minusButton);
    }
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
