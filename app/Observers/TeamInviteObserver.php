<?php



namespace App\Observers;

use App\Models\TeamInvite;
use App\Mail\TeamInviteMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class TeamInviteObserver
{
    /**
     * Handle the TeamInvite "creating" event.
     *
     * @param  \App\Models\TeamInvite  $invite
     * @return void
     */
    public function creating(TeamInvite $invite)
    {
        $invite->accept_token = Str::random(32);
        $invite->deny_token = Str::random(32);

    
        $user = User::where('email', $invite->email)->first();
        if ($user) {
            $invite->user_id = $user->id;
        } else {
          
            $invite->user_id = null; 
        }
    }

    /**
     * Handle the TeamInvite "created" event.
     *
     * @param  \App\Models\TeamInvite  $invite
     * @return void
     */
    public function created(TeamInvite $invite)
    {
        Mail::to($invite->email)->send(new TeamInviteMail($invite));
    }

    /**
     * Handle the TeamInvite "updated" event.
     *
     * @param  \App\Models\TeamInvite  $invite
     * @return void
     */
    public function updated(TeamInvite $invite)
    {
        //
    }

    /**
     * Handle the TeamInvite "deleted" event.
     *
     * @param  \App\Models\TeamInvite  $invite
     * @return void
     */
    public function deleted(TeamInvite $invite)
    {
        //
    }

    /**
     * Handle the TeamInvite "restored" event.
     *
     * @param  \App\Models\TeamInvite  $invite
     * @return void
     */
    public function restored(TeamInvite $invite)
    {
        //
    }

    /**
     * Handle the TeamInvite "force deleted" event.
     *
     * @param  \App\Models\TeamInvite  $invite
     * @return void
     */
    public function forceDeleted(TeamInvite $invite)
    {
        //
    }
}
