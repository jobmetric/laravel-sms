<?php

namespace JobMetric\Sms;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use JobMetric\Sms\Enums\SmsFieldNoteTypeEnum;
use JobMetric\Sms\Http\Resources\SmsResource;
use JobMetric\Sms\Models\Sms as SmsModel;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

class Sms
{
    /**
     * Get the specified sms.
     *
     * @param array $filter
     * @param array $with
     *
     * @return QueryBuilder
     * @throws Throwable
     */
    public function query(array $filter = [], array $with = []): QueryBuilder
    {
        $fields = [
            'id',
            'sms_gateway_id',
            'user_id',
            'mobile_prefix',
            'mobile',
            'sender',
            'pattern',
            'inputs',
            'note',
            'note_type',
            'page',
            'price',
            'reference_id',
            'reference_status',
            'reference_trace',
            'status',
        ];

        $queryBuilder = QueryBuilder::for(SmsModel::class)
            ->allowedFields($fields)
            ->allowedSorts($fields)
            ->allowedFilters($fields)
            ->defaultSort([
                '-id'
            ])
            ->where($filter);

        $queryBuilder->with('smsGateway', 'user');

        if (!empty($with)) {
            $queryBuilder->with($with);
        }

        return $queryBuilder;
    }

    /**
     * Paginate the specified sms.
     *
     * @param array $filter
     * @param int $page_limit
     * @param array $with
     *
     * @return AnonymousResourceCollection
     * @throws Throwable
     */
    public function paginate(array $filter = [], int $page_limit = 15, array $with = []): AnonymousResourceCollection
    {
        return SmsResource::collection(
            $this->query($filter)->paginate($page_limit)
        );
    }

    /**
     * Get all sms.
     *
     * @param array $filter
     * @param array $with
     *
     * @return AnonymousResourceCollection
     * @throws Throwable
     */
    public function all(array $filter = [], array $with = []): AnonymousResourceCollection
    {
        return SmsResource::collection(
            $this->query($filter)->get()
        );
    }

    /**
     * Process sms text
     *
     * @param string $text
     *
     * @return array
     */
    public function processText(string $text): array
    {
        $textLength = Str::length($text);
        $regexPersian = '/[آابپتسجچهابپتثجچحخدذرزژسشصضطظعغفقکگلمینوهءآاًهٔة۰۱۲۳۴۵۶۷۸۹]/';

        $isPersian = preg_match($regexPersian, $text);
        $type = $isPersian ? SmsFieldNoteTypeEnum::FARSI() : SmsFieldNoteTypeEnum::LATIN();

        $limits = $isPersian
            ? [70, 134, 201, 67]
            : [160, 306, 459, 153];

        if ($textLength <= $limits[0]) {
            $page = 1;
        } elseif ($textLength <= $limits[1]) {
            $page = 2;
        } elseif ($textLength <= $limits[2]) {
            $page = 3;
        } else {
            $page = round(($textLength - $limits[2]) / $limits[3]) + 4;
        }

        return [
            'type' => $type,
            'page' => $page,
        ];
    }
}
