<?php
protected function jobIdAutoIncrement()
{
    $last_created_job = Job::withTrashed()
    ->where('job_no', 'like', '%'.auth()
    ->user()->counter->name.'%')
    ->orderBy('id','desc')->first();

    if($last_created_job == null) {
        $last_created_job = new Job();
        $last_created_job->setAttribute('job_no', date('Y').auth()->user()->counter->name.'-J0');
    }else {
        if( date('Y') == explode('-', $last_created_job->created_at)[0] + 1 ) {
            $last_created_job = new Job();
            $last_created_job->setAttribute('job_no', date('Y').auth()->user()->counter->name.'-J0');
        }
    }

    $last_created_job_no = $last_created_job->job_no; // 2022MNGAJ1
    $cut_last_created_job_no = explode("J", $last_created_job_no);

    $auto_increment_no = ++ $cut_last_created_job_no[1];

    return date('Y').auth()->user()->counter->name.'-J'. $auto_increment_no;
}
