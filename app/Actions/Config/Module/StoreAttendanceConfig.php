<?php

namespace App\Actions\Config\Module;

use App\Rules\Latitude;
use App\Rules\Longitude;

class StoreAttendanceConfig
{
    public static function handle(): array
    {
        $input = request()->validate([
            'allow_employee_clock_in_out' => 'sometimes|boolean',
            'allow_employee_clock_in_out_via_device' => 'sometimes|boolean',
            'late_grace_period' => 'sometimes|numeric|min:0|max:60',
            'early_leaving_grace_period' => 'sometimes|numeric|min:0|max:60',
            'present_grace_period' => 'sometimes|numeric|min:0|max:120',
            'enable_geolocation_timesheet' => 'sometimes|boolean',
            'geolocation_latitude' => ['sometimes', 'required_if:enable_geolocation_timesheet,1', new Latitude],
            'geolocation_longitude' => ['sometimes', 'required_if:enable_geolocation_timesheet,1', new Longitude],
            'geolocation_radius' => 'sometimes|required_if:enable_geolocation_timesheet,1|numeric',
        ], [
            'geolocation_latitude.required_if' => __('validation.required', ['attribute' => __('attendance.config.props.geolocation_latitude')]),
            'geolocation_longitude.required_if' => __('validation.required', ['attribute' => __('attendance.config.props.geolocation_longitude')]),
            'geolocation_radius.required_if' => __('validation.required', ['attribute' => __('attendance.config.props.geolocation_radius')]),
        ], [
            'allow_employee_clock_in_out' => __('attendance.config.props.allow_employee_clock_in_out'),
            'allow_employee_clock_in_out_via_device' => __('attendance.config.props.allow_employee_clock_in_out_via_device'),
            'late_grace_period' => __('attendance.config.props.late_grace_period'),
            'early_leaving_grace_period' => __('attendance.config.props.early_leaving_grace_period'),
            'present_grace_period' => __('attendance.config.props.present_grace_period'),
            'enable_geolocation_timesheet' => __('attendance.config.props.enable_geolocation_timesheet'),
            'geolocation_latitude' => __('attendance.config.props.geolocation_latitude'),
            'geolocation_longitude' => __('attendance.config.props.geolocation_longitude'),
            'geolocation_radius' => __('attendance.config.props.geolocation_radius'),
        ]);

        return $input;
    }
}
