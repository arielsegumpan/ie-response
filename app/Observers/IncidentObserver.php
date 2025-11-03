<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Incident;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class IncidentObserver
{
    /**
     * Handle the Incident "created" event.
     */
    public function created(Incident $incident): void
    {
        Notification::make();
    }

    /**
     * Handle the Incident "updated" event.
     */
    public function updated(Incident $incident): void
    {
        //
    }

    /**
     * Handle the Incident "deleted" event.
     */
    public function deleted(Incident $incident): void
    {
        //
    }

    /**
     * Handle the Incident "restored" event.
     */
    public function restored(Incident $incident): void
    {
        //
    }

    /**
     * Handle the Incident "force deleted" event.
     */
    public function forceDeleted(Incident $incident): void
    {
        //
    }


    private function notifyResponders(Incident $incident, User $reponders) : void
    {
        $respondrs = $reponders::role('responder')->get();

        if($respondrs) {
            foreach ($respondrs as $respondr) {
                $notification = $this->createNotification(
                    'New Incident',
                    "A new incident has been reported by '{$incident->reporter->name}' ",
                    $incident,
                    $respondr
                );
                $notification->sendToDatabase($respondr);
            }
        }
    }

    private function notifyAdmins(Incident $incident, User $reponders) : void
    {
        $respondrs = $reponders::role('super_admin')->get();

        if($respondrs) {
            foreach ($respondrs as $respondr) {
                $notification = $this->createNotification(
                    'New Incident',
                    "A new incident has been reported by '{$incident->reporter->name}' ",
                    $incident,
                    $respondr
                );
                $notification->sendToDatabase($respondr);
            }
        }
    }


     /**
     * Create a Notification instance.
     */
    private function createNotification(string $title, string $body, Incident $incident, User $recipient): Notification
    {
        return Notification::make()
            ->title($title)
            ->icon('heroicon-o-exclamation-triangle')
            ->body($body)
            ->actions([
                Action::make('View')
                    ->button()
                    ->icon('heroicon-o-eye')
                    ->label('View')
                    // ->url($url),
            ]);
    }


    


}
