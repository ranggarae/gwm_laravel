@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('Register')}}
@endsection
@section('content')
    <section class="login-page-wrapper padding-top-120 padding-bottom-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="login-form-wrapper">
                        <h2>{{__('Register New Account')}}</h2>
                        @include('backend.partials.message')
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{route('user.register')}}" method="post" enctype="multipart/form-data" class="account-form">
                            @csrf
                            
                            <div class="form-group">
                                <label><strong>{{__('Tipe Akun')}}</strong></label><br>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="account_type" id="type_perorangan" value="perorangan" checked>
                                  <label class="form-check-label" for="type_perorangan">Perorangan (Mitra)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="account_type" id="type_perusahaan" value="perusahaan">
                                  <label class="form-check-label" for="type_perusahaan">Perusahaan</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="{{__('Nama Lengkap / Nama PIC')}}">
                            </div>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" placeholder="{{__('Username')}}">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="{{__('Email')}}">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="{{__('Password')}}">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="{{__('Confirm Password')}}">
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control" placeholder="{{__('No. Handphone / Telepon')}}">
                            </div>
                            <div class="form-group">
                                <textarea name="address" class="form-control" placeholder="{{__('Alamat Lengkap')}}" rows="3"></textarea>
                            </div>

                            <!-- Bidang Perorangan -->
                            <div id="perorangan_fields">
                                <h4 class="mt-4 mb-3">{{__('Data Pribadi (Mitra)')}}</h4>
                                <div class="form-group">
                                    <input type="text" name="nik" class="form-control" placeholder="{{__('NIK (Nomor Induk Kependudukan)')}}">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Upload Foto KTP (Maks 2MB)')}}</label>
                                    <input type="file" name="ktp_image" class="form-control" accept="image/*">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Upload Foto Selfie dengan KTP (Maks 2MB)')}}</label>
                                    <input type="file" name="selfie_image" class="form-control" accept="image/*">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Upload Foto SIM (Maks 2MB)')}}</label>
                                    <input type="file" name="sim_image" class="form-control" accept="image/*">
                                </div>
                            </div>

                            <!-- Bidang Perusahaan -->
                            <div id="perusahaan_fields" style="display: none;">
                                <h4 class="mt-4 mb-3">{{__('Data Perusahaan')}}</h4>
                                <div class="form-group">
                                    <input type="text" name="company_name" class="form-control" placeholder="{{__('Nama Perusahaan')}}">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="company_npwp" class="form-control" placeholder="{{__('NPWP Perusahaan')}}">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="company_nib" class="form-control" placeholder="{{__('NIB / SIUP Perusahaan')}}">
                                </div>
                            </div>

                            <div class="form-group btn-wrapper mt-4">
                                <button type="submit" class="submit-btn">{{__('Register')}}</button>
                            </div>
                            <div class="row mb-4 rmber-area">
                                <div class="col-12 text-center">
                                    <a href="{{route('user.login')}}">{{__('Already Have account?')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radioPerorangan = document.getElementById('type_perorangan');
            const radioPerusahaan = document.getElementById('type_perusahaan');
            const peroranganFields = document.getElementById('perorangan_fields');
            const perusahaanFields = document.getElementById('perusahaan_fields');

            function toggleFields() {
                if (radioPerusahaan.checked) {
                    peroranganFields.style.display = 'none';
                    perusahaanFields.style.display = 'block';
                } else {
                    peroranganFields.style.display = 'block';
                    perusahaanFields.style.display = 'none';
                }
            }

            radioPerorangan.addEventListener('change', toggleFields);
            radioPerusahaan.addEventListener('change', toggleFields);
            
            // initial call
            toggleFields();
        });
    </script>
@endsection
