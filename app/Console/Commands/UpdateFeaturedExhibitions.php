<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiRelation;
use App\Models\Api\Exhibition;
use App\Models\Page;

class UpdateFeaturedExhibitions extends Command
{
    protected $signature = 'exhibitions:featured';

    protected $description = 'Update the current exhibitions list when upcoming exhibitions are active';

    public function handle()
    {
        $page = Page::forType('Exhibitions and Events')->with('apiElements')->first();

        $currentExhibitions = $page->exhibitionsCurrent->sortBy('pivot.position');
        $upcomingExhibitions = $page->exhibitionsUpcomingListing->sortBy('pivot.position');

        // Move the upcoming exhibitions to the current exhibitions list if they are now open
        $upcomingExhibitions->each(function ($exhibition) use (&$currentExhibitions) {
            $id = ApiRelation::find($exhibition->pivot->api_relation_id)->datahub_id;
            $exhibitionInstance = Exhibition::query()->find($id);

            if ($exhibitionInstance->is_now_open || $exhibitionInstance->is_ongoing) {
                $this->info("Moving {$exhibitionInstance->id}: {$exhibitionInstance->title} to current exhibitions list");
                $currentExhibitions->splice(2, 0, [$exhibition]);
                $exhibition->pivot->relation = 'exhibitionsCurrent';
                $exhibition->pivot->api_relation_id = $exhibition->id;
                $exhibition->pivot->save();
            }
        });

        $currentExhibitions = $currentExhibitions->reject(function ($exhibition) {
            $id = ApiRelation::find($exhibition->pivot->api_relation_id)->datahub_id;
            $exhibitionInstance = Exhibition::query()->find($id);

            if ($exhibitionInstance->is_closed) {
                $this->info("Removing {$exhibitionInstance->id}: {$exhibitionInstance->title} from current exhibitions list");
                ApiRelation::find($exhibition->pivot->api_relation_id)->delete();
                return true;
            }
            return false;
        });


        // Update the positions of the current exhibitions
        foreach ($currentExhibitions as $index => $exhibition) {
            $exhibition->pivot->position = $index + 1;
            $exhibition->pivot->save();
        }

        // Update the positions of the upcoming exhibitions
        foreach ($upcomingExhibitions as $index => $exhibition) {
            $exhibition->pivot->position = $index + 1;
            $exhibition->pivot->save();
        }

        $page->update([
            'exhibitionsCurrent' => $currentExhibitions,
            'exhibitionsUpcomingListing' => $upcomingExhibitions,
        ]);
    }
}
