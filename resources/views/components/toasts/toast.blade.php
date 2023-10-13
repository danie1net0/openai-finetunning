<div class="flex w-full flex-col items-center space-y-4 sm:items-end">
  <div
    class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
    <div class="p-4">
      <div class="flex items-start">
        <div class="flex-shrink-0">
          <x-icons.check-circle class="text-green-400" x-show="toast.type === 'success'"/>
          <x-icons.exclamation-circle class="text-red-400" x-show="toast.type === 'error'"/>
          <x-icons.information-circle class="text-cyan-400" x-show="toast.type === 'info'"/>
          <x-icons.exclamation-triangle class="text-yellow-400" x-show="toast.type === 'warning'"/>
          <x-icons.question-mark-circle class="text-gray-400" x-show="toast.type === 'question'"/>
        </div>

        <div class="ml-3 w-0 flex-1 pt-0.5">
          <p class="text-sm font-medium text-gray-900" x-text="toast.title"></p>
          <p class="mt-1 text-sm text-gray-500" x-text="toast.description"></p>

          <template x-if="toast?.labels?.reject || toast?.labels?.reject">
            <div class="mt-4 flex gap-x-3">
              <button
                @click="remove(toast.id); executeAction(toast)"
                class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                type="button"
                x-show="toast?.labels?.accept"
                x-text="toast?.labels?.accept"
              ></button>

              <button
                @click="remove(toast.id)"
                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                type="button"
                x-show="toast?.labels?.reject"
                x-text="toast?.labels?.reject"
              ></button>
            </div>
          </template>
        </div>

        <div class="ml-4 flex flex-shrink-0">
          <button
            @click="remove(toast.id)"
            type="button"
            class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            <span class="sr-only">Close</span>
            <x-icons.x-mark class="h-5 w-5"/>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
