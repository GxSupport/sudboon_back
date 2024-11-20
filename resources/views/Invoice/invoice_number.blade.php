@extends('app.layouts')

@section('title', 'Find Invoice')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4 text-center text-primary">Find Invoice</h1>

        <!-- Form Section -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Enter Invoice ID</h4>

                        <form method="GET" action="#" id="invoiceForm">
                            <div class="mb-3">
                                <label for="invoice" class="form-label">Invoice ID</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="invoice"
                                    name="invoice"
                                    placeholder="Enter Invoice ID"
                                    required
                                    aria-describedby="invoiceHelp"
                                >
                                <div id="invoiceHelp" class="form-text">Please enter the invoice ID to access the details.</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Go to Invoice</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Warning Message (Optional) -->
        <div id="message" class="alert alert-warning mt-4 d-none" role="alert">
            Please enter a valid Invoice ID.
        </div>
    </div>

    <script>
        document.getElementById('invoiceForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const invoiceId = document.getElementById('invoice').value;

            if (invoiceId) {
                // Dynamically generate the route URL with the invoice ID
                const url = "{{ route('invoiceInfos', ['invoice' => ':id']) }}".replace(':id', invoiceId);
                window.location.href = url; // Redirect to the dynamically generated URL
            } else {
                document.getElementById('message').classList.remove('d-none'); // Show warning message
                setTimeout(() => {
                    document.getElementById('message').classList.add('d-none'); // Hide message after a while
                }, 3000);
            }
        });
    </script>
@endsection
