<li>
  <a href="{{ $url }}" target="_blank">
    <div class="flex items-center py-4 lg:py-10">
      <div class="text-2xl font-bold text-green-500 lg:text-4xl">
        {{ $date }}
      </div>
      <div class="pl-4 text-base font-bold lg:px-8">
        {{ $title }}
      </div>
      <div class="flex! flex-1 justify-end pr-4">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6 -rotate-90"
        >
          <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m19.5 8.25-7.5 7.5-7.5-7.5"
          />
        </svg>
      </div>
    </div>
  </a>
</li>
