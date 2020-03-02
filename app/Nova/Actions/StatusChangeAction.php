<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class StatusChangeAction extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {

        //
        foreach($models as $model) {

            $model->forceFill(["status" => $fields->status])->save();

            $this->markAsFinished($model);
        }

        return Action::message('Selected sale order are now '.$fields->status);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('Status')
            ->options([
                'pending' => 'pending',
                'draft' => 'draft',
                'confirm' => 'confirm',
                'cancel' => 'cancel',
                'complete' => 'complete'
            ])
        ];
    }
}
