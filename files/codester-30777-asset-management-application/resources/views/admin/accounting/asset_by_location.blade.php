<html>
    <head>
        <title>Asset by Location</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    </head>
    <body onload="window.print()">
        <div class="container">
            <div class="row">
                <div class="col-md-12" align="center">
                    <h3>{{ $company->company_name ?? '' }}</h3>
                    <strong>Asset by Location</strong>
                    <hr/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>                                    
                                    <th>{{ trans('global.code') }}</th>
                                    <th>{{ trans('global.name') }}</th>
                                    <th>{{ trans('global.quantity') }}</th>
                                    <th>{{ trans('global.unit_price') }}</th>
                                    <th>{{ trans('global.total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($asset_locations as $assetLocation)
                                <!-- sumTotalOnDepartment -->
                                @php $sumTotalOnDepartment = 0; @endphp
                                    <tr>
                                        <td colspan="5">{{ trans('global.location') }} : <strong>{{ $assetLocation->name }}</strong></td>
                                    </tr>
                                    @php
                                        $getAssetsByLocation = \App\Http\Controllers\Admin\AccountingController::getAssetsByLocation($assetLocation->id);
                                    @endphp
                                    @foreach ($getAssetsByLocation as $gabl)
                                        <tr>
                                            <td>{{ $gabl->code }}</td>
                                            <td>{{ $gabl->name }}</td>
                                            <td align="right">{{ number_format($gabl->quantity,2) }}</td>
                                            <td align="right">{{ number_format($gabl->unit_price,2) }}</td>
                                            <td align="right">@php $sumTotal=$gabl->quantity * $gabl->unit_price; echo number_format($sumTotal,2); @endphp</td>
                                        </tr>
                                        @php $sumTotalOnDepartment+=$sumTotal; @endphp
                                    @endforeach
                                    @php
                                        $getTotalAssetsByLocation = \App\Http\Controllers\Admin\AccountingController::getTotalAssetsByLocation($assetLocation->id);
                                    @endphp
                                    <tr>
                                        <td colspan="4" align="right"><strong>Total</strong></td>
                                        <td align="right"><strong>@php echo number_format($sumTotalOnDepartment,2); @endphp</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>