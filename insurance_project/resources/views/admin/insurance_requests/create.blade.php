@extends('admin.layouts.app')

@section('content')
{{-- =========================================================== --}}
{{-- =================== Page Header Section =================== --}}
{{-- =========================================================== --}}
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-5 align-self-center">
            <h3 class="page-title">إضافة طلب تأمين جديد</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('super_admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('super_admin.insurance_requests-index') }}">Insurance Requests</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================== --}}
{{-- ==================== Page Body Section =================== --}}
{{-- ========================================================== --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">معلومات طلب التأمين</h4>

                    <form action="{{ route('super_admin.insurance_requests-store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Insurance Selection --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="insurance_id" class="form-label">نوع التأمين <span class="text-danger">*</span></label>
                                <select class="form-select @error('insurance_id') is-invalid @enderror"
                                        id="insurance_id"
                                        name="insurance_id"
                                        required>
                                    <option value="">-- اختر نوع التأمين --</option>
                                    @if(isset($insurances))
                                        @foreach($insurances as $insurance)
                                            <option value="{{ $insurance->id }}" {{ old('insurance_id') == $insurance->id ? 'selected' : '' }}>
                                                {{ $insurance->insurance_name_ar }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('insurance_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Customer Information --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label">اسم العميل <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('customer_name') is-invalid @enderror"
                                       id="customer_name"
                                       name="customer_name"
                                       value="{{ old('customer_name') }}"
                                       required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="customer_phone" class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('customer_phone') is-invalid @enderror"
                                       id="customer_phone"
                                       name="customer_phone"
                                       value="{{ old('customer_phone') }}"
                                       required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="customer_national_id" class="form-label">رقم الهوية الوطنية <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('customer_national_id') is-invalid @enderror"
                                       id="customer_national_id"
                                       name="customer_national_id"
                                       value="{{ old('customer_national_id') }}"
                                       required>
                                @error('customer_national_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">
                                    <i data-feather="save" class="feather-sm me-1"></i> حفظ
                                </button>
                                <a href="{{ route('super_admin.insurance_requests-index') }}" class="btn btn-secondary">
                                    <i data-feather="x" class="feather-sm me-1"></i> إلغاء
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
