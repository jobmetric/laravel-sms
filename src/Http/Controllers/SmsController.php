<?php

namespace JobMetric\Sms\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use JobMetric\Location\Facades\LocationCountry;
use JobMetric\Panelio\Facades\Breadcrumb;
use JobMetric\Panelio\Facades\Button;
use JobMetric\Panelio\Facades\Datatable;
use JobMetric\Panelio\Http\Controllers\Controller;
use JobMetric\Sms\Facades\Sms;
use JobMetric\Sms\Http\Requests\SendSmsRequest;
use JobMetric\Sms\Http\Resources\SmsResource;
use Throwable;

class SmsController extends Controller
{
    private array $route;

    public function __construct()
    {
        if (request()->route()) {
            $parameters = request()->route()->parameters();

            $this->route = [
                'index' => route('sms.sms.index', $parameters),
                'send_sms' => route('sms.sms.send-sms', $parameters),
            ];
        }
    }

    /**
     * Display a listing of the sms.
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
            $query = Sms::query();

            return Datatable::of($query, resource_class: SmsResource::class);
        }

        $title = trans('sms::base.list.sms.title');

        DomiTitle($title);

        // Add breadcrumb
        add_breadcrumb_base($panel, $section);
        Breadcrumb::add($title);

        $date_add_modal['countries'] = LocationCountry::all();

        Button::addModal('sms::base.list.sms.add_modal.title', [
            'title' => 'sms::base.list.sms.add_modal.title',
            'content' => view('sms::sms.add_modal', $date_add_modal)->render(),
        ]);

        DomiLocalize('sms', [
            'route' => $this->route['index'],
            'send_sms' => $this->route['send_sms'],
            'language' => [
                'sms_gateway' => trans('sms::base.list.sms.columns.sms_gateway'),
                'sender' => trans('sms::base.list.sms.columns.sender'),
                'pattern' => trans('sms::base.list.sms.columns.pattern'),
                'note_type' => trans('sms::base.list.sms.columns.note_type'),
                'page' => trans('sms::base.list.sms.columns.page'),
                'price' => trans('sms::base.list.sms.columns.price'),
                'reference_id' => trans('sms::base.list.sms.columns.reference_id'),
                'reference_status' => trans('sms::base.list.sms.columns.reference_status'),
            ],
        ]);

        DomiScript('assets/vendor/sms/js/sms/list.js');

        $data['route'] = 'javascript:void(0)';

        return view('sms::sms.list', $data);
    }

    /**
     * Send sms.
     *
     * @param string $panel
     * @param string $section
     * @param SendSmsRequest $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function sendSms(string $panel, string $section, SendSmsRequest $request): JsonResponse
    {
        try {
            return $this->response(
                Sms::sendSms($request->mobile_prefix, $request->mobile, $request->note)
            );
        } catch (Throwable $exception) {
            return $this->response(message: $exception->getMessage(), status: $exception->getCode());
        }
    }
}
