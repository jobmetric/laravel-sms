<?php

namespace JobMetric\Sms\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use JobMetric\Panelio\Facades\Breadcrumb;
use JobMetric\Panelio\Facades\Button;
use JobMetric\Panelio\Facades\Datatable;
use JobMetric\Panelio\Http\Controllers\Controller;
use JobMetric\Sms\Facades\SmsGateway;
use JobMetric\Sms\Http\Requests\GetFieldsRequest;
use JobMetric\Sms\Http\Requests\StoreSmsGatewayRequest;
use JobMetric\Sms\Http\Requests\UpdateSmsGatewayRequest;
use JobMetric\Sms\Http\Resources\SmsGatewayResource;
use JobMetric\Sms\Models\SmsGateway as SmsGatewayModel;
use Throwable;

class SmsGatewayController extends Controller
{
    private array $route;

    public function __construct()
    {
        if (request()->route()) {
            $parameters = request()->route()->parameters();

            $this->route = [
                'index' => route('sms.sms-gateway.index', $parameters),
                'create' => route('sms.sms-gateway.create', $parameters),
                'store' => route('sms.sms-gateway.store', $parameters),
                'options' => route('sms.sms-gateway.options', $parameters),
                'getFields' => route('sms.sms-gateway.get-fields', $parameters),
            ];
        }
    }

