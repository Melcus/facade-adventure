@component('mail::message')
# Introduction

Welcome to the app.

@component('mail::button', ['url' => ''])
Take me there
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
