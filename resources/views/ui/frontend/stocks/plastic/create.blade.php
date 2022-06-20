@extends('ui.frontend.layouts.app')
@push('styles')
    <style>
        .select2-container .select2-selection--single {
            height: 42px;
            border: solid 1px #b4d5ff;
        }
    </style>
@endpush
@section('content')
    <div class="box-shadow">
        <div class="col-12 shadow-lg">
            <div class="py-3">
                <a href="{{ route('frontend.plastic.index') }}">
                    <img src="{{ asset('images/icon/back.png') }}" width="18" height="18">
                </a>
            </div>
            <div class="row justify-content-center">
                <div class="text-header font-size-18 text-active-pink font-weight-500">Form input Plastik</div>
            </div>
        </div>
    </div>
    <div class="bg-grey pt-23 mt-1" style="max-height: 86vh; overflow: scroll; margin-bottom: 30px">
        <div class="container-omyra" style="margin-bottom: 90px;">
            <form action="{{ route('frontend.plastic.store') }}" method="POST" enctype="multipart/form-data"
                id="form-tambah">
                @csrf
                <div class="form-group">
                    <label class="font-weight-500">Tanggal</label>
                    <input type="text" name="date" id="date"
                        class="datepicker form-control font-size-16 form-omyra {{ $errors->has('date') ? 'is-invalid' : '' }}"
                        placeholder="Masukkan Tanggal Plastik Datang" autocomplete="off">
                    @if ($errors->has('date'))
                        <span class="invalid-feedback" role="alert">
                            <p><b>{{ $errors->first('date') }}</b></p>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="font-weight-500">Brand</label>
                    <select
                        class="select2 form-control font-size-16 form-omyra brand-plastic {{ $errors->has('brand') ? 'is-invalid' : '' }}"
                        id="filter-brand" name="product">
                        <option selected disabled>-- Pilih Brand --</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">
                                {{ $brand->name }}
                            </option>
                        @endforeach
                        @if ($errors->has('brand'))
                            <span class="invalid-feedback" role="alert">
                                <p><b>{{ $errors->first('brand') }}</b></p>
                            </span>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label class="font-weight-500">Jenis / Ukuran </label>
                    <select
                        class="select2 form-control font-size-16 form-omyra product-plastic {{ $errors->has('material') ? 'is-invalid' : '' }}"
                        id="filter-material" name="material">
                        <option selected disabled>-- Pilih Brand Dulu --</option>
                    </select>
                </div>
                {{-- <div class="form-group">
                    <label class="font-weight-500">Jenis</label>
                    <select
                        class="select2 form-control font-size-16 form-omyra {{ $errors->has('material') ? 'is-invalid' : '' }}"
                        id="material" name="material">
                        <option selected="selected" disabled>-- Pilih Brand / Ukuran Dulu --</option>
                    </select>
                </div> --}}
                <div class="form-group">
                    <label class="font-weight-500">Jumlah Plastic</label>
                    <input type="number" name="total" id="total"
                        class="form-control font-size-16 form-omyra {{ $errors->has('total') ? 'is-invalid' : '' }}"
                        placeholder="12.000">
                    @if ($errors->has('total'))
                        <span class="invalid-feedback" role="alert">
                            <p><b>{{ $errors->first('total') }}</b></p>
                        </span>
                    @endif
                </div>
                <button class="btn btn-omyra btn-block btn-pink text-white" type="submit">Simpan</button>
                <a class="btn btn-outline-secondary btn-block" href="{{ route('frontend.plastic.index') }}">Kembali</a>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.4/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.4/additional-methods.min.js"></script>
    <script src="{{ asset('assets/lib/jquery/jquery.maskMoney.min.js') }}"></script>
    <script>
        $(function() {
            $("#moneyInput, #money_input, .currency_input, .money").maskMoney({ thousands:'.', decimal:',', affixesStay: false, precision: 0});
            $('.datepicker').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            });

            $('#form-tambah').validate({
                rules: {
                    date: {
                        required: true,
                    },
                    product: {
                        required: true,
                    },
                    material: {
                        required: true,
                    },
                    total: {
                        required: true,
                    },
                },
                messages: {
                    date: {
                        required: "Mohon pilih Tanggal",
                    },
                    product: {
                        required: "Mohon pilih brand / ukuran",
                    },
                    material: {
                        required: "Mohon pilih jenis master",
                    },
                    total: {
                        required: "Mohon masukan total",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('.brand-plastic').on('change', function() {
                let brandId = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('api.get_plastic.by.brand_id', '') }}" + '/' + brandId,
                    dataType: "json",
                    success: function(response) {
                        let html = ``;
                        html +=
                            `<option selected="selected" disabled>-- Pilih Jenis / Ukuran --</option>`;
                        response.data.forEach(item => {
                            html +=
                                `<option value="${ item.id }">${item.name} / ${ item.product.size }</option>`;
                        });
                        $('#filter-material').html(html);
                    }
                });
            });

            $('#product').on('change', function() {
                let productId = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('api.get_plastic.by.product_id', '') }}" + '/' + productId,
                    dataType: "json",
                    success: function(response) {
                        let html = ``;
                        html +=
                            `<option selected="selected" disabled>-- Pilih Jenis Plastic --</option>`;
                        response.materials.forEach(material => {
                            html +=
                                `<option value="${ material.id }">${ material.name }</option>`;
                        });
                        $('#material').html(html);
                    }
                });
            });
        })
    </script>
@endpush
