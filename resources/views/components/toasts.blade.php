<div
  @toast-notify.window="add($event.detail)"
  aria-live="polite"
  class="fixed top-0 right-0 flex w-full flex-col items-end space-y-4 pr-4 pb-4 sm:justify-start z-50"
  role="status"
  x-data="toast"
>
  <template x-for="toast in toasts" :key="`toast-${toast.id}`">
    <div
      aria-live="assertive"
      class="ointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5"
      x-collapse
      x-show="visible.includes(toast)"
      x-on:mouseleave="toast.hovered = false; renewTimer(toast.id)"
      x-on:mouseover="toast.hovered = true;"
      x-transition:enter="transform ease-out duration-300 transition"
      x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
      x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
      x-transition:leave="transition ease-in duration-100"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
    >
      <x-toasts.toast/>
    </div>
  </template>
</div>
