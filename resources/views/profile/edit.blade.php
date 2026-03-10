@extends('layouts.tailadmin')

@section('title', 'Mon profil')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold font-display text-gray-900 dark:text-white">Mon profil</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Gérez vos informations personnelles et votre sécurité.</p>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-6 sm:p-8">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-6 sm:p-8">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-6 sm:p-8">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
