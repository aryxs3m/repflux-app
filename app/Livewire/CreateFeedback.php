<?php

namespace App\Livewire;

use App\Jobs\FeedbackSendJob;
use App\Models\UserFeedback;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CreateFeedback extends Component implements HasSchemas
{
    use AuthorizesRequests;
    use InteractsWithSchemas;

    public ?array $data = [];

    public bool $sent = false;

    public function render()
    {
        return view('livewire.create-feedback');
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->options([
                        'bug' => 'Bug Report',
                        'feature' => 'Feature Request',
                        'other' => 'Other',
                    ])
                    ->required(),
                MarkdownEditor::make('message')
                    ->minLength(10)
                    ->default('')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $this->authorize('create-feedback');

        $feedback = UserFeedback::create(array_merge($this->data, [
            'user_id' => auth()->id(),
        ]));

        $this->sent = true;

        FeedbackSendJob::dispatch($feedback);

        Notification::make()
            ->title('Feedback submitted successfully!')
            ->body('Thank you for your feedback.')
            ->success()
            ->send();
    }
}
