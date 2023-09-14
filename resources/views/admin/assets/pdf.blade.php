
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        body {
            margin: 0;
            padding: 0;
            text-align: center; /* Center-align the content */
        }
        .container {
             /* Center-align the container */
            display: inline-block; /* Ensure container doesn't stretch across the page */
        }
    </style>
</head>

<body>
    <center><h1 class="float-center">Bar Codes</h1></center>
    <br><br><br><br><br><br><br>

    <ol style="list-style-type: none;">
        @php
        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        @endphp
        @foreach ($assets as $asset)
        <li>
            <!-- Use a container div to apply styles -->
            <div class="container">
                @php
                    $departCode = $asset->department?$asset->department->code.'-':'';
                    $locationCode = $asset->location?$asset->location->code.'-':'';
                    @endphp
                {!! $generator->getBarcode($departCode.$locationCode.$asset->code, $generator::TYPE_CODE_128) !!}
            </div>
                <br>{{ $departCode.$locationCode.$asset->code }}
            <br><br><br><br><br><br><br>
        </li>
        @endforeach
    </ol>
</body></html>
