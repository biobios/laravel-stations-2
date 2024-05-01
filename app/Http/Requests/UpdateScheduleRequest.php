<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class UpdateScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validate = [];

        $validate += [
            'movie_id' => ['required'],
        ];

        $validate += [
            'start_time_date' => ['required', 'date_format:Y-m-d'],
        ];

        $validate += [
            'start_time_time' => ['required', 'date_format:H:i',
            function ($attribute, $value, $fail) {
                try {// 日付の形式が正しくない場合は例外が発生する
                    $startDateTime = new Carbon($this->start_time_date . ' ' . $this->start_time_time);
                    $endDateTime = new Carbon($this->end_time_date . ' ' . $this->end_time_time);
                } catch (\Exception $e) {
                    // すでにバリデーションが設定されているため、ここでは何もしない
                    return;
                }

                if ($startDateTime->gte($endDateTime)) {
                    $fail('上映開始時間は上映終了時間よりも前に設定してください。');
                }else if($startDateTime->diffInMinutes($endDateTime) <= 5){
                    $fail('上映時間は5分より長く設定してください。'. $startDateTime->diffInMinutes($endDateTime));
                }
            },],
        ];

        $validate += [
            'end_time_date' => ['required', 'date_format:Y-m-d'],
        ];

        $validate += [
            'end_time_time' => ['required', 'date_format:H:i',
                function ($attribute, $value, $fail) {
                    try {// 日付の形式が正しくない場合は例外が発生する
                        $startDateTime = new Carbon($this->start_time_date . ' ' . $this->start_time_time);
                        $endDateTime = new Carbon($this->end_time_date . ' ' . $this->end_time_time);
                    } catch (\Exception $e) {
                        // すでにバリデーションが設定されているため、ここでは何もしない
                        return;
                    }

                    if ($startDateTime->gte($endDateTime)) {
                        $fail('上映終了時間は上映開始時間よりもあとに設定してください。');
                    }else if($startDateTime->diffInMinutes($endDateTime) <= 5){
                        $fail('上映時間は5分より長く設定してください。');
                    }
                },
            ],
        ];

        return $validate;
    }
}
