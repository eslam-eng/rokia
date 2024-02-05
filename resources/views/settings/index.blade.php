@extends('layouts.app')
@section('title', __('app.settings.title'))
@section('content')
    <section class="settings">
        <div class="card">
            <div class="card-body border-bottom">
                <div wire:poll.500ms>
                    <livewire:settings-form/>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom-js')
<script>
    window.addEventListener('swal', event => {
        let error = event.detail[0];
        Swal.fire({
            title: `${error.title}`,
            text: `${error.text}`,
            icon: `${error.icon}`
        });
    });

</script>
@endsection
