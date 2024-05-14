<!DOCTYPE html>
<html>
<head>
    <title>Subpoena - {{ $compactData['changes']['driver'] }}</title>
    <style>
        @page {
            size: 8.5in 14.0in; /* Page size for long paper */
            margin: 58.5pt 76.5pt 1.0in 81.0pt;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 58.5pt 76.5pt 1.0in 81.0pt;
        }
        .container {
            width: 100%;
        }
        .header {
            display: flex;
            justify-content: center;
            text-align: left; 
            margin: 0;
            padding: 0;
        }

        .header-content {
            max-width: 100%; 
            margin: 0;
            padding: 0;
        }

        .header-content p {
            margin: 0;
            padding: 0;
        }
        .content {
            margin-bottom: 20px;
            text-align: justify;
        }
        .content h3{
           
            text-align: center;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .left {
            text-align: left;
        }
        .right {
            text-align: right;
        }
        .rightpart {
            text-align: right;
            /* margin-right: 100pt;  */
        }
        .signature {
            /* margin-top: 40px; */
            text-align: right;
            margin: 0;
            padding: 0;
        }
        .signature p{
            /* margin-top: 40px; */
            text-align: right;
            margin: 0;
            padding: 0;
            margin: 0;
            padding: 0;
        }
        .proof-of-service {
            margin-top: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        @media screen and (max-width: 600px) {
            body {
                margin: 20px;
                padding: 10px;
            }
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            .header-content {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        
        <span style='position:
            absolute;z-index:251657216;margin-left:-10px;margin-top:0px;width:82px;
            height:77px'><img width=82 height=77 src="{{asset('assets/img/bagong_pilipinas.png')}}"></span>
        <span style='position:absolute;z-index:251658240;margin-left:75px;margin-top:0px;width:78px;height:78px'>
            <img width=78 height=78 src="{{asset('assets/img/LTO.png')}}" alt=LTO>
        </span>
        <div class="header">
            <div class="header-content" style="text-indent: 30px;">
                <p contenteditable="true">Republic of the Philippines</p>
                <p contenteditable="true">Department of Transportation</p>
                <p contenteditable="true" style="font-size: 14pt">LAND TRANSPORTATION OFFICE</p>
                <p contenteditable="true" style="font-size: 12pt; font-weight:bold">TRAFFIC ADJUDICATION SERVICE</p>
                <br><br><br>
            </div>
        </div>
        
        <div class="content">
            <div class="row">
                <div class="left" contenteditable="true">LTO – 
                    <span contenteditable="true">
                        @foreach ($compactData['officers'] as $officer)
                            {{ $officer->department }}
                        @endforeach
                    </span> 
                    represented by</div>
                <div class="right" style="margin-right: 18%;display: flex;" contenteditable="true">Case No. {{ $compactData['changes']['case_no'] }}</div>
            </div>
            <div class="row">
                <div class="left" style="font-weight:bold" contenteditable="true">{{ $compactData['changes']['apprehending_officer'] }}</div>
                <div class="right" contenteditable="true">{{ $compactData['changes']['transaction_no'] }}</div>
            </div>
        </div>

        <div class="content">
            <div class="row left" style="margin-left: 10%">
                <p style='margin-left:3.0in;text-align: justify;' contenteditable="true">
                    FOR: 
                <br>
                <?php $counter = 1; ?>
                    @if (!empty($compactData['relatedViolations']))
                        @foreach ($compactData['relatedViolations'] as $violation)
                        {{ $counter }}. {{ $violation->code }} - {{ $violation->violation }} <br>
                        <?php $counter++; ?>
                    @endforeach
                    @else
                        No violations recorded.
                    @endif
                    </span></p>
            </div>
            <div class="left" contenteditable="true">
                <i>Complainants,</i>
                <br>
                <b>{{ $compactData['changes']['driver'] }}</b>
                <br>
                <p><b><i>X-------------------------------X</i></b></p>
            </div>
            
        </div>
        
        <div class="content">
            <p style="font-family: 'Times New Roman', Times, serif; font-size:16pt; font-weight:bolder;text-align:center" contenteditable="true">SUBPOENA</p>
            <p style="font-weight: bold" contenteditable="true">GREETINGS:</p>
            <p style="text-indent: 30px;" contenteditable="true">Under and by virtue of the authority vested in the Traffic Adjudication Service (TAS) by Section 3 of Executive Order No. 266 dated July 25, 1987, you are hereby ordered to submit a Position Paper before the Traffic Adjudication Service LTO Central Office East Avenue Quezon City Philippines on <strong>{{$compactData['hearing']}}</strong> at <strong>2:00 p.m</strong> in connection with the charge/s involving motor vehicle with Plate No. <b>{{$compactData['changes']['plate_no']}}</b>.</p>
            <p style="text-indent: 30px;" contenteditable="true">Failure to comply with the lawful order of this Office is tantamount to disobedience. As such, this Office will recommend the revocation of your Deputation Order.</p>
            <p contenteditable="true">{{$compactData['date']}} Quezon City Philippines.</p>
        </div>
        
        <div class="signature">
            <p style="font-weight:bolder;" contenteditable="true">ATTY. ESTEBAN M. BALTAZAR JR. CESO V</p>
            <p style="margin-right: 10%;" contenteditable="true"><i>Director II Regional Director</i></p>
            <p style="margin-right: 8%;" contenteditable="true">Chief Traffic Adjudication Service</p>
        </div>
        
        <div class="proof-of-service">
            <h4 contenteditable="true">Proof of Service</h4>
            <p contenteditable="true">This is to certify that notice of hearing has been duly served and received by:</p>
            <table contenteditable="true">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Signature</th>
                        <th>Date/Time</th>
                        <th>Contact No.</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Repeat this row for each recipient -->
                    <tr>
                        <td contenteditable="true">1. A.O/L.O &nbsp; &nbsp; &nbsp; &nbsp;</td>
                        <td>________________</td>
                        <td>________________</td>
                        <td>________________</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
