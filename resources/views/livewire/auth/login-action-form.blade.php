<form wire:submit.prevent="submit">
    @if(!$user)
        @include('pages.auth.components.username-input')
    @endif

    @if($user)
        @include('pages.auth.components.one-time-password-input')
    @endif

    <div class="d-grid">
        <button
            type="submit"
            class="btn btn-dark"
        >Continue</button>
    </div>
</form>
