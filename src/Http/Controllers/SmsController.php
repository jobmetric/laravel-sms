<?php

namespace JobMetric\Sms\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use JobMetric\Panelio\Facades\Breadcrumb;
use JobMetric\Panelio\Facades\Datatable;
use JobMetric\Panelio\Http\Controllers\Controller;
use JobMetric\Sms\Facades\Sms;
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

        DomiLocalize('sms', [
            'route' => $this->route['index'],
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
}
