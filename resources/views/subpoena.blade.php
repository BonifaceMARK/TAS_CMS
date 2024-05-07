<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Page</title>
    <style>
        /* Define page dimensions */
        @page {
            size: 8.5in 14in;
            margin: 0;
        }
        /* Define content dimensions */
        body {
            top: 0.81in;
            left: 1.13in;
            bottom: 1in;
            right: 1.06in;
            width: 8.5in;
            height: 14in;
            margin: 0;
            padding: 0;
            display: flex; 
            justify-content: center;
             align-items: center;
            background-color: #f0f0f0;
        }
        .content {
            top: 0.81in;
            left: 1.13in;
            bottom: 1in;
            right: 1.06in;
            font-family: :Arial, Helvetica, sans-serif;
            justify-content: center;
            /* text-align: center; */
        }
        .bagongp {
            top:.81in;
            margin-left: 1.3in;
            width: 0.8in;
            height: 0.85in;
            position: absolute;
        }
        .bagongp2 {
            top:.81in;
            margin-left: 2.1in;
            width: 0.8in;
            height: 0.85in;
            position: absolute;
        }
    </style>
</head>
<body>
    <div >
        <img class="bagongp" src="{{ asset('assets/img/bagong_pilipinas.png') }}" alt="Bagong Pilipinas"> 
        <img class="bagongp2"src="{{asset('assets/img/LTO.png')}}" alt="LTO">
    </div>
    <div class="content">
        
            <p style="font-family: Arial, sans-serif; font-size: 12px; left:20pt;">Republic of the Philippines</p>
            <p style="font-family: Arial, sans-serif; font-size: 12px;">Department of Transportation</p>
            <p style="font-family: Arial, sans-serif; font-size: 14px;">LAND TRANSPORTATION OFFICE</p>
            <p style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12pt;">TRAFFIC ADJUDICATION SERVICE</p>
        

    </div>
</body>
</html>