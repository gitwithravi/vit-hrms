<template>
    <div class="lg:flex lg:h-full lg:flex-col">
        <header
            class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 px-6 py-4 lg:flex-none"
        >
            <h1
                class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-300"
            >
                <time datetime="2022-01">{{ calendar.month }}</time>
            </h1>
            <div class="flex items-center">
                <div
                    class="relative flex items-center rounded-md bg-white dark:bg-dark-header shadow-sm md:items-stretch"
                >
                    <span
                        class="cursor-pointer flex h-9 w-12 items-center justify-center rounded-l-md border-y border-l border-gray-300 dark:border-gray-500 pr-1 text-gray-400 dark:text-gray-500 hover:text-gray-500 focus:relative md:w-9 md:pr-0 md:hover:bg-gray-50 dark:md:hover:bg-black"
                        @click="emit('previousMonth')"
                    >
                        <span class="sr-only">Previous month</span>
                        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                    </span>
                    <!-- <button
                        type="button"
                        class="hidden border-y border-gray-300 dark:border-gray-600 px-3.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:relative md:block"
                    >
                        Today
                    </button> -->
                    <span
                        class="relative -mx-px h-5 w-px bg-gray-300 md:hidden"
                    />
                    <span
                        class="cursor-pointer flex h-9 w-12 items-center justify-center rounded-r-md border-y border-r border-gray-300 dark:border-gray-500 pl-1 text-gray-400 dark:text-gray-500 hover:text-gray-500 focus:relative md:w-9 md:pl-0 md:hover:bg-gray-50 dark:md:hover:bg-black"
                        @click="emit('nextMonth')"
                    >
                        <span class="sr-only">Next month</span>
                        <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                    </span>
                </div>
                <div class="hidden md:ml-4 md:flex md:items-center">
                    <slot name="action"></slot>
                </div>
            </div>
        </header>
        <div
            class="shadow ring-1 ring-black ring-opacity-5 lg:flex lg:flex-auto lg:flex-col"
        >
            <div
                class="grid grid-cols-7 gap-px border-b border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 text-center text-xs font-semibold leading-6 text-gray-700 dark:text-gray-400 lg:flex-none"
            >
                <div class="bg-white dark:bg-dark-body py-2">
                    M<span class="sr-only sm:not-sr-only">on</span>
                </div>
                <div class="bg-white dark:bg-dark-body py-2">
                    T<span class="sr-only sm:not-sr-only">ue</span>
                </div>
                <div class="bg-white dark:bg-dark-body py-2">
                    W<span class="sr-only sm:not-sr-only">ed</span>
                </div>
                <div class="bg-white dark:bg-dark-body py-2">
                    T<span class="sr-only sm:not-sr-only">hu</span>
                </div>
                <div class="bg-white dark:bg-dark-body py-2">
                    F<span class="sr-only sm:not-sr-only">ri</span>
                </div>
                <div class="bg-white dark:bg-dark-body py-2">
                    S<span class="sr-only sm:not-sr-only">at</span>
                </div>
                <div class="bg-white dark:bg-dark-body py-2">
                    S<span class="sr-only sm:not-sr-only">un</span>
                </div>
            </div>
            <div
                class="flex bg-gray-200 dark:bg-gray-700 text-xs leading-6 text-gray-700 dark:text-gray-400 lg:flex-auto"
            >
                <div
                    class="hidden w-full lg:grid lg:grid-cols-7 lg:gap-px"
                    :class="{
                        'lg:grid-rows-4': calendar.days.length <= 28,
                        'lg:grid-rows-5':
                            calendar.days.length > 28 &&
                            calendar.days.length <= 35,
                        'lg:grid-rows-6': calendar.days.length > 35,
                    }"
                >
                    <div
                        v-for="day in calendar.days"
                        :key="day.date"
                        :class="[
                            day.isCurrentMonth
                                ? 'bg-white dark:bg-dark-header'
                                : 'bg-gray-50 dark:bg-dark-body text-gray-500',
                            'relative px-3 py-2',
                        ]"
                    >
                        <time
                            :datetime="day.date"
                            :class="
                                day.isToday
                                    ? 'flex h-6 w-6 items-center justify-center rounded-full bg-primary dark:bg-dark-primary font-semibold text-white'
                                    : undefined
                            "
                            >{{
                                day.date.split("-").pop().replace(/^0/, "")
                            }}</time
                        >
                        <ol v-if="day.events.length > 0" class="mt-2">
                            <li
                                v-for="event in day.events.slice(0, 2)"
                                :key="event.id"
                            >
                                <a :href="event.href" class="group flex">
                                    <p
                                        class="flex-auto truncate font-medium text-gray-900 dark:text-gray-400 group-hover:text-gray-300"
                                        v-tooltip="event.name"
                                    >
                                        {{ event.name }}
                                    </p>
                                    <time
                                        :datetime="event.datetime"
                                        class="ml-3 hidden flex-none text-gray-500 group-hover:text-gray-300 xl:block"
                                        >{{ event.time }}</time
                                    >
                                </a>
                            </li>
                            <li
                                v-if="day.events.length > 2"
                                class="text-gray-500"
                            >
                                + {{ day.events.length - 2 }} more
                            </li>
                        </ol>
                    </div>
                </div>
                <div
                    class="isolate grid w-full grid-cols-7 gap-px lg:hidden"
                    :class="{
                        'lg:grid-rows-4': calendar.days.length <= 28,
                        'lg:grid-rows-5':
                            calendar.days.length > 28 &&
                            calendar.days.length <= 35,
                        'lg:grid-rows-6': calendar.days.length > 35,
                    }"
                >
                    <button
                        v-for="day in calendar.days"
                        :key="day.date"
                        type="button"
                        :class="[
                            day.isCurrentMonth ? 'bg-white' : 'bg-gray-50',
                            (day.isSelected || day.isToday) && 'font-semibold',
                            day.isSelected && 'text-white',
                            !day.isSelected && day.isToday && 'text-primary',
                            !day.isSelected &&
                                day.isCurrentMonth &&
                                !day.isToday &&
                                'text-gray-900',
                            !day.isSelected &&
                                !day.isCurrentMonth &&
                                !day.isToday &&
                                'text-gray-500',
                            'flex h-14 flex-col px-3 py-2 hover:bg-gray-100 focus:z-10',
                        ]"
                    >
                        <time
                            :datetime="day.date"
                            :class="[
                                day.isSelected &&
                                    'flex h-6 w-6 items-center justify-center rounded-full',
                                day.isSelected &&
                                    day.isToday &&
                                    'bg-primary dark:bg-dark-primary',
                                day.isSelected && !day.isToday && 'bg-gray-900',
                                'ml-auto',
                            ]"
                            >{{
                                day.date.split("-").pop().replace(/^0/, "")
                            }}</time
                        >
                        <span class="sr-only"
                            >{{ day.events.length }} events</span
                        >
                        <span
                            v-if="day.events.length > 0"
                            class="-mx-0.5 mt-auto flex flex-wrap-reverse"
                        >
                            <span
                                v-for="event in day.events"
                                :key="event.id"
                                class="mx-0.5 mb-1 h-1.5 w-1.5 rounded-full bg-gray-400"
                            />
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div
            v-if="selectedDay?.events.length > 0"
            class="px-4 py-10 sm:px-6 lg:hidden"
        >
            <ol
                class="divide-y divide-gray-100 overflow-hidden rounded-lg bg-white text-sm shadow ring-1 ring-black ring-opacity-5"
            >
                <li
                    v-for="event in selectedDay.events"
                    :key="event.id"
                    class="group flex p-4 pr-6 focus-within:bg-gray-50 hover:bg-gray-50"
                >
                    <div class="flex-auto">
                        <p class="font-semibold text-gray-900">
                            {{ event.name }}
                        </p>
                        <time
                            :datetime="event.datetime"
                            class="mt-2 flex items-center text-gray-700"
                        >
                            <ClockIcon
                                class="mr-2 h-5 w-5 text-gray-400"
                                aria-hidden="true"
                            />
                            {{ event.time }}
                        </time>
                    </div>
                    <a
                        :href="event.href"
                        class="ml-6 flex-none self-center rounded-md bg-white px-3 py-2 font-semibold text-gray-900 opacity-0 shadow-sm ring-1 ring-inset ring-gray-300 hover:ring-gray-400 focus:opacity-100 group-hover:opacity-100"
                        >Edit<span class="sr-only">, {{ event.name }}</span></a
                    >
                </li>
            </ol>
        </div>
    </div>
</template>

<script>
export default {
    name: "BaseCalendar",
}
</script>

<script setup>
import {
    ChevronDownIcon,
    ChevronLeftIcon,
    ChevronRightIcon,
    ClockIcon,
    EllipsisHorizontalIcon,
} from "@heroicons/vue/20/solid"
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue"

const emit = defineEmits(["previousMonth", "nextMonth"])

const props = defineProps({
    calendar: {
        type: Object,
        required: true,
    },
})

const selectedDay = props.calendar.days.find((day) => day.isSelected)
</script>
