<html>

<head>
    <meta http-equiv=Content-Type content="text/html; charset=windows-1252">
    <meta name=Generator content="Microsoft Word 15 (filtered)">
    <style>
        <!--
         /* Font Definitions */
         @font-face {
             font-family: Wingdings;
             panose-1: 5 0 0 0 0 0 0 0 0 0;
         }

         @font-face {
             font-family: "Cambria Math";
             panose-1: 2 4 5 3 5 4 6 3 2 4;
         }

         @font-face {
             font-family: Calibri;
             panose-1: 2 15 5 2 2 2 4 3 2 4;
         }

         @font-face {
             font-family: Tahoma;
             panose-1: 2 11 6 4 3 5 4 4 2 4;
         }
         /* Style Definitions */
         p.MsoNormal,
         li.MsoNormal,
         div.MsoNormal {
             margin-top: 0in;
             margin-right: 0in;
             margin-bottom: 10.0pt;
             margin-left: 0in;
             line-height: 115%;
             font-size: 11.0pt;
             font-family: "Calibri", sans-serif;
         }

         p.MsoNoSpacing,
         li.MsoNoSpacing,
         div.MsoNoSpacing {
             margin: 0in;
             font-size: 11.0pt;
             font-family: "Calibri", sans-serif;
         }

         .MsoChpDefault {
             font-family: "Calibri", sans-serif;
         }

         @page WordSection1 {
             size: 8.5in 14.0in;
             margin: 58.5pt 76.5pt 1.0in 81.0pt;
         }

         div.WordSection1 {
            margin: 0 auto;
            max-width: 800px; 
            padding: 20px;
            /* page:WordSection1; */
        }
         /* List Definitions */
         ol {
             margin-bottom: 0in;
         }

         ul {
             margin-bottom: 0in;
         }
        
    </style>

</head>

