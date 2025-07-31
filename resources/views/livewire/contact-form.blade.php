@php
  $siteKey = config("recaptchav3.sitekey");
@endphp

<div wire:id="contact">
  <div class="pointer-events-none absolute right-0 hidden! lg:flex!">
    <div class="css-blurry-violet-gradient"></div>
    <div class="css-blurry-green-gradient"></div>
  </div>
  <div id="rejestracja" class="relative z-10 mx-auto max-w-6xl">
    <div class="rounded-t-[90px] bg-neutral-200 p-8 text-gray-950 lg:rounded-[90px] lg:p-16">
      <h2 class="pt-10 text-center text-5xl font-bold lg:text-6xl">
        Rejestracja
      </h2>
      @if(!empty($errors->isNotEmpty()))
        <div wire:loading.remove class="mx-auto w-2/3 rounded-xl border-2 border-red-400 bg-red-100 mt-4 p-4">
          <p class="text-lg">
            Rejestracja nie powiodła się. Sprawdź błędy poniżej i spróbuj ponownie.
          </p>
          <ul class="list-disc p-2 pl-6">
            @foreach($errors->getMessages() as $error)
              <li> {{ $error[0] }} </li>
            @endforeach
          </ul>
        </div>
      @endif
      @if ($success)
        <p class="mb-32 mt-8 text-center text-xl">
          Rejestracja zakończona! Sprawdź e-maila z potwierdzeniem.
        </p>
      @else
        <form id="registration-form" wire:submit.prevent="submit" wire:loading.remove>
          <div id="registration-errors" class="text-center text-red-600"></div>
          <input type="hidden" wire:model="recaptcha" name="recaptcha" />
          <div class="mx-auto my-5 flex! max-w-2xl flex-col gap-8">
            <p class="my-7 text-center text-sm lg:text-base">
              Legnicki Meetup Technologiczny to spotkanie stacjonarne.
              Pamiętaj, że liczba miejsc jest ograniczona. Zarejestruj się
              już teraz, aby zapewnić sobie miejsce na wydarzeniu!
            </p>
            <div class="relative">
              <input
                  type="text"
                  name="name"
                  id="name"
                  wire:model="name"
                  class="peer block w-full border-transparent rounded-md border bg-zinc-300 px-4 py-3 placeholder-transparent shadow-sm focus:border-violet-500 focus:outline-none sm:leading-6"
                  placeholder="Imię"
              />
              <label
                  for="name"
                  class="absolute -top-6 left-2 text-base text-gray-900 transition-all peer-placeholder-shown:left-4 peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-6 peer-focus:left-2 peer-focus:text-base peer-focus:text-gray-900"
              >
                Imię
              </label>
            </div>
            <div class="relative">
              <input
                  type="text"
                  name="surname"
                  id="surname"
                  wire:model="surname"
                  class="peer block w-full border-transparent rounded-md border bg-zinc-300 px-4 py-3 placeholder-transparent shadow-sm focus:border-violet-500 focus:outline-none sm:leading-6"
                  placeholder="Nazwisko"
              />
              <label
                  for="surname"
                  class="absolute -top-6 left-2 text-base text-gray-900 transition-all peer-placeholder-shown:left-4 peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-6 peer-focus:left-2 peer-focus:text-base peer-focus:text-gray-900"
              >
                Nazwisko
              </label>
            </div>
            <div class="relative">
              <input
                  type="text"
                  name="company"
                  id="company"
                  wire:model="company"
                  class="peer block w-full border-transparent rounded-md border bg-zinc-300 px-4 py-3 placeholder-transparent shadow-sm focus:border-violet-500 focus:outline-none sm:leading-6"
                  placeholder="Nazwa firmy"
              />
              <label
                  for="company"
                  class="absolute -top-6 left-2 text-base text-gray-900 transition-all peer-placeholder-shown:left-4 peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-6 peer-focus:left-2 peer-focus:text-base peer-focus:text-gray-900"
              >
                Nazwa firmy
              </label>
            </div>
            <div class="relative">
              <input
                  type="email"
                  name="email"
                  id="email"
                  wire:model="email"
                  class="peer border-transparent block w-full rounded-md border bg-zinc-300 px-4 py-3 placeholder-transparent shadow-sm focus:border-violet-500 focus:outline-none sm:leading-6"
                  placeholder="Adres e-mail"
              />
              <label
                  for="email"
                  class="absolute -top-6 left-2 text-base text-gray-900 transition-all peer-placeholder-shown:left-4 peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-6 peer-focus:left-2 peer-focus:text-base peer-focus:text-gray-900"
              >
                Adres e-mail
              </label>
            </div>
            <div class="relative">
              <label
                  for="consent"
                  class="flex flex-row bg-neutral-200 px-2 text-sm font-normal text-black"
              >
                <input
                    type="checkbox"
                    name="consent"
                    id="consent"
                    wire:model="consent"
                    required
                    class="mt-2 self-start"
                />
                <span class="pl-5 text-xs lg:text-sm">
                Wyrażam zgodę na przetwarzanie moich danych osobowych
                podanych w powyższym formularzu w celach marketingowych
                przez organizatora Legnickiego Meetupu Technologicznego,
                firmę Blumilk sp. z o.o. ul. Najświętszej Marii Panny
                5F/5, 59-220 Legnica oraz przez podmioty trzecie
                odpowiedzialne za organizację Legnickiego Meetupu
                Technologicznego.
              </span>
              </label>
            </div>

            <div class="relative flex! w-full cursor-pointer justify-center">
              <button
                  class="mt-4 self-center rounded-md bg-violet-700 px-7 py-3 align-middle text-lg font-bold uppercase text-neutral-200 xs:px-10 md:px-16 lg:px-20 lg:py-6">
                Zarejestruj się
              </button>
            </div>
          </div>
        </form>
        <p wire:loading class="mb-32 mt-8 w-full text-center text-xl">
          Trwa wysyłanie...
        </p>
      @endif
    </div>
  </div>
  <script>
    grecaptcha.ready(function() {
      grecaptcha.execute('{{ $siteKey }}', {action: 'contact'}).then(function(token) {
        @this.set('recaptcha', token)
      })
    });
  </script>
</div>
