@props([
    'title',
])

@extends('app')

@section('title', $title)

@section('content')
  <div class="min-h-full">
    <nav class="bg-white shadow-sm" x-data="{ showNav: false }">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
          <div class="flex">
            <div class="flex flex-shrink-0 items-center">
              <img class="block h-8 w-auto lg:hidden" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
              <img class="hidden h-8 w-auto lg:block" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            </div>

            <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
              <x-nav-link
                title="Files"
                :active="request()->routeIs('files.index')"
                :route="route('files.index')"
              />
            </div>
          </div>

          <div class="-mr-2 flex items-center sm:hidden">
            <button
              @click="showNav = !showNav"
              type="button"
              class="relative inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
              <x-icons.bars-3 class="h-6 w-6" x-bind:class="showNav ? 'hidden' : 'block'"/>
              <x-icons.close class="h-6 w-6" x-bind:class="showNav ? 'block' : 'hidden'"/>
            </button>
          </div>
        </div>
      </div>

      <div class="sm:hidden" id="mobile-menu" x-transition x-show="showNav">
        <div class="space-y-1 pb-3 pt-2">
          <x-nav-link
            title="Files"
            :active="request()->routeIs('files.index')"
            :route="route('files.index')"
            :mobile="true"
          />
        </div>
      </div>
    </nav>

    <div class="py-10">
      <header>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900">
            {{ $title }}
          </h1>
        </div>
      </header>

      <main>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
          {{ $slot }}
        </div>
      </main>
    </div>
  </div>
@endsection
