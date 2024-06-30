<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Schedule;
use App\Models\Reservation;

class CreateAdminReservationRequest extends FormRequest
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
        if($this->has('schedule_id')){
            $schedule = Schedule::find($this->schedule_id);
            if($schedule){
                $this->merge(['movie_id' => $schedule->movie_id, 'date' => $schedule->start_time_date]);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required'],
            'movie_id' => ['required'],
            'date' => ['required', 'date_format:Y-m-d'],
            'schedule_id' => ['required'],
            'sheet_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if(Reservation::where('schedule_id', $this->schedule_id)->where('sheet_id', $value)->exists()){
                        $fail('その座席はすでに予約されています。');
                    }
                },
            ],
            'name' => ['required'],
            'email' => ['required', 'email:strict,dns'],
        ];
    }
}
