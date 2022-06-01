@extends('admin.include.app')

@section('title', 'List Coupon')

@section('css')
<style>
    .table td,
    .table th {
        min-width: 80px;
        text-align: center;
    }
</style>
@endsection

@section('content')

<!--**********************************
        Content body start
    ***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('coupon.index') }}">Manage Coupon</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('coupon.index') }}">List Coupon</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Coupon</h4>
                        <a class="btn btn-info ml-4 mt-4" href="{{ route('coupon.create') }}">Add Coupon</a>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">

                                <thead>
                                    <tr>
                                        <th>Serial No</th>
                                        <th>Coupon Title</th>
                                        <th>Coupon Code</th>
                                        <th>Dis. Type</th>
                                        <th>Dis. Amount</th>
                                        <th>Status</th>
                                        <th>Usable Per Person</th>
                                        <th>Usable In Total</th>
                                        <th>Coupon Start On</th>
                                        <th>Coupon Ends On</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $coupon->coupon_title }}</td>
                                            <td>{{ $coupon->coupon_code }}</td>
                                            <td>{{ $coupon->discount_type }}</td>
                                            <td>{{ $coupon->discount_amount }}</td>
                                            <td>
                                                @if ($coupon->coupon_status == "Active")
                                                    <button id="status{{ $coupon->id }}" onclick="chnageStatus({{ $coupon->id }})" class="badge badge-success px-2">
                                                        Active
                                                    </button>
                                                @else
                                                    <button id="status{{ $coupon->id }}" onclick="chnageStatus({{ $coupon->id }})" class="badge badge-danger px-2">
                                                        Inactive
                                                    </button>
                                                @endif
                                            </td>
                                            <td>{{ $coupon->usable_per_person ?: "0" }}</td>
                                            <td>{{ $coupon->usable_in_total ?: "0" }}</td>
                                            <td>{{ $coupon->coupon_start_date ? date('d-m-Y', strtotime($coupon->coupon_start_date)) : "NULL" }}</td>
                                            <td>{{ $coupon->coupon_end_date ? date('d-m-Y', strtotime($coupon->coupon_end_date)) : "NULL" }}</td>
                                            <td>
                                                {{ date('d-m-Y', strtotime($coupon->created_at)) }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">

                                                    <a class="btn btn-info btn-xs mr-2" href="{{ route('coupon.edit', $coupon->id) }}">Edit</a>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="basicModal{{ $coupon->id }}">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete Coupon</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">Are you sure to delete <b>"{{ $coupon->coupon_title }}"</b> Coupon? </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('coupon.destroy', $coupon->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Not Yet</button>
                                                                        <button type="submit" class="btn btn-primary">Confirm</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Button trigger modal -->
                                                    <button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#basicModal{{ $coupon->id }}">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Serial No</th>
                                        <th>Coupon Title</th>
                                        <th>Coupon Code</th>
                                        <th>Dis. Type</th>
                                        <th>Dis. Amount</th>
                                        <th>Status</th>
                                        <th>Usable Per Person</th>
                                        <th>Usable In Total</th>
                                        <th>Coupon Start On</th>
                                        <th>Coupon Ends On</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
            Content body end
        ***********************************-->
@endsection

@section('javascript')

<script>
    function chnageStatus(coupon_id) {
        $(function() {
            var statusBtn = $(`#status${coupon_id}`);
            var statusText = statusBtn.text();
            $.ajax({
                url: "{{ route('coupon.updateStatus') }}",
                type: "post",
                data: {
                    coupon_id,
                    statusText: statusText === "Active" ? "Inactive" : "Active",
                    _token: "{{ csrf_token() }}"
                },
                success: function(result) {
                    if (result) {
                        if (statusText === "Active") {
                            statusBtn.text("Inactive");
                            statusBtn.removeClass("badge-success");
                            statusBtn.addClass("badge-danger");
                        } else {
                            statusBtn.text("Active");
                            statusBtn.removeClass("badge-danger");
                            statusBtn.addClass("badge-success");
                        }
                    }
                }
            });
        });
    }
</script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })


    @if (session()->has('success'))
        Toast.fire({
        icon: 'success',
        title: '{{ session('success') }}'
        })
    @endif
    
</script>

@endsection