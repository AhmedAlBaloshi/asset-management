<html>
    <head>
        <title>Asset by Value</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    </head>
    <body onload="window.print()">
        <div class="container">
            <div class="row">
                <div class="col-md-12" align="center">
                    <h3>{{ $company->company_name ?? '' }}</h3>
                    <strong>Asset by Value</strong>
                    <hr/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($assets as $asset)
                                <tr>
                                    <td>@php echo $i; @endphp</td>
                                    <td>{{ $asset->code }}</td>
                                    <td>{{ $asset->name }}</td>
                                    <td align="right">{{ number_format($asset->quantity,2) }}</td>
                                    <td align="right">{{ number_format($asset->unit_price,2) }}</td>
                                    <td align="right">{{ number_format($asset->total,2) }}</td>
                                </tr>
                                @php $i+=1; @endphp
                                @endforeach                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" align="right"><strong>Total</strong></td>
                                    <td align="right"><strong>{{ number_format($total,2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>