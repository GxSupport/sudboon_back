@extends('app.layouts')

@section('title', 'Invoice Details')

@section('content')
    <style>

        .card-header.bg-primary {
            background-color: #07006c !important;
            color: white;
        }

        .card-header.bg-success {
            background-color: #413272 !important;
            color: white;
        }

        .card-header.bg-info {
            background-color: #56005c !important;
            color: white;
        }

        .card-header.bg-danger {
            background-color: #01553a !important;
            color: white;
        }

        table.table {
            background-color: #ffffff;
            color: #212529;
        }

        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #f1f1f1;
        }


    </style>

    <div class="container py-5">
        <h1 class="mb-4 text-center">Invoice Details</h1>

        {{-- Section: Unical --}}
        <div class="card mb-4 shadow-lg">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0" >Unical</h2>
                <i class="bi bi-card-checklist" style="font-size: 1.5rem;" ></i>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover table-bordered table-responsive">
                    <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Identifier</th>
                        <th>Contract</th>
                        <th>Invoice</th>
                        <th>Payment Status</th>
                        <th>Pay Status</th>
                        <th>Send PDF</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $data['unical']['id'] }}</td>
                        <td>{{ $data['unical']['identifier'] }}</td>
                        <td>{{ $data['unical']['contract'] }}</td>
                        <td>{{ $data['unical']['invoice'] }}</td>
                        <td>{{ $data['unical']['payment_status'] }}</td>
                        <td>{{ $data['unical']['pay_status'] }}</td>
                        <td>{{ $data['unical']['send_pdf'] }}</td>
                        <td>{{ $data['unical']['created_at'] }}</td>
                        <td>{{ $data['unical']['updated_at'] }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Section: Log Munis --}}
        <div class="card mb-4 shadow-lg">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">Log Munis</h2>
                <i class="bi bi-arrow-repeat" style="font-size: 1.5rem;"></i>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover table-bordered table-responsive">
                    <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Invoice</th>
                        <th>Stage</th>
                        <th>Status</th>
                        <th>Response</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['log_munis'] as $log)
                        <tr>
                            <td>{{ $log['id'] }}</td>
                            <td>{{ $log['invoice'] }}</td>
                            <td>{{ $log['stage'] }}</td>
                            <td>{{ $log['status'] }}</td>
                            <td>{{ $log['response'] }}</td>
                            <td>{{ $log['created_at'] }}</td>
                            <td>{{ $log['updated_at'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Section: Log Pay --}}
        <div class="card mb-4 shadow-lg">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">Log Pay</h2>
                <i class="bi bi-credit-card" style="font-size: 1.5rem;"></i>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover table-bordered table-responsive">
                    <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Invoice</th>
                        <th>Status</th>
                        <th>Response</th>
                        <th>Response Code</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['log_pay'] as $log)
                        <tr>
                            <td>{{ $log['id'] }}</td>
                            <td>{{ $log['invoice'] }}</td>
                            <td>{{ $log['status'] }}</td>
                            <td>{{ $log['response'] }}</td>
                            <td>{{ $log['response_code'] }}</td>
                            <td>{{ $log['created_at'] }}</td>
                            <td>{{ $log['updated_at'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Section: Pay Response OneC --}}
        <div class="card shadow-lg">
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">Pay Response OneC</h2>
                <i class="bi bi-envelope-check" style="font-size: 1.5rem;"></i>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover table-bordered table-responsive">
                    <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Invoice</th>
                        <th>Response</th>
                        <th>Identifier</th>
                        <th>Request</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['pay_responce_onec'] as $pay)
                        <tr>
                            <td>{{ $pay['id'] }}</td>
                            <td>{{ $pay['invoice'] }}</td>
                            <td>{{ $pay['response'] }}</td>
                            <td>{{ $pay['identifier'] }}</td>
                            <td>{{ $pay['request'] }}</td>
                            <td>{{ $pay['created_at'] }}</td>
                            <td>{{ $pay['updated_at'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