<body lang=EN-US style='word-wrap:break-word'>

    <div style="position: absolute; top: 0.25in; left: 1in; bottom: 1in; right: 1in;">

        <p class=MsoNoSpacing><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>
            </span></p>

        <p class=MsoNoSpacing><span style='position:absolute;z-index:251658240;
            margin-left:87px;margin-top:0px;width:78px;height:78px'><img width=78
                height=78 src="{{asset('assets/img/LTO.png')}}" alt=LTO></span><span style='position:
            absolute;z-index:251657216;margin-left:0px;margin-top:0px;width:82px;
            height:77px'><img width=82 height=77 src="{{asset('assets/img/bagong_pilipinas.png')}}"></span><span
                style='font-size:12.0pt;font-family:"Arial",sans-serif'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Republic
                of the Philippines</span></p>

        <p class=MsoNoSpacing><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Department of Transportation</span></p>

        <p class=MsoNoSpacing style='margin-left:1.5in'><span style='font-size:12.0pt;
            font-family:"Arial",sans-serif'> </span><span style='font-size:14.0pt;
            font-family:"Arial",sans-serif'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LAND TRANSPORTATION OFFICE</span></p>

        <p class=MsoNoSpacing align=center style='text-align:left'><b><span
                    style='font-size:12.0pt;font-family:"Arial",sans-serif'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TRAFFIC
                    ADJUDICATION SERVICE </span></b></p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>

        <p class=MsoNoSpacing><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>LTO –
                 <span >
                    @foreach ($compactData['officers'] as $officer)
                        {{ $officer->department }}
                    @endforeach

                </span>
                represented by <span style='margin-left:21.5%'> Case
                    No.</span><b><span style='color:black'>{{ $compactData['changes']['case_no'] }}</span></b></span></p>

                    
                    <div style="display:inline-block;">
                        <b><span style="font-size:12.0pt;font-family:'Arial',sans-serif;">{{ $compactData['changes']['apprehending_officer'] }}</span></b>
                    </div><div style="margin-left:20%; display:inline-block;">
                        <span style="font-size:12.0pt;font-family:'Arial',sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <span style="font-size:12.0pt;font-family:'Arial',sans-serif;">{{ $compactData['changes']['transaction_no'] }}</span>
                    </div>
                    {{-- <div class="container">
                        <div class="column">
                            <h2>List of Violations</h2>
                            <div class="row">
                                <div class="fixed-width-left">
                                    @foreach ($compactData['officers'] as $officer)
                                        TO – {{ $officer->department }} represented by
                                    @endforeach
                                    
                                </div>
                                <div class="fixed-width-right">
                                    Case No.{{ $compactData['changes']['case_no'] }}
                                </div>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Violation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Repeat this row for each violation -->
                                    <tr>
                                        <td>Speeding</td>
                                    </tr>
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                        <div class="column">
                            <table>
                                
                                <tbody>
                                    <!-- Repeat this row for each officer and transaction number -->
                                    <tr>
                                        <td>{{ $compactData['changes']['apprehending_officer'] }}</td>
                                        <td>{{ $compactData['changes']['transaction_no'] }}</td>
                                    </tr>
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
                    
                    
        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'> 
            </span></b></p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>
            </span></b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>Co<i>mplainants,</i><b>
                </b></span></p>

                <p class=MsoNoSpacing style='margin-left:3.0in'><b><span style='font-size:12.0pt;
                font-family:"Arial",sans-serif'> 
                </span></b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>FOR:&nbsp;&nbsp;&nbsp;&nbsp;
                    
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

        <p class=MsoNoSpacing style='margin-left:3.0in'><span style='font-size:12.0pt;
                font-family:"Arial",sans-serif'> </span></p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif;
            '>
            <br>
            {{ $compactData['changes']['driver'] }}
            </span></b></p>

        <p class=MsoNoSpacing style='text-align:justify'><b><i><span style='font-size:
                    12.0pt'>X-------------------------------X</span></i></b></p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>

        <p class=MsoNoSpacing align=center style='text-align:center'><b><span
                    style='font-size:16.0pt;font-family:"Times New Roman",serif'>SUBPOENA </span></b></p>

        <p class=MsoNoSpacing><b><span style='font-size:14.0pt;font-family:"Times New Roman",serif'>&nbsp;</span></b></p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Times New Roman",serif'>GREETINGS:</span></b></p>

        <p class=MsoNoSpacing><span style='font-size:12.0pt;font-family:"Arial",sans-serif'> </span></p>

        <p class=MsoNoSpacing style='text-align:justify;text-indent:.5in'><span
                style='font-size:12.0pt;font-family:"Arial",sans-serif'>Under and by virtue of
                the authority vested in the Traffic Adjudication Service (TAS) by Section 3 of
                Executive Order No. 266 dated July 25,1987, you are hereby ordered to <b>submit
                    Position Paper</b> before the Traffic Adjudication Service, LTO Central Office,
                East Avenue, Quezon City, Philippines, on <b><span >{{$compactData['hearing']}} at 2:00 p.m.</b> in connection with the charge/s involving motor
                vehicle with Plate No<b>. <span>{{$compactData['changes']['plate_no']}}.<br><br></span></b></span></p>

        <p class=MsoNoSpacing style='text-align:justify'><b><span style='font-size:
                    12.0pt;font-family:"Arial",sans-serif'></span></b></p>

        <p class=MsoNoSpacing style='text-align:justify'><b><span style='font-size:
                    12.0pt;font-family:"Arial",sans-serif'> </span></b><span
                style='font-size:12.0pt;font-family:"Arial",sans-serif'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Failure to comply with
                the lawful order of this Office is tantamount to disobedience. As such, this
                Office will recommend the revocation of your Deputation Order.</span></p>

        <p class=MsoNoSpacing style='text-align:justify'><span style='font-size:12.0pt;
                font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <p class=MsoNoSpacing style='text-align:justify'><span style='font-size:12.0pt;
                font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <p class=MsoNoSpacing style='text-align:justify'><b><span style='font-size:
                    12.0pt;font-family:"Arial",sans-serif'> </span></b><span
                style='font-size:12.0pt;font-family:"Arial",sans-serif;'>{{$compactData['date']}} Quezon
                City, Philippines.</span></p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'> </span></b></p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>

        <p class="MsoNoSpacing" style="text-align: right;">
            <b>
                <span style="font-size:12.0pt;font-family:'Arial',sans-serif;">ATTY. ESTEBAN M. BALTAZAR, JR, CESO V</span>
            </b>
        </p>

        <p class="MsoNoSpacing" style="margin-right:.4in;text-align: center;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <b>
                <span style="font-size:12.0pt;font-family:'Arial',sans-serif;"></span>
            </b>
            <span style="font-size:12.0pt;font-family:'Arial',sans-serif;">
                <i>Director II, Regional Director</i>
            </span>
        </p>

        <p class="MsoNoSpacing" style="text-align: center;">
            <span style="font-size:12.0pt;font-family:'Arial',sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chief, Traffic Adjudication Service</span>
        </p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>

        <p class=MsoNoSpacing><b><span style='font-size:12.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></b></p>

        <p class=MsoNormal><b><span style='font-size:12.0pt;line-height:115%;
                    font-family:"Arial",sans-serif'>Proof of Service</span></b></p>

        <p class=MsoNormal style='text-align:justify'><span style='font-size:12.0pt;
                    line-height:115%;font-family:"Arial",sans-serif'>This is to certify that notice
                of hearing has been duly served and received by: </span></p>

                <p class="MsoNormal">
    <b>
        <u>
            <span style='font-size:12.0pt;line-height:115%;font-family:"Arial",sans-serif'>Name</span>
        </u>
    </b>
    <b>
        <span style='font-size:12.0pt;line-height:115%;font-family:"Arial",sans-serif'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    </b>
    <b>
        <span style='font-size:12.0pt;line-height:115%;font-family:"Arial",sans-serif'><u>Signature</u></span>
    </b>
    <b>
        <span style='font-size:12.0pt;line-height:115%;font-family:"Arial",sans-serif'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    </b>
    <b>
        <span style='font-size:12.0pt;line-height:115%;font-family:"Arial",sans-serif'><u>Date/Time</u></span>
    </b>
    <b>
        <span style='font-size:12.0pt;line-height:115%;font-family:"Arial",sans-serif'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    </b>
    <b>
        <span style='font-size:12.0pt;line-height:115%;font-family:"Arial",sans-serif'>Contact No.</span>
    </b>
</p>

        <p class=MsoNormal><span style='font-size:12.0pt;line-height:115%;font-family:
                    "Arial",sans-serif'>1. A.O/L.O<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;____________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________
                

        <p class=MsoNormal>&nbsp;</p>

        <p class=MsoNormal>&nbsp;</p>

        <p class=MsoNormal><b><span style='font-size:12.0pt;line-height:115%;
                    font-family:"Arial",sans-serif'>&nbsp;</span></b></p>

    </div>

</body>

</html>