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
 <!-- Button to trigger the modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#trafficChartModal">
    Open Traffic Chart
</button>

<!-- Modal -->
<div class="modal fade" id="trafficChartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Traffic Chart</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Canvas for the chart -->
                <canvas id="trafficChart" width="800" height="800"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Extract data from PHP variable to JavaScript
    const trafficData = {!! json_encode($trafficData) !!};

    // Extract violation types and total counts for chart labels and data
    const violations = trafficData.map(data => data.violation);
    const violationCounts = trafficData.map(data => data.total);

    // Create chart
    const ctx = document.getElementById('trafficChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: violations,
            datasets: [{
                label: 'Total Violations',
                data: violationCounts,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

    <div class="container-fluid"> <!-- Make the container wider -->
        <div class="row justify-content-center">
            <div class="col-lg-8"> <!-- Adjusted the width of the column -->
                <div class="card">
                    <div class="card-body">
                        
                        <h5 class="card-title">Admitted Case - Input     <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#violationsModal">
                            View Violations
                        </button>                       <!-- Button to trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#admittedModal">
    Edit Admitted Cases
</button></h5>
                  
<form method="POST" action="{{ route('admittedsubmit.tas') }}" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
    @csrf
    <div class="col-md-6 position-relative">
        <label for="validationTooltipRC" class="form-label">Resolution No.</label>
        <input type="text" name="resolution_no" class="form-control" id="validationTooltipRC">
        <div class="invalid-tooltip">
            Please provide a Resolution Case no.
        </div>
    </div>
    <div class="col-md-6 position-relative">
        <label for="validationTooltipTOP" class="form-label">TOP</label>
        <input type="text" name="top" class="form-control" id="validationTooltipTOP">
        <div class="invalid-tooltip">
            Please provide a T.O.P.
        </div>
    </div>
    <div class="col-md-6 position-relative">
        <label for="validationTooltipViolation" class="form-label">Violation</label>
        <input type="text" name="violation" class="form-control" id="validationTooltipViolation">
        <div class="invalid-tooltip">
            Please provide a violation.
        </div>
    </div>
    <div class="col-md-6 position-relative">
        <label for="validationTooltipTransac" class="form-label">Transaction No.</label>
        <input type="text" name="transaction_no" class="form-control" id="validationTooltipTransac">
        <div class="invalid-tooltip">
            Please provide a Transaction No.
        </div>
    </div>
    <div class="col-md-6 position-relative">
        <label for="validationTooltipDateReceived" class="form-label">Date Received</label>
        <input type="date" name="date_received" class="form-control" id="validationTooltipDateReceived" required>
        <div class="invalid-tooltip">
            Please input date.
        </div>
    </div>
    <div class="col-md-6 position-relative">
        <label for="validationTooltipPlateNo" class="form-label">Plate no.</label>
        <input type="text" name="plate_no" class="form-control" id="validationTooltipPlateNo" required>
        <div class="invalid-tooltip">
            Please provide a Plate no.
        </div>
    </div>
    <div class="col-md-6 position-relative">
        <label for="validationTooltipContactNo" class="form-label">Contact no.</label>
        <input type="text" name="contact_no" class="form-control" id="validationTooltipContactNo" required>
        <div class="invalid-tooltip">
            Please provide a Contact no.
        </div>
    </div>
    <div class="col-md-6 position-relative">
        <label for="validationTooltipDriver" class="form-label">Driver</label>
        <input type="text" name="driver" class="form-control" id="validationTooltipDriver">
        <div class="invalid-tooltip">
            Please provide a Driver.
        </div>
    </div>
    <div class="col-md-6 position-relative">
        <label for="validationTooltipOfficer" class="form-label">Apprehending Officer</label>
        <input type="text" name="apprehending_officer" class="form-control" id="validationTooltipOfficer">
        <div class="invalid-tooltip">
            Please provide an Apprehending Officer.
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

                        {{-- <a href="{{ asset('storage\attachments\1713858878_WIN_20230717_13_27_01_Pro.jpg') }}">Download PDF</a> --}}
                        
                        <!-- Form End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="admittedModal" tabindex="-1" aria-labelledby="admittedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl custom-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="admittedModalLabel">Admitted Cases</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="custom-table-header">
                            <tr>
                            <th>Resolution No</th>
                                <th>Top</th>
                                <th>Apprehending Officer</th>
                                <th>Driver</th>
                                <th>Violation</th>
                                <th>Transaction No</th>
                                <th>Transaction Date</th>
                                <th>Plate No</th>
                                <th>Contact No</th>
                                <th>Remarks</th>
                                <th>File Attach</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admitteds as $admitted)
                                <tr>
                                <td>{{ $admitted->resolution_no }}</td>
                                    <td>{{ $admitted->top }}</td>
                                    <td>{{ $admitted->apprehending_officer }}</td>
                                    <td>{{ $admitted->driver }}</td>
                                    <td>{{ $admitted->violation }}</td>
                                    <td>{{ $admitted->transaction_no }}</td>
                                    <td>{{ $admitted->created_at }}</td>
                                    <td>{{ $admitted->plate_no }}</td>
                                    <td>{{ $admitted->contact_no }}</td>
                                    <td>{{ $admitted->remarks }}</td>
                                    <td>
                                        @if ($admitted->file_attach)
                                            @php
                                                $filePaths = json_decode($admitted->file_attach);
                                            @endphp
                                            @if ($filePaths)
                                                <ul class="list-unstyled">
                                                    @foreach ($filePaths as $filePath)
                                                        <li>
                                                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank">{{ basename($filePath) }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
    <button type="button" class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editModal{{$admitted->id}}" data-id="{{ $admitted->id }}">Edit</button>
</td>

                                </tr>
                              
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
   
<div class="modal fade" id="editModal{{$admitted->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$admitted->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{$admitted->id}}">Edit Admitted Resolution No: <strong>{{$admitted->resolution_no}}</strong> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admitted-cases.update', ['id' => $admitted->id]) }}" method="POST" class="editForm">
                    @csrf
                    @method('PUT') <!-- Add this method spoofing for PUT request -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="editTop{{$admitted->id}}" class="form-label">Top</label>
                            <input type="text" class="form-control" id="editTop{{$admitted->id}}" name="top" value="{{$admitted->top}}">
                        </div>
                        <div class="col-md-6">
                            <label for="editApprehendingOfficer{{$admitted->id}}" class="form-label">Apprehending Officer</label>
                            <input type="text" class="form-control" id="editApprehendingOfficer{{$admitted->id}}" name="apprehending_officer" value="{{$admitted->apprehending_officer}}">
                        </div>
                        <div class="col-md-6">
                            <label for="editDriver{{$admitted->id}}" class="form-label">Driver</label>
                            <input type="text" class="form-control" id="editDriver{{$admitted->id}}" name="driver" value="{{$admitted->driver}}">
                        </div>
                        <div class="col-md-6">
                            <label for="editViolation{{$admitted->id}}" class="form-label">Violation</label>
                            <input type="text" class="form-control" id="editViolation{{$admitted->id}}" name="violation" value="{{$admitted->violation}}">
                        </div>
                        <div class="col-md-6">
                            <label for="editTransactionNo{{$admitted->id}}" class="form-label">Transaction No</label>
                            <input type="text" class="form-control" id="editTransactionNo{{$admitted->id}}" name="transaction_no" value="{{$admitted->transaction_no}}">
                        </div>
                        <div class="col-md-6">
                            <label for="editTransactionDate{{$admitted->id}}" class="form-label">Transaction Date</label>
                            <input type="date" class="form-control" id="editTransactionDate{{$admitted->id}}" name="transaction_date" value="{{$admitted->transaction_date}}">
                        </div>
                        <div class="col-md-6">
                            <label for="editContactNo{{$admitted->id}}" class="form-label">Contact No</label>
                            <input type="text" class="form-control" id="editContactNo{{$admitted->id}}" name="contact_no" value="{{$admitted->contact_no}}">
                        </div>
                        <div class="col-md-6">
                            <label for="editPlateNo{{$admitted->id}}" class="form-label">Plate No</label>
                            <input type="text" class="form-control" id="editPlateNo{{$admitted->id}}" name="plate_no" value="{{$admitted->plate_no}}">
                        </div>
                        <div class="col-12">
                            <label for="editRemarks{{$admitted->id}}" class="form-label">Remarks</label>
                            <textarea class="form-control" id="editRemarks{{$admitted->id}}" name="remarks" rows="3">{{$admitted->remarks}}</textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary saveChangesBtn" data-modalid="{{$admitted->id}}">Save Changes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
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
        <ol>
          <li>Driving without valid driver’s license/ conductor’s permit</li>
          <li>Allowing an unauthorized driver to drive PUV or allowing a driver to drive PUV without bringing his/her driver’s license</li>
          <li>Driving a Motor Vehicle used in the commission of a crime upon conviction by a regular court of competent jurisdiction</li>
          <li>Commission of a crime in the course of Apprehension upon conviction by a regular court of competent jurisdiction</li>
          <li>Driving while under the influence of alcohol and/or prohibited drugs</li>
          <li>Reckless Driving</li>
          <li>Employing reckless, insolent, discourteous or arrogant driver</li>
          <li>Submission of fake documents in driver’s license application (new/renewal)</li>
          <li>Failure to wear the prescribed seatbelt device and/or failure to require the front seat passenger to wear seatbelt</li>
          <li>Failure to require his/her passenger/s to wear the prescribed seatbelt/ post appropriate seatbelt signage (for PUV)</li>
          <li>Failure to wear the standard protective Motorcycle helmet or failure to require the back rider to wear standard protective Motorcycle helmet (R.A 10054)</li>
          <li>Wearing substandard helmet or without ICC sticker (R.A 10054 Sec. 7c)</li>
          <li>Failure to carry Driver’s License</li>
          <li>Failure to carry Certificate of Registration or Official Receipt (OR/CR) while driving</li>
          <li>Illegal Parking</li>
          <li>Disregarding Traffic Signs</li>
          <li>Allowing passengers on top or cover of a motor vehicle except in a truck helper</li>
          <li>Failure to provide canvass cover to cargos or freight of trucks requiring the same</li>
          <li>Permitting passenger to ride on running board, step-board or mudguard of Motor Vehicle while in motion</li>
          <li>Failure to dim headlights when approaching another vehicle</li>
          <li>Driving in a place not intended for traffic or into place not allowed for parking</li>
          <li>Hitching or permitting a person or a bicycle, motorcycle, tricycle or skate roller to hitch to a Motor Vehicle</li>
          <li>Driving against traffic</li>
          <li>Illegal turn</li>
          <li>Illegal overtaking</li>
          <li>Overtaking at unsafe distance</li>
          <li>Cutting an overtaken vehicle</li>
          <li>Failure to give way to an overtaking vehicle</li>
          <li>Increasing speed when being overtaken</li>
          <li>Overtaking when left side is not visible or clear of oncoming traffic</li>
          <li>Overtaking upon crest of a grade</li>
          <li>Overtaking upon a curve</li>
          <li>Overtaking at any railway grade crossing</li>
          <li>Overtaking at an intersection</li>
          <li>Overtaking on "men working" or "caution" signs</li>
          <li>Overtaking at no overtaking zone</li>
          <li>Failure to yield the right of way - failure of the vehicle on the left to yield the right of way to the vehicle on the right when these vehicles approach or enter Intersection at an approximately the same time</li>
          <li>Failure to yield the right of way - failure of a vehicle approaching but not having entered an intersection to yield the right of way to a vehicle within such intersection or turning therein to the left across the line of travel of the first mentioned vehicle when such vehicle has given a plainly visible signal of intention to turn</li>
          <li>Failure to yield the right of way - failure of the driver of any vehicle upon a highway within a business or residential district to yield the right of way to a pedestrian crossing such highway within a crosswalk except at Intersection where the movement of traffic is regulated by a peace officer or by traffic signal</li>
          <li>Failure to stop before traversing a "through highway" or railroad crossing - failure of the driver of a vehicle upon a highway to bring to a full stop such vehicle before traversing any "through highway or railroad crossing</li>
          <li>Failure to yield right of way - failure of a vehicle entering a highway from a private road or driver upon a highway to yield the right of way to all vehicles approaching on such highway</li>
          <li>Failure to yield right of way to ambulance, police or fire department vehicles - failure of a driver upon a highway to yield the right of way to police or fire department vehicles and ambulances when such vehicles are operated on official business and the drivers thereof sound audible signal or their approach</li>
          <li>Failure to yield right of way at a "through highway" or a "stop intersection" - failure of a vehicle entering a "through highway" or a "stop intersection" to yield right of way to all vehicles approaching in either direction on such "through highway"</li>
          <li>Failure to give proper signal - failure to give the appropriate signal before starting. stopping or turning from a direct line</li>
          <li>Illegal turn - failure of the driver of a motor vehicle intending to run to the right at an intersection to approach such intersection in the lane for traffic nearest to be right-hand side of the highway and, in turning, to keep as close as possible to the right-hand curve or edge of the highway</li>
          <li>Illegal turn - failure of the driver of a vehicle intending to turn to the left, to approach such intersection in the lane for traffic to the right of and nearest to the center line of the highway, and in, turning to pass to the loft of the center of the intersection except upon highway laned for traffic and upon one-way highway</li>
          <li>Failure to stop motor and notch handbrake of motor vehicle when unattended - failure to turn off the ignition switch and stop the motor and notch effectively the handbrake when parking a motor vehicle unattended on any highway</li>
          <li>Unsafe towing</li>
          <li>Obstruction - obstructing the free passage of other vehicles on the highway while discharging or taking passengers or loading and unloading freight, or driving a motor vehicle in such a manner as to obstruct or impede the passage of any vehicle</li>
          <li>MC carrying more passengers other than the back rider or cargo other than the saddle bags and luggage carriers</li>
          <li>Refusal to render service to the public or convey passenger to destination</li>
          <li>Overcharging/Undercharging of fare</li>
          <li>No franchise/CPC or evidence of franchise presented</li>
          <li>Fraud and falsities of fake and spurious CPC, OR/CR, plates, stickers and tags</li>
          <li>Operating the unit/s with defective parts and accessories</li>
          <li>Failure to provide fare discount</li>
          <li>Fast, tampered, defective taximeter or operating without or with an old seal taximeter</li>
          <li>Tampered, broken, joined, reconnected, fake or altered sealing wire</li>
          <li>No sign board</li>
          <li>Pick and drop of passengers outside terminal</li>
          <li>Carrying of illegal and/or prohibited cargoes</li>
          <li>Failure to provide fire extinguisher and required STOP and GO signage</li>
          <li>Trip Cutting</li>
          <li>Failure to display fare matrix</li>
          <li>Breach of franchise conditions under LTFRB MC No. 2011-004 Revised Terms and Conditions of CPC not otherwise herein provided</li>
          <li>Violations of the Provisions of the Anti-Distracted Driving Act</li>
          <li>Violations of the Provisions of the Children’s Safety on Motorcycles Act</li>
          <li>Unregistered Motor Vehicle (to include reckless driving)</li>
          <li>Unauthorized Motor Vehicle Modification</li>
          <li>Operating a right-hand drive Motor Vehicle</li>
          <li>Motor Vehicle operating with defective/ improper/unauthorized accessories, devices, equipment and parts</li>
          <li>Failure to attach or improper attachment/tampering of Motor Vehicle license plates and/or third plate sticker.</li>
          <li>Smoke Belching</li>
          <li>Fraud in MV Registration/Renewal</li>
          <li>All other violations in connection with Motor Vehicle Registration / Renewal / Operation</li>
          <li>Load extending beyond projected width without permit</li>
          <li>Axle Overloading</li>
          <li>Operating a passenger bus / truck with cargo exceeding 160kg</li>
          <li>Colorum Violation; MV operating</li>
          <li>Failure to provide proper body markings</li>
          <li>Allowing unauthorized driver to drive PUV or allowing driver to drive PUV without bringing his/her driver’s license</li>
          <li>Failure to provide the Board with complete, correct, and updated operator’s information and other forms of misrepresentation</li>
          <li>Failure to display “No smoking” signage and/or allowing personnel or passenger to smoke inside the vehicle</li>
          <li>Violation of color scheme or design/ Adoption or new color design without authority from the Board (PUB and TX only)</li>
          <li>Unregistered or unauthorized trade/business name (PUB and TX only)</li>
          <li>No panel route (PUJ, PUB, UV)</li>
          <li>Failure to display the International Symbol of Accessibility inside the units and/or failure to designate seats specifically for the use of Persons with Disability or Failure or refusal to transport PWDs (PUJ, PUB, TTS, UV)</li>
          <li>Impounding Fee</li>
        </ol>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize draggable behavior when modal is shown
        $('#editModal{{$admitted->id}}').on('shown.bs.modal', function() {
            $(this).find('.modal-dialog').draggable({
                handle: ".modal-header" // Define the draggable handle
            });
        });
    });
</script>

    <script>
        document.getElementById('validationTooltipCaseno').addEventListener('keydown', function(e) {
            if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
                e.preventDefault();
            }
        });
    </script>
      @endforeach
  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>
