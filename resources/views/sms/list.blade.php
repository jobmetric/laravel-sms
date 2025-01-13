@extends('panelio::layout.layout')

@section('body')
    <x-list-view name="{{ trans('sms::base.list.sms.title') }}" action="{{ $route }}">
        <x-slot name="filter">
            <div class="col-md-3">
                <div class="mb-5">
                    <label class="form-label">{{ trans('sms::base.list.sms.filters.note.title') }}</label>
                    <input type="text" name="note" class="form-control filter-list" id="filter-note" placeholder="{{ trans('sms::base.list.sms.filters.note.placeholder') }}" autocomplete="off">`
                </div>
            </div>
        </x-slot>

        <thead>
            <tr>
                <th width="1%"></th>
                <th width="4%" class="text-center text-gray-800 auto-width-content">{{ trans('package-core::base.list.columns.id') }}</th>
                <th width="35%" class="text-start text-gray-800">{{ trans('sms::base.list.sms.columns.note') }}</th>
                <th width="18%" class="text-center text-gray-800">{{ trans('package-core::base.list.columns.user') }}</th>
                <th width="15%" class="text-center text-gray-800">{{ trans('sms::base.list.sms.columns.mobile') }}</th>
                <th width="12%" class="text-center text-gray-800">{{ trans('package-core::base.list.columns.status') }}</th>
                <th width="15%" class="text-center text-gray-800">{{ trans('sms::base.list.sms.columns.created_at') }}</th>
            </tr>
        </thead>
    </x-list-view>

    <div class="mt-10">
        <h6>{{ trans('sms::base.list.sms.description') }}</h6>
    </div>
@endsection
