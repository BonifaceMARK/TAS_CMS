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



<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Contest Case - Input</h5>
                    <!-- Form Start -->
                 
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
<!-- Modal -->
<div class="modal fade" id="violationsModal" tabindex="-1" aria-labelledby="violationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="violationsModalLabel">List of Violations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
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
