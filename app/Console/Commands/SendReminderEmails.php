<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Medical;
use App\Models\Vaccination;
use App\Mail\ReminderEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendReminderEmails extends Command
{
    protected $signature = 'send:reminders';
    protected $description = 'Send reminder emails for treatments and vaccinations scheduled for tomorrow';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $medicalRecords = Medical::whereDate('date', $tomorrow)->with('user')->get();
        $vaccinationRecords = Vaccination::whereDate('date', $tomorrow)->with('user')->get();

        
        foreach ($medicalRecords as $record) {
            if ($record->user) {
                Mail::to($record->user->email)->send(new ReminderEmail($record, 'medical'));
                \Log::info("Queued reminder email for {$record->user->email} for Medical Treatment on {$record->date}.");
            }
        }

    
        foreach ($vaccinationRecords as $record) {
            if ($record->user) {
                Mail::to($record->user->email)->send(new ReminderEmail($record, 'vaccination'));
                \Log::info("Queued reminder email for {$record->user->email} for Vaccination on {$record->date}.");
            }
        }
    }
}
