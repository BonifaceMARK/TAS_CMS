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
        .center {
            text-align: center;
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
        /*  */
        /* styles.css */


#openModalBtn {
    padding: 10px 20px;
    font-size: 16px;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-top: 10px;
}

input, textarea {
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 20px;
    width: 100%;
    box-sizing: border-box;
}

    </style>
</head>
<body>
    <button id="openModalBtn" hidden>Open Form</button>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="myForm">
                <h2>Fill out this form</h2>
                <label for="carmakex">CAR MAKE:</label>
                <input type="text" id="carmakex" name="carmakex" >
                <label for="tasdatex">TAS Resolution Date:</label>
                <input type="date" id="tasdatex" name="tasdatex" >
                <label for="crnox">Certificate of Registration No</label>
                <input type="text" id="crnox" name="crnox"  placeholder="(xxxxxxxx)">
                <input type="date" id="crdatex" name="crdatex" >
                <label for="rornox">Registration Official Receipt No:</label>
                <input type="text" id="rornox" name="rornox" >
                <input type="date" id="rordatex" name="rordatex" >
                <label for="orpnox">Official Receipt of Payment No:</label>
                <input type="text" id="orpnox" name="orpnox" >
                <input type="date" id="orpdatex" name="orpdatex" >
                <label for="srnox">Storage Fee Official Receipt No:</label>
                <input type="text" id="srnox" name="srnox" >
                <input type="date" id="srdatex" name="srdatex" >
                <label for="mvirnox">MVIS Inspection Report No. </label>
                <input type="text" id="mvirnox" name="mvirnox" >
                <input type="date" id="mvirdatex" name="mvirdatex" >
                <label for="mrnox">MR No:</label>
                <input type="text" id="mrnox" name="mrnox" >
                <input type="date" id="mrdatex" name="mrdatex" >
                <label for="mrmvdatex">Motion to Release Motor Vehicle Date:</label>
                <input type="date" id="mrmvdatex" name="mrmvdatex" >
                <label for="dateappx">Date of Apprehension:</label>
                <input type="date" id="dateappx" name="dateappx" >

                <button type="submit">FILL OUT</button>
            </form>
        </div>
    </div>


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
                <div class="left"  contenteditable="true">
                    IN RE: MOTION TO RELEASE
                </div>
                <div class="right" style="margin-right: 18%;display: flex;" contenteditable="true">Case No. {{ $compactData['changes']['case_no'] }}</div>
            </div>
            <div class="row">
                <div class="left"  style="font-weight:bold" contenteditable="true">
                    <div style="text-indent: 30px;">
                        <span id="carmake"> </span> WITH<br> &nbsp; &nbsp; &nbsp; &nbsp;Plate No. {{$compactData['changes']['plate_no']}} and<br> &nbsp; &nbsp; &nbsp; &nbsp;Mr/Mrs. {{ $compactData['changes']['driver'] }}
                        
                    </div >
                </div>
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
                        {{ $counter }}. {{ $violation->violation }} <br>
                        <?php $counter++; ?>
                    @endforeach
                    @else
                        No violations recorded.
                    @endif
                    </span></p>
            </div>
            <div class="row">
                <div class="row left" contenteditable="true">
                    Apprehending Officer
                    <br>
                    Name of Respondent Driver
                    <br>
                    Name of Operator
                </div>
                <div class="row left" style="margin-right: 25%;" contenteditable="true">
                   : &nbsp;{{ $compactData['changes']['apprehending_officer'] }}
                    <br>
                   :&nbsp;{{ $compactData['changes']['driver'] }}
                    <br>
                    :&nbsp;Name of Operator
                </div>

            </div >
            <p><b><i>X-------------------------------X</i></b></p>
        </div>
        
        <div class="content">
            <p style="font-family: 'Times New Roman', Times, serif; font-size:16pt; font-weight:bolder;text-align:center;text-decoration: underline;" contenteditable="true">RELEASE ORDER</p>
            
            <p style="text-indent: 30px;" contenteditable="true">Before us is a Motion of the respondent to release above-described motor vehicle and driver’s license after paying the fines of the violations thereof as shown in the attached documents, to wit:</p>
            <div style="margin-left: 50px" contenteditable="true">
                <ul>
                    <li>
                        <b>TAS Resolution approved by the TAS Director dated <span id="tasdate">  </span></b>
                    </li>
                    <li>
                        Certificate of Registration No.<span id="crno"></span> dated <span id="crdate"></span>
                    </li>
                    <li>
                        Registration Official Receipt No. <span id="rorno"> </span> dated <span id="rordate"></span>
                    </li>
                    <li>
                        Official receipt of payment no. <span id="orpno"> </span>  dated <span id="orpdate"> </span> 
                    </li>
                    <li>
                        Storage fee official receipt no. <span id="srno"> </span>  dated <span id="srdate"> </span>
                    </li>    
                    <li>
                        MVIS Inspection Report No. <span id="mvirno"></span> dated <span id="mvirdate"></span> Paid under MR No. <span id="mrno"> </span> dated <span id="mrdate"></span>
                    </li>
                    <li>
                        Motion to Release Motor Vehicle with undertaking dated <span id="mrmvdate"></span>
                    </li>
                    <li>
                        Date of Apprehension:   <span id="dateapp"></span>
                    </li>
                </ul>
            </div>
        
            <p contenteditable="true">Finding the Motion to be meritorious and after the fines of the above-mentioned violations have been paid, the Motion to Release the subject Motor Vehicle and Driver’s License is hereby <span style="text-decoration: underline;"><b><i>GRANTED</i></b>.</span></p>
            <p contenteditable="true" style="text-indent: 30px;"><span style="font-weight:bolder;">WHEREFORE</span>, this Office orders the release of Driver’s License of <b>Mr. {{ $compactData['changes']['driver'] }}</b> and <b><span id="carmaket"></span></b> with Plate no. <b>{{$compactData['changes']['plate_no']}}</b></p>
            <p contenteditable="true" style="text-indent: 30px;font-weight:bolder;">SO ORDERED.</p>
            <p contenteditable="true">Quezon City,&nbsp;{{$compactData['date']}} </p>
        </div>
        <br>
        <div class="signature">
            <p style="font-weight:bolder;" contenteditable="true">ATTY. ESTEBAN M. BALTAZAR JR. CESO V</p>
            <p style="margin-right: 10%;" contenteditable="true"><i>Director II Regional Director</i></p>
            <p style="margin-right: 8%;" contenteditable="true">Chief Traffic Adjudication Service</p>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('myModal');
            const openModalBtn = document.getElementById('openModalBtn');
            const closeBtn = document.getElementsByClassName('close')[0];
        
            function formatDateToMMDDYYYY(date) {
            const d = new Date(date);
            const month = ('0' + (d.getMonth() + 1)).slice(-2);
            const day = ('0' + d.getDate()).slice(-2);
            const year = d.getFullYear();
            return `${month}/${day}/${year}`;
            }
            // Open the modal when the button is clicked
            openModalBtn.onclick = () => {
                modal.style.display = 'block';
            }
        
            // Close the modal when the close button is clicked
            closeBtn.onclick = () => {
                modal.style.display = 'none';
            }
        
            // Close the modal when clicking outside of it
            window.onclick = (event) => {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        
            // Handle form submission
            const form = document.getElementById('myForm');
            form.onsubmit = (event) => {
                event.preventDefault();
        
                // Update span elements with form input values
                document.getElementById('carmake').textContent = document.getElementById('carmakex').value;
                document.getElementById('carmaket').textContent = document.getElementById('carmakex').value;
                document.getElementById('tasdate').textContent = formatDateToMMDDYYYY(document.getElementById('tasdatex').value);
                document.getElementById('crno').textContent = document.getElementById('crnox').value;
                document.getElementById('crdate').textContent = formatDateToMMDDYYYY(document.getElementById('crdatex').value);
                document.getElementById('rorno').textContent = document.getElementById('rornox').value;
                document.getElementById('rordate').textContent = formatDateToMMDDYYYY(document.getElementById('rordatex').value);
                document.getElementById('orpno').textContent = document.getElementById('orpnox').value;
                document.getElementById('orpdate').textContent = formatDateToMMDDYYYY(document.getElementById('orpdatex').value);
                document.getElementById('srno').textContent = document.getElementById('srnox').value;
                document.getElementById('srdate').textContent = formatDateToMMDDYYYY(document.getElementById('srdatex').value);
                document.getElementById('mvirno').textContent = document.getElementById('mvirnox').value;
                document.getElementById('mvirdate').textContent = formatDateToMMDDYYYY(document.getElementById('mvirdatex').value);
                document.getElementById('mrno').textContent = document.getElementById('mrnox').value;
                document.getElementById('mrdate').textContent = formatDateToMMDDYYYY(document.getElementById('mrdatex').value);
                document.getElementById('mrmvdate').textContent = formatDateToMMDDYYYY(document.getElementById('mrmvdatex').value);
                document.getElementById('dateapp').textContent = formatDateToMMDDYYYY(document.getElementById('dateappx').value);

        
                // Close the modal after updating
                modal.style.display = 'none';
        
                // Optionally, you can reset the form after submission
                // form.reset();
            }
        
            // Add event listener for the keyboard shortcut
            document.addEventListener('keydown', (event) => {
                console.log('Key pressed:', event.key);
                if (event.ctrlKey && event.key === 'y') {
                    openModalBtn.click();
                }
            });
    
            // Trigger the hidden button to open the modal for demonstration
            // openModalBtn.click();
        });
    </script>
</body>
</html>
