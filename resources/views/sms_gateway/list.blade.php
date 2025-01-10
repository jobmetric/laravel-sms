@extends('panelio::layout.layout')

@section('body')
    <x-list-view name="{{ trans('sms::base.list.sms_gateway.title') }}" action="{{ $route }}">
        <x-slot name="filter">
            <div class="col-md-3">
                <div class="mb-5">
                    <label class="form-label">{{ trans('sms::base.list.sms_gateway.filters.name.title') }}</label>
                    <input type="text" name="name" class="form-control filter-list" id="filter-name" placeholder="{{ trans('sms::base.list.sms_gateway.filters.name.placeholder') }}" autocomplete="off">`
                </div>
            </div>
        </x-slot>

        <thead>
            <tr>
                <th width="1%">
                    <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" value="1" id="check-all"/>
                        <label class="form-check-label ms-0" for="check-all"></label>
                    </div>
                </th>
                <th width="45%" class="text-gray-800 auto-width-content">{{ trans('package-core::base.list.columns.name') }}</th>
                <th width="29%" class="text-center text-gray-800">{{ trans('package-core::base.list.columns.driver') }}</th>
                <th width="10%" class="text-center text-gray-800">{{ trans('package-core::base.list.columns.default') }}</th>
                <th width="15%" class="text-center text-gray-800">{{ trans('package-core::base.list.columns.action') }}</th>
            </tr>
        </thead>
    </x-list-view>

    <div class="mt-10">
        <h6>{{ trans('sms::base.list.sms_gateway.description') }}</h6>
    </div>
@endsection
