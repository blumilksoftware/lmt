@props(["previousMeetups" => []])

<x-layout>
  <x-partials.navigation />
  <x-partials.header />

  <x-partials.cta />

  @if (empty($previousMeetups))
    <x-partials.meetups :meetups="$previousMeetups" />
    @endif
  <x-partials.footer />
</x-layout>