    /**
     * Display a listing of the sms gateway.
     *
     * @param string $panel
     * @param string $section
     *
     * @return View|JsonResponse
     * @throws Throwable
     */
    public function index(string $panel, string $section): View|JsonResponse
    {
        if (request()->ajax()) {
            $query = SmsGateway::query();

            return Datatable::of($query, resource_class: SmsGatewayResource::class);
        }

        $title = trans('sms::base.list.sms_gateway.title');

        DomiTitle($title);

        // Add breadcrumb
        add_breadcrumb_base($panel, $section);
        Breadcrumb::add($title);

        // add button
        Button::add($this->route['create']);
        Button::delete();

        // @todo: make default button

        DomiLocalize('sms_gateway', [
            'route' => $this->route['index'],
        ]);

        DomiScript('assets/vendor/sms/js/sms_gateway/list.js');

        $data['route'] = $this->route['options'];

        return view('sms::sms_gateway.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string $panel
     * @param string $section
     *
     * @return View
     */
    public function create(string $panel, string $section): View
    {
        $data['mode'] = 'create';

        $title_list = trans('sms::base.list.sms_gateway.title');
        $title = trans('sms::base.form.sms_gateway.create.title');

        DomiTitle($title);

        // Add breadcrumb
        add_breadcrumb_base($panel, $section);
        Breadcrumb::add($title_list, $this->route['index']);
        Breadcrumb::add($title);

        // add button
        Button::save();
        Button::saveNew();
        Button::saveClose();
        Button::cancel($this->route['index']);

        DomiLocalize('sms_gateway', [
            'getFields' => $this->route['getFields'],
        ]);

        DomiScript('assets/vendor/sms/js/sms_gateway/form.js');

        $data['action'] = $this->route['store'];

        $data['drivers'] = [];
        foreach (getDriverNames(config('sms.namespaces')) as $driver) {
            $data['drivers'][] = [
                'value' => $driver,
                'name' => (new $driver)->getDriverName(),
            ];
        }

        return view('sms::sms_gateway.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSmsGatewayRequest $request
     * @param string $panel
     * @param string $section
     *
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(StoreSmsGatewayRequest $request, string $panel, string $section): RedirectResponse
    {
        $form_data = $request->all();

        $sms_gateway = SmsGateway::store($request->validated());

        if ($sms_gateway['ok']) {
            $this->alert($sms_gateway['message']);

            if ($form_data['save'] == 'save.new') {
                return back();
            }

            if ($form_data['save'] == 'save.close') {
                return redirect()->to($this->route['index']);
            }

            // btn save
            return redirect()->route('sms.sms_gateway.edit', [
                'panel' => $panel,
                'section' => $section,
                'sms_gateway' => $sms_gateway['data']->id
            ]);
        }

        $this->alert($sms_gateway['message'], 'danger');

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $panel
     * @param string $section
     * @param SmsGatewayModel $sms_gateway
     *
     * @return View
     */
    public function edit(string $panel, string $section, SmsGatewayModel $sms_gateway): View
    {
        $data['mode'] = 'edit';

        $title_list = trans('sms::base.list.sms_gateway.title');
        $title = trans('sms::base.form.sms_gateway.edit.title');

        DomiTitle($title);

        // Add breadcrumb
        add_breadcrumb_base($panel, $section);
        Breadcrumb::add($title_list, $this->route['index']);
        Breadcrumb::add($title);

        // add button
        Button::save();
        Button::saveNew();
        Button::saveClose();
        Button::cancel($this->route['index']);

        DomiLocalize('sms_gateway', [
            'getFields' => $this->route['getFields']
        ]);

        DomiScript('assets/vendor/sms/js/sms_gateway/form.js');

        $data['action'] = route('sms.sms-gateway.update', [
            'panel' => $panel,
            'section' => $section,
            'sms_gateway' => $sms_gateway->id
        ]);

        $data['sms_gateway'] = $sms_gateway;

        $data['drivers'] = [];
        foreach (getDriverNames(config('sms.namespaces')) as $driver) {
            $data['drivers'][] = [
                'value' => $driver,
                'name' => (new $driver)->getDriverName(),
            ];
        }

        return view('sms::sms_gateway.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSmsGatewayRequest $request
     * @param string $panel
     * @param string $section
     * @param SmsGatewayModel $sms_gateway
     *
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(UpdateSmsGatewayRequest $request, string $panel, string $section, SmsGatewayModel $sms_gateway): RedirectResponse
    {
        $form_data = $request->all();

        $sms_gateway = SmsGateway::update($sms_gateway->id, $request->validated());

        if ($sms_gateway['ok']) {
            $this->alert($sms_gateway['message']);

            if ($form_data['save'] == 'save.new') {
                return redirect()->to($this->route['create']);
            }

            if ($form_data['save'] == 'save.close') {
                return redirect()->to($this->route['index']);
            }

            // btn save
            return redirect()->route('sms.sms_gateway.edit', [
                'panel' => $panel,
                'section' => $section,
                'sms_gateway' => $sms_gateway['data']->id
            ]);
        }

        $this->alert($sms_gateway['message'], 'danger');

        return back();
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param array $ids
     * @param mixed $params
     * @param string|null $alert
     * @param string|null $danger
     *
     * @return bool
     * @throws Throwable
     */
    public function deletes(array $ids, mixed $params, string &$alert = null, string &$danger = null): bool
    {
        try {
            foreach ($ids as $id) {
                SmsGateway::delete($id);
            }

            $alert = trans_choice('sms::base.messages.sms_gateway.deleted_items', count($ids));

            return true;
        } catch (Throwable $e) {
            $danger = $e->getMessage();

            return false;
        }
    }

    /**
     * Change Default the specified resource from storage.
     *
     * @param array $ids
     * @param bool $value
     * @param string|null $alert
     * @param string|null $danger
     *
     * @return bool
     * @throws Throwable
     */
    public function changeDefault(array $ids, bool $value, string &$alert = null, string &$danger = null): bool
    {
        try {
            foreach ($ids as $id) {
                SmsGateway::update($id, ['status' => $value]);
            }

            if ($value) {
                $alert = trans_choice('taxonomy::base.messages.status.enable', count($ids));
            } else {
                $alert = trans_choice('taxonomy::base.messages.status.disable', count($ids));
            }

            return true;
        } catch (Throwable $e) {
            $danger = $e->getMessage();

            return false;
        }
    }

    /**
     * Get fields in driver.
     *
     * @param GetFieldsRequest $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function getFields(GetFieldsRequest $request): JsonResponse
    {
        try {
            return $this->response(
                SmsGateway::getFields($request->driver, $request->sms_gateway)
            );
        } catch (Throwable $exception) {
            return $this->response(message: $exception->getMessage(), status: $exception->getCode());
        }
    }
}
