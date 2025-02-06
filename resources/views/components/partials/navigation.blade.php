@props(["meetup" => null])

<section x-data="{ open: false }">
  <nav class="bg-transparent xl:hidden!">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex! h-20 items-center justify-between pt-12">
        <div class="flex! items-center">
          <div class="shrink-0 pl-2">
            <a href="/">
              <img
                  class="h-10 w-auto pl-3"
                  src="{{ asset('images/logo.webp') }}"
                  alt="Legnicki Meetup Technologiczny"
              />
            </a>
          </div>
        </div>
        <div class="block! xl:hidden!">
          <button
              @click="open = !open"
              class="text-white hover:text-gray-300 focus:text-gray-300 focus:outline-none"
              aria-controls="mobile-menu"
              aria-expanded="false"
          >
            <x-icons.hamburger-open x-bind:class="{ 'hidden!': open, 'inline-flex!': !open }" class="size-6" />
            <x-icons.hamburger-closed x-bind:class="{ 'hidden!': !open, 'inline-flex!': open }" class="size-6" />
          </button>
        </div>
      </div>
    </div>

    <div x-bind:class="{ 'block!': open, 'hidden!': !open }" class="mt-5 xl:hidden!" id="mobile-menu">
      <div class="space-y-1 rounded-md px-2 pb-3 pt-2 text-base font-medium text-gray-300">
        <a href="#wydarzenie" class="block! px-3 py-2 hover:bg-gray-700 hover:text-white">
          Wydarzenie
        </a>
        @if ($meetup)
          <a href="#partnerzy" class="block! px-3 py-2 hover:bg-gray-700 hover:text-white">
            Partnerzy
          </a>
          <a href="#prelegenci" class="block! px-3 py-2 hover:bg-gray-700 hover:text-white">
            Prelegenci
          </a>
          <a href="#agenda" class="block! px-3 py-2 hover:bg-gray-700 hover:text-white">
            Agenda
          </a>
        @endif

        @if (!empty($previousMeetups))
        <a href="#poprzednieMeetupy" class="block! px-3 py-2 hover:bg-gray-700 hover:text-white">
          Poprzednie edycje
        </a>

        @endif

        @if ($meetup?->isCurrent())
          <a href="#rejestracja" class="block! px-3 py-2 hover:bg-gray-700 hover:text-white">
            Rejestracja
          </a>
        @endif
      </div>
    </div>
  </nav>
  <nav class="hidden! text-white xl:block!">
    <div class="mx-auto max-w-screen-2xl px-2 lg:px-12 xl:px-6">
      <div class="flex! h-32 items-center justify-between">
        <div class="flex! items-center">
          <div class="shrink-0">
            <a href="/">
              <img
                  class="h-12"
                  src="{{ asset('images/logo.webp') }}"
                  alt="Legnicki Meetup Technologiczny"
              />
            </a>
          </div>
        </div>
        <div class="flex! items-center">
          <div class="hidden! xl:ml-6 xl:block!">
            <div class="text-md flex! justify-end space-x-4 rounded-md font-medium text-gray-300">
              <a href="#wydarzenie" class="block px-3 py-2 hover:bg-gray-700 hover:text-white">
                Wydarzenie
              </a>
              @if ($meetup)
                <a href="#partnerzy" class="block px-3 py-2 hover:bg-gray-700 hover:text-white">
                  Partnerzy
                </a>
                <a href="#prelegenci" class="block px-3 py-2 hover:bg-gray-700 hover:text-white">
                  Prelegenci
                </a>
                <a href="#agenda" class="block px-3 py-2 hover:bg-gray-700 hover:text-white">
                  Agenda
                </a>
              @endif
              @if (!empty($previousMeetups))
                <a href="#poprzednieMeetupy" class="block px-3 py-2 hover:bg-gray-700 hover:text-white">
                  Poprzednie edycje
                </a>
              @endif
              @if ($meetup?->isCurrent())
                <a href="#rejestracja" class="block px-3 py-2 hover:bg-gray-700 hover:text-white">
                  Rejestracja
                </a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</section>