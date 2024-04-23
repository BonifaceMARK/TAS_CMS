@extends('layouts.title')

@section('title', env('APP_NAME'))

@include('layouts.title')

<body>

  <!-- ======= Header ======= -->
@include('layouts.header')

  <!-- ======= Sidebar ======= -->
 @include('layouts.sidebar')

  <main id="main" class="main">



    <div class="container-fluid"> <!-- Make the container wider -->
        <div class="row justify-content-center">
            <div class="col-lg-8"> <!-- Adjusted the width of the column -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Contest Case - Input</h5>
    
                        <!-- Form Start -->
                        <form method="POST" action="{{ route('submitForm.tas') }}" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipCaseno" class="form-label">Case no.</label>
                                <input type="text" name="case_no" class="form-control" id="validationTooltipCaseno" required>
                                <div class="invalid-tooltip">
                                    Please Enter Case no.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipTOP" class="form-label">TOP</label>
                                <input type="text" name="top" class="form-control" id="validationTooltipTOP" required>
                                <div class="invalid-tooltip">
                                    Please provide a T.O.P.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipName" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="validationTooltipName" required>
                                <div class="invalid-tooltip">
                                    Please provide a name.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipViolation" class="form-label">Violation</label>
                                <input type="text" name="violation" class="form-control" id="validationTooltipViolation" required>
                                <div class="invalid-tooltip">
                                    Please provide a violation.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipTransac" class="form-label">Transaction No.</label>
                                <input type="text" name="transaction_no" class="form-control" id="validationTooltipTransac" required>
                                <div class="invalid-tooltip">
                                    Please provide a Transaction No.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipdate" class="form-label">Transaction Date</label>
                                <input type="date" name="transaction_date" class="form-control" id="validationTooltipdate" required>
                                <div class="invalid-tooltip">
                                    Please input date.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipFile" class="form-label">File Attachments (optional)</label>
                                <input type="file" name="file_attachments[]" class="form-control" id="validationTooltipFile" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple>
                                <div class="invalid-tooltip">
                                    Please attach file(s) (Max size: 5MB each).
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
    


  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>
