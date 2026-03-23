<?php

namespace App\Observers\Task;

use App\Actions\Task\UpdateProgress as UpdateTaskProgress;
use App\Models\Task\Checklist;

class ChecklistObserver
{
    /**
     * Handle the Checklist "created" event.
     *
     * @return void
     */
    public function created(Checklist $checklist)
    {
        (new UpdateTaskProgress)->execute($checklist->task_id);
    }

    /**
     * Handle the Checklist "updated" event.
     *
     * @return void
     */
    public function updated(Checklist $checklist)
    {
        (new UpdateTaskProgress)->execute($checklist->task_id);
    }

    /**
     * Handle the Checklist "deleted" event.
     *
     * @return void
     */
    public function deleted(Checklist $checklist)
    {
        (new UpdateTaskProgress)->execute($checklist->task_id);
    }

    /**
     * Handle the Checklist "restored" event.
     *
     * @return void
     */
    public function restored(Checklist $checklist)
    {
        //
    }

    /**
     * Handle the Checklist "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Checklist $checklist)
    {
        //
    }
}
