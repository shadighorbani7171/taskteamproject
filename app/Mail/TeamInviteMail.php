<?php



namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TeamInvite;

class TeamInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;
    public $acceptUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TeamInvite $invitation)
    {
        $this->invitation = $invitation;
        $this->acceptUrl = url('/teams/' . $invitation->team->id . '/accept?token=' . $invitation->accept_token);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('You have been invited to join a team')
                    ->markdown('emails.team_invite')
                    ->with([
                        'invitation' => $this->invitation,
                        'acceptUrl' => $this->acceptUrl,
                    ]);
    }
}
