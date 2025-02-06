@props(["meetup" => null, "previousMeetups" => []])

<x-layout>

  <x-partials.navigation :meetup="$meetup" :previousMeetups="$previousMeetups" />
  <x-partials.header :meetup="$meetup" />

  <x-partials.partners :partners="$meetup->companies" />
  <x-partials.speakers :speakers="$meetup->speakers" />
  <x-partials.agenda :items="$meetup->agendas" />

  <x-partials.cta />

  @if (!empty($previousMeetups))
    <x-partials.meetups :meetups="$previousMeetups" />
  @endif

  @if (count($meetup->photos ?? []) === 12)
    <x-partials.gallery photographers="{{ $meetup->photographers }}" :photos="$meetup->photos" />
  @endif

  <x-partials.footer :meetup="$meetup" />
</x-layout>

