<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@push('head')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .input{
            width: 100%;
            height: 35px;
            border: 1px solid #c7c5c5;
            border-radius: 5px;
            outline: none;
            padding: 0 10px;
        }

        .swal2-popup {
            font-size: 17px !important;
            color: rgb(0, 0, 0) !important;
        }

        .qr_status{
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
            z-index: 1;
            text-align: center;
            font-size: 20px;
        }
    </style>
@endpush
@section('content')
  <!-- Your html goes here -->
    <p><a title='Return' href='{{ CRUDBooster::mainpath() }}'><i class='fa fa-chevron-circle-left '></i>&nbsp; Back To Redemption Code History</a></p>
    <div class='panel panel-default'>
        <div class='panel-heading'>Edit Form</div>
        <div class='panel-body'>
            <form method='post' action='{{CRUDBooster::mainpath('edit-save/'.$row->id)}}'>
                @csrf
                <input class="hidden" type="text" name="uploaded_img" value="{{ $row->uploaded_img }}">
                <input class="hidden" type="text" name="campaign_id" value="{{ $row->campaign_id }}">
                @if ($row->accounting_is_audit)
                <div class="qr_status" style="background-color: rgb(31,114,183);">Closed</div>
                @else
                <div class="qr_status" style="background-color: rgb(74 222 128);">Claimed</div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <table class="table default-table-design">
                            <tr>
                                <td class="text-center table-label"> Name:</td>
                                <td style="width: 200px;">
                                    <input class="input" type="text" value="{{ $row->claimed_by ? $row->claimed_by : $row->name }}" disabled>
                                </td>
                                <td class="text-center table-label"> Email:</td>
                                <td style="width: 200px;">
                                    <input class="input" type="text" value="{{ $row->claimed_email ? $row->claimed_email : $row->email }}" disabled>
                                </td>
                            </tr>
                            <tr>
                                {{-- <label for=""> Campaign ID:</label> --}}
                                <td class="text-center table-label"> Phone Number:</td>
                                <td style="width: 200px;">
                                    <input class="input" type="text" value="{{ $row->phone }}" disabled>
                                </td>
                                <td class="text-center table-label"> GC Description:</td>
                                <td style="width: 200px;">
                                    <input class="input" type="text" value="{{ $row->gc_description ? $row->gc_description : 'EGC Purchased in the store' }}" disabled>
                                </td>
                            </tr>
                            <tr>
                                {{-- <label for=""> Campaign ID:</label> --}}
                                <td class="text-center table-label"> GC Value:</td>
                                <td style="width: 200px;">
                                    <input class="input" type="text" value="{{ $row->gc_value }}" disabled>
                                </td>
                                <td class="text-center table-label">{{ $row->batch_number ? 'Batch Number:' : '' }}</td>
                                <td style="width: 200px;">
                                    @if ($row->batch_number)
                                    <input class="input" type="text" value="{{ $row->batch_number }}" disabled>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                {{-- <label for=""> Campaign ID:</label> --}}
                                <td class="text-center table-label"> ID Type:</td>
                                <td style="width: 200px;">
                                    <input class="input" type="text" value="{{ $row->valid_ids }}" disabled>
                                </td>
                                <td class="text-center table-label"> Goverment#:</td>
                                <td style="width: 200px;">
                                    <input class="input" type="text" value="{{ $row->id_number }}" disabled>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="table default-table-design">
                            <tr>
                                {{-- <label for=""> Campaign ID:</label> --}}
                                <td class="text-center table-label"> QR Reference #:</td>
                                <td style="width: 200px;">
                                    <input class="input" type="text" value="{{ $row->campaign_id ? $row->campaign_id : 'In-store EGC' ." - ".$row->qr_reference_number }}" disabled>
                                </td>
                                <td class="text-center table-label"> POS Invoice #:</td>
                                <td style="width: 200px;">
                                    <input class="input" type="text" value="{{ $row->invoice_number }}" disabled>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="">Uploaded Receipt:</label>
                        <img src="{{ asset('uploaded_item/img/'.$row->uploaded_img) }}" alt="" style="margin: 15px 0; width: 100%; max-height: 500px; object-fit: contain;">
                    </div>
                </div>
                <input id="close_btn_original" type='submit' class='btn btn-primary hide' id="submit_form" value='close'/>
            </form>
        </div>
        <div class='panel-footer'>
            <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default" style="border: 1px solid #ddd;">Cancel</a>
            @if (!$row->accounting_is_audit)
            <input id="close_btn" type='submit' class='btn btn-primary' value='Close'/>
            @endif
        </div>
    </div>

    <script>

        $('#close_btn').on('click', function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!',
                returnFocus: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#close_btn_original').click();
                }
            })
        })
    </script>
@endsection