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
                        <h5 class="card-title">Contest Case - Input </h5>
    
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
                                <input type="text" name="violation" class="form-control" id="validationTooltipViolation" required>
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
                                <label for="validationTooltipTOP" class="form-label">TOP</label>
                                <input type="text" name="top" class="form-control" id="validationTooltipTOP">
                            </div>
                            
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltipContac" class="form-label">Contact no.</label>
                                <input type="text" name="contact_no" class="form-control" id="validationTooltipContac" value="N/A" required>
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
<!-- Recent Violations -->
<div class="col-12">
    <div class="card recent-violations overflow-auto">
        <div class="card-body">
            <h5 class="card-title">Edit Contested Cases<span></span></h5>
            <table class="table table-borderless datatable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Resolution No.</th>
                        <th scope="col">TOP</th>
                        <th scope="col">Driver</th>
                        <th scope="col">Apprehending Officer</th>
                        <th scope="col">Violation</th>
                        <th scope="col">Transaction No:</th>
                        <th scope="col">Date Received</th>
                        <th scope="col">Plate No.</th>
                        <th scope="col">Contact No.</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">File Attachment</th>
                        <th scope="col">Actions</th> <!-- Add this table header for actions -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentViolationsToday as $violation)
                    <tr>
                        <th scope="row"><a href="#">{{ $violation->id }}</a></th>
                        <td>{{ $violation->resolution_no }}</td>
                        <td>{{ $violation->top }}</td>
                        <td>{{ $violation->driver }}</td>
                        <td>{{ $violation->apprehending_officer }}</td>
                        <td>{{ $violation->violation }}</td>
                        <td>{{ $violation->transaction_no }}</td>
                        <td>{{ $violation->date_received }}</td>
                        <td>{{ $violation->plate_no }}</td>
                        <td>{{ $violation->contact_no }}</td>
                        <td>{{ $violation->remarks }}</td>
                        <td>{{ $violation->file_attach }}</td>
                        <td>
                            <button class="btn btn-primary editViolation" data-id="{{ $violation->id }}" data-bs-toggle="modal" data-bs-target="#editViolationModal{{ $violation->id }}">Edit</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div><!-- End Recent Violations -->

<!-- Modal -->
@foreach($recentViolationsToday as $violation)
<div class="modal fade" id="editViolationModal{{ $violation->id }}" tabindex="-1" aria-labelledby="editViolationModalLabel{{ $violation->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editViolationModalLabel{{ $violation->id }}">Edit Violation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editViolationForm{{ $violation->id }}" action="{{ route('violations.updateTas', ['id' => $violation->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <!-- Violation details section -->
                <h6 class="fw-bold mb-3">Violation Details</h6>
                <div class="mb-3">
                    <label for="resolutionNo{{ $violation->id }}" class="form-label">Resolution No.</label>
                    <input type="text" class="form-control" id="resolutionNo{{ $violation->id }}" name="resolution_no" value="{{ $violation->resolution_no }}">
                </div>
                <div class="mb-3">
                    <label for="top{{ $violation->id }}" class="form-label">TOP</label>
                    <input type="text" class="form-control" id="top{{ $violation->id }}" name="top" value="{{ $violation->top }}">
                </div>
                <div class="mb-3">
                    <label for="driver{{ $violation->id }}" class="form-label">Driver</label>
                    <input type="text" class="form-control" id="driver{{ $violation->id }}" name="driver" value="{{ $violation->driver }}">
                </div>
                <div class="mb-3">
                    <label for="apprehendingOfficer{{ $violation->id }}" class="form-label">Apprehending Officer</label>
                    <input type="text" class="form-control" id="apprehendingOfficer{{ $violation->id }}" name="apprehending_officer" value="{{ $violation->apprehending_officer }}">
                </div>
                <div class="mb-3">
                    <label for="violation{{ $violation->id }}" class="form-label">Violation</label>
                    <input type="text" class="form-control" id="violation{{ $violation->id }}" name="violation" value="{{ $violation->violation }}">
                </div>
            </div>
            <div class="col-md-6">
                <!-- Additional details section -->
                <h6 class="fw-bold mb-3">Additional Details</h6>
                <div class="mb-3">
                    <label for="transactionNo{{ $violation->id }}" class="form-label">Transaction No.</label>
                    <input type="text" class="form-control" id="transactionNo{{ $violation->id }}" name="transaction_no" value="{{ $violation->transaction_no }}">
                </div>
                <div class="mb-3">
                    <label for="dateReceived{{ $violation->id }}" class="form-label">Date Received</label>
                    <input type="date" class="form-control" id="dateReceived{{ $violation->id }}" name="date_received" value="{{ $violation->date_received }}">
                </div>
                <div class="mb-3">
                    <label for="plateNo{{ $violation->id }}" class="form-label">Plate No.</label>
                    <input type="text" class="form-control" id="plateNo{{ $violation->id }}" name="plate_no" value="{{ $violation->plate_no }}">
                </div>
                <div class="mb-3">
                    <label for="contactNo{{ $violation->id }}" class="form-label">Contact No.</label>
                    <input type="text" class="form-control" id="contactNo{{ $violation->id }}" name="contact_no" value="{{ $violation->contact_no }}">
                </div>
                <div class="mb-3">
                    <label for="remarks{{ $violation->id }}" class="form-label">Remarks</label>
                    <input type="text" class="form-control" id="remarks{{ $violation->id }}" name="remarks" value="{{ $violation->remarks }}">
                </div>
                <div class="mb-3">
                    <label for="fileAttach{{ $violation->id }}" class="form-label">File Attachment</label>
                    <input type="file" class="form-control" id="fileAttach{{ $violation->id }}" name="file_attach">
                </div>
            </div>
        </div>
      
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
        </div>
    </div>
</div>
@endforeach


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
        document.getElementById('validationTooltipCaseno').addEventListener('keydown', function(e) {
            if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
                e.preventDefault();
            }
        });
    </script>
    
    
  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>
