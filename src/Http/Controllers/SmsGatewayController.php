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
use JobMetric\Sms\Http\Resources\SmsGatewayResource;
use JobMetric\Sms\Http\Requests\StoreSmsGatewayRequest;
use JobMetric\Sms\Http\Requests\UpdateSmsGatewayRequest;
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
                'index' => route('sms.sms_gateway.index', $parameters),
                'create' => route('sms.sms_gateway.create', $parameters),
                'store' => route('sms.sms_gateway.store', $parameters),
                'options' => route('sms.sms_gateway.options', $parameters),
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

        DomiPlugins('jquery.form');

        DomiScript('assets/vendor/sms/js/sms_gateway/list.js');

        $data['route'] = $this->route['options'];

        return view('sms::sms_gateway.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string $panel
     * @param string $section
     * @param string $type
     *
     * @return View
     */
    public function create(string $panel, string $section, string $type): View
    {
        $data['mode'] = 'create';

        $serviceType = SmsGatewayType::type($type);

        $data['label'] = $serviceType->getLabel();
        $data['description'] = $serviceType->getDescription();
        $data['translation'] = $serviceType->getTranslation();
        $data['media'] = $serviceType->getMedia();
        $data['metadata'] = $serviceType->getMetadata();
        $data['hasUrl'] = $serviceType->hasUrl();
        $data['hasHierarchical'] = $serviceType->hasHierarchical();
        $data['hasBaseMedia'] = $serviceType->hasBaseMedia();

        DomiTitle(trans('taxonomy::base.form.create.title', [
            'type' => $data['label']
        ]));

        // Add breadcrumb
        add_breadcrumb_base($panel, $section);
        Breadcrumb::add($data['label'], $this->route['index']);
        Breadcrumb::add(trans('taxonomy::base.form.create.title', [
            'type' => $data['label']
        ]));

        // add button
        Button::save();
        Button::saveNew();
        Button::saveClose();
        Button::cancel($this->route['index']);

        DomiScript('assets/vendor/taxonomy/js/form.js');

        $data['type'] = $type;
        $data['action'] = $this->route['store'];

        $data['taxonomies'] = SmsGateway::all($type);

        return view('taxonomy::form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSmsGatewayRequest $request
     * @param string $panel
     * @param string $section
     * @param string $type
     *
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(StoreSmsGatewayRequest $request, string $panel, string $section, string $type): RedirectResponse
    {
        $form_data = $request->all();

        $taxonomy = SmsGateway::store($request->validated());

        if ($taxonomy['ok']) {
            $this->alert($taxonomy['message']);

            if ($form_data['save'] == 'save.new') {
                return back();
            }

            if ($form_data['save'] == 'save.close') {
                return redirect()->to($this->route['index']);
            }

            // btn save
            return redirect()->route('taxonomy.{type}.edit', [
                'panel' => $panel,
                'section' => $section,
                'type' => $type,
                'jm_taxonomy' => $taxonomy['data']->id
            ]);
        }

        $this->alert($taxonomy['message'], 'danger');

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $panel
     * @param string $section
     * @param string $type
     * @param SmsGatewayModel $taxonomy
     *
     * @return View
     */
    public function edit(string $panel, string $section, string $type, SmsGatewayModel $taxonomy): View
    {
        $taxonomy->load(['files', 'metas', 'translations']);

        $data['mode'] = 'edit';

        $serviceType = SmsGatewayType::type($type);

        $data['label'] = $serviceType->getLabel();
        $data['description'] = $serviceType->getDescription();
        $data['translation'] = $serviceType->getTranslation();
        $data['media'] = $serviceType->getMedia();
        $data['metadata'] = $serviceType->getMetadata();
        $data['hasUrl'] = $serviceType->hasUrl();
        $data['hasHierarchical'] = $serviceType->hasHierarchical();
        $data['hasBaseMedia'] = $serviceType->hasBaseMedia();

        DomiTitle(trans('taxonomy::base.form.edit.title', [
            'type' => $data['label'],
            'name' => $taxonomy->id
        ]));

        // Add breadcrumb
        add_breadcrumb_base($panel, $section);
        Breadcrumb::add($data['label'], $this->route['index']);
        Breadcrumb::add(trans('taxonomy::base.form.edit.title', [
            'type' => $data['label'],
            'name' => $taxonomy->id
        ]));

        // add button
        Button::save();
        Button::saveNew();
        Button::saveClose();
        Button::cancel($this->route['index']);

        DomiScript('assets/vendor/taxonomy/js/form.js');

        $data['type'] = $type;
        $data['action'] = route('taxonomy.{type}.update', [
            'panel' => $panel,
            'section' => $section,
            'type' => $type,
            'jm_taxonomy' => $taxonomy->id
        ]);

        $data['languages'] = Language::all();
        $data['taxonomies'] = SmsGateway::all($type);

        $data['taxonomy'] = $taxonomy;
        $data['slug'] = $taxonomy->urlByCollection($type, true);
        $data['translation_edit_values'] = translationResourceData($taxonomy->translations);
        $data['media_values'] = $taxonomy->getMediaDataForObject();
        $data['meta_values'] = $taxonomy->getMetaDataForObject();

        return view('taxonomy::form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSmsGatewayRequest $request
     * @param string $panel
     * @param string $section
     * @param string $type
     * @param SmsGatewayModel $taxonomy
     *
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(UpdateSmsGatewayRequest $request, string $panel, string $section, string $type, SmsGatewayModel $taxonomy): RedirectResponse
    {
        $form_data = $request->all();

        $taxonomy = SmsGateway::update($taxonomy->id, $request->validated());

        if ($taxonomy['ok']) {
            $this->alert($taxonomy['message']);

            if ($form_data['save'] == 'save.new') {
                return redirect()->to($this->route['create']);
            }

            if ($form_data['save'] == 'save.close') {
                return redirect()->to($this->route['index']);
            }

            // btn save
            return redirect()->route('taxonomy.{type}.edit', [
                'panel' => $panel,
                'section' => $section,
                'type' => $type,
                'jm_taxonomy' => $taxonomy['data']->id
            ]);
        }

        $this->alert($taxonomy['message'], 'danger');

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
        $type = $params[2] ?? null;

        $serviceType = SmsGatewayType::type($type);

        try {
            foreach ($ids as $id) {
                SmsGateway::delete($id);
            }

            $alert = trans_choice('taxonomy::base.messages.deleted_items', count($ids), [
                'taxonomy' => $serviceType->getLabel()
            ]);

            return true;
        } catch (Throwable $e) {
            $danger = $e->getMessage();

            return false;
        }
    }

    /**
     * Change Status the specified resource from storage.
     *
     * @param array $ids
     * @param bool $value
     * @param mixed $params
     * @param string|null $alert
     * @param string|null $danger
     *
     * @return bool
     * @throws Throwable
     */
    public function changeStatus(array $ids, bool $value, mixed $params, string &$alert = null, string &$danger = null): bool
    {
        $type = $params[2] ?? null;

        $serviceType = SmsGatewayType::type($type);

        try {
            foreach ($ids as $id) {
                SmsGateway::update($id, ['status' => $value]);
            }

            if ($value) {
                $alert = trans_choice('taxonomy::base.messages.status.enable', count($ids), [
                    'taxonomy' => $serviceType->getLabel()
                ]);
            } else {
                $alert = trans_choice('taxonomy::base.messages.status.disable', count($ids), [
                    'taxonomy' => $serviceType->getLabel()
                ]);
            }

            return true;
        } catch (Throwable $e) {
            $danger = $e->getMessage();

            return false;
        }
    }

    /**
     * Import data
     */
    public function import(ImportActionListRequest $request, string $panel, string $section, string $type)
    {
        //
    }

    /**
     * Export data
     */
    public function export(ExportActionListRequest $request, string $panel, string $section, string $type)
    {
        $export_type = $request->type;

        $filePath = public_path('favicon.ico');
        $fileName = 'favicon.ico';

        return response()->download($filePath, $fileName, [
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ]);
    }

    /**
     * Set Translation in list
     *
     * @param SetTranslationRequest $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function setTranslation(SetTranslationRequest $request): JsonResponse
    {
        try {
            return $this->response(
                SmsGateway::setTranslation($request->validated())
            );
        } catch (Throwable $exception) {
            return $this->response(message: $exception->getMessage(), status: $exception->getCode());
        }
    }
}
