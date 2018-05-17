<?php

namespace App\Models\HR;

use App\Events\HR\ApplicationCreated;
use App\Models\HR\Applicant;
use App\Models\HR\ApplicationRound;
use App\Models\HR\Job;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = ['id'];

    protected $table = 'hr_applications';

    /**
     * Custom create method that creates an application and fires necessary events
     *
     * @param  array $attr  fillables to be stored
     * @return this
     */
    public static function _create($attr)
    {
        $application = self::create($attr);
        event(new ApplicationCreated($application));
        return $application;
    }

    /**
     * get applications where status is rejected
     */
    public function scopeRejected($query)
    {
        return $query->where('status', config('constants.hr.status.rejected.label'));
    }

    /**
     * get applications where status is not rejected
     */
    public function scopeNonRejected($query)
    {
        return $query->where('status', '!=', config('constants.hr.status.rejected.label'));
    }

    /**
     * get list of applications based on their show status
     */
    public static function filterByStatus($status)
    {
        $applications = self::with('applicant', 'job');
        switch ($status) {
            case config('constants.hr.status.rejected.label'):
                $applications = $applications->rejected();
                break;
            default:
                $applications = $applications->nonRejected();
                break;
        }
        return $applications->orderBy('id', 'desc')->paginate(config('constants.pagination_size'));
    }

    /**
     * Set application status to rejected
     */
    public function reject()
    {
        $this->update(['status' => config('constants.hr.status.rejected.label')]);
    }

    /**
     * Set application status to in-progress
     */
    public function markInProgress()
    {
        $this->update(['status' => config('constants.hr.status.in-progress.label')]);
    }

    public function job()
    {
    	return $this->belongsTo(Job::class, 'hr_job_id');
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'hr_applicant_id');
    }

    public function applicationRounds()
    {
        return $this->hasMany(ApplicationRound::class, 'hr_application_id');
    }
}