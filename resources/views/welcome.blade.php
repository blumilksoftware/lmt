@props(["previousMeetups" => collect()])

<x-layout>
  <x-partials.navigation :previous-meetups="$previousMeetups" />
  <x-partials.header />

  <x-partials.cta />

  @if ($previousMeetups->isNotEmpty())
    <x-partials.meetups :meetups="$previousMeetups" />
    @endif
  <x-partials.footer />
</x-layout>
