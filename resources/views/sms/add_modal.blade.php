<div class="row fv-row">
    <div class="col">
        <div class="row">
            <div class="col-8">
                <input type="number" id="add-sms-mobile" autocomplete="off" class="form-control me-3 flex-grow-1" min="0" placeholder="{{ trans('sms::base.list.sms.add_modal.fields.mobile.placeholder') }}"/>
            </div>
            <div class="col-4">
                <select id="add-sms-mobile-prefix" class="form-control btn-light fw-bold flex-shrink-0">
                    @foreach($countries as $country)
                        <option value="{{ $country->mobile_prefix }}">{{ $country->mobile_prefix }} ({{ $country->name }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <span class="text-danger fs-7 form-error" id="error-add-sms-mobile"></span>
            </div>
        </div>

        <div class="row my-10">
            <div class="col-12">
                <textarea id="add-sms-note" cols="30" rows="10" class="form-control me-3 flex-grow-1" placeholder="{{ trans('sms::base.list.sms.add_modal.fields.note.placeholder') }}"></textarea>
            </div>
            <div class="col-12">
                <span class="text-danger fs-7 form-error" id="error-add-sms-note"></span>
            </div>
        </div>
    </div>
</div>

<div class="row fv-row">
    <div class="col">
        <button type="button" class="btn btn-primary w-100" onclick="sms.send(this, event)">{{ trans('panelio::base.button.send') }}</button>
    </div>
</div>
