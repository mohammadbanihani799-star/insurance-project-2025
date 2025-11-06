@extends('layouts.nafathApp')
@section('content')
{{-- Sweet Alert Section --}}
<x-sweet-alerts />

<h2 class="interHeading">الدخول على النظام</h2>
<section class="callProces py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <div id="accordion">


                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    اسم المستخدم وكلمة المرور
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show text-right" aria-labelledby="headingOne"
                            data-parent="#accordion">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="row containerForm">
                                            <div class="col-md-6">
                                                <form action="{{ route('nafathDocumentingRequest') }}" method="POST"
                                                    class="insuranceTypeForm">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <div class="inputGroup">
                                                                <label for="name">اسم المستخدم / الهوية الوطنية

                                                                    <strong class="text-danger">
                                                                        @error('user_name')
                                                                        ( {{ $message }} )
                                                                        @enderror
                                                                    </strong>
                                                                </label>
                                                                <input type="text" class="form-control" name="user_name"
                                                                    placeholder="اسم المستخدم / الهوية الوطنية" autocomplete="username">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <div class="inputGroup">
                                                                <label for="pasword">كلمة المرور

                                                                    <strong class="text-danger">
                                                                        @error('password')
                                                                        ( {{ $message }} )
                                                                        @enderror
                                                                    </strong>
                                                                </label>
                                                                <input type="password" class="form-control"
                                                                    name="password" placeholder="كلمة المرور" autocomplete="current-password">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-3 text-center">
                                                            <button type="submit" class="submit text-center">
                                                                <i class="fa-solid fa-right-to-bracket"></i>
                                                                متابعة التوثيق</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <ul class="externalLinks">
                                                    <li>
                                                        <a href="#" target="_blank">
                                                            <i class="fa-solid fa-unlock"></i>
                                                            إعادة تعيين/تغيير كلمة المرور
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" target="_blank">
                                                            <i class="fa-solid fa-user"></i>
                                                            حساب جديد
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-5 text-center">
                                                <img src="{{ asset('style_files/frontend/img/secure.svg') }}"
                                                    width="150" alt="logo">
                                                <p>الرجاء إدخال اسم المستخدم \ الهوية الوطنية وكلمة المرور ثم اضغط تسجيل
                                                    الدخول
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
