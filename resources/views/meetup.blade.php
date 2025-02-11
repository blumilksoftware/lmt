@props(["meetup" => null, "previousMeetups" => collect()])

<x-layout>

  <x-partials.navigation :meetup="$meetup" :previousMeetups="$previousMeetups" />
  <x-partials.header :meetup="$meetup" />

  @if ($meetup->companies->isNotEmpty())
    <x-partials.partners :partners="$meetup->companies" />
  @endif

  @if ($meetup->speakers->isNotEmpty())
    <x-partials.speakers :speakers="$meetup->speakers" />
  @endif

  @if ($meetup->agendas->isNotEmpty())
    <x-partials.agenda :items="$meetup->agendas" />
  @endif

  <x-partials.cta />

  @if ($previousMeetups->isNotEmpty())
    <x-partials.meetups :meetups="$previousMeetups" />
  @endif

  @if (!$meetup->isCurrent() && count($meetup->photos ?? []) === 12)
    <x-partials.gallery photographers="{{ $meetup->photographers }}" :photos="$meetup->photos" />
  @endif

  <x-partials.footer :meetup="$meetup" />
</x-layout>
