@extends('panelio::layout.layout')

@section('body')
    <form method="post" action="{{ $action }}" class="form d-flex flex-column flex-lg-row" id="form">
        @csrf
        @if($mode === 'edit')
            @method('put')
        @endif
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab_general">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::Information-->
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <span class="fs-5 fw-bold">{{ trans('package-core::base.cards.proprietary_info') }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-10">
                                    <label class="form-label">{{ trans('sms::base.form.sms_gateway.fields.name.title') }}</label>
                                    <input type="text" name="name" class="form-control mb-2" placeholder="{{ trans('sms::base.form.sms_gateway.fields.name.placeholder') }}" value="{{ old('name', $sms_gateway->name ?? null) }}">
                                    @error('name')
                                        <div class="form-errors text-danger fs-7 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-10">
                                    <label class="form-label">{{ trans('sms::base.form.sms_gateway.fields.driver.title') }}</label>
                                    <select name="driver" class="form-select" data-control="select2">
                                        <option value="">{{ trans('package-core::base.select.none') }}</option>
                                        @foreach($drivers as $driver)
                                            <option value="{{ $driver }}" @if(old('driver', $sms_gateway->driver ?? null) == $driver) selected @endif>{{ $driver }}</option>
                                        @endforeach
                                    </select>
                                    @error('driver')
                                        <div class="form-errors text-danger fs-7 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!--end::Information-->

                        @php
                            $driver = old('driver', $sms_gateway->driver ?? null);
                        @endphp

                        @if($driver)
                            @php
                                $driverClass = new $driver;
                                $fields = $driverClass->getFields();

                                foreach ($fields as $field_key => $field_trans_key) {
                                    $field_data[$field_key]['title'] = trans($field_trans_key);
                                    $field_data[$field_key]['value'] = old('fields.' . $field_key, $sms_gateway->fields[$field_key] ?? null);
                                }
                            @endphp
                            <!--begin::Driver Fields-->
                            <div class="card card-flush py-4 mb-10" id="box-driver-fields">
                                <div class="card-header">
                                    <div class="card-title">
                                        <span class="fs-5 fw-bold">{{ trans('sms::base.form.sms_gateway.cards.driver_fields') }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @foreach($field_data as $field_key => $field)
                                        <div class="mb-10">
                                            <label class="form-label">{{ $field['title'] }}</label>
                                            <input type="text" name="fields[{{ $field_key }}]" class="form-control mb-2" value="{{ $field['value'] }}">
                                            @error('fields.' . $field_key)
                                                <div class="form-errors text-danger fs-7 mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!--end::Driver Fields-->
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
