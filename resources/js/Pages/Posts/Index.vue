<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table'
import { Button } from '@/Components/ui/button'
import { router } from '@inertiajs/vue3'
import { defineProps, ref, watch } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import debounce from 'lodash.debounce'

import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
} from '@/Components/ui/pagination'

const props = defineProps({
    posts: Array,
})

const search = ref('');

watch(search, debounce((value) => {
    router.visit(route('posts.index', { search: value }))
}, 500))

const clearParams = () => {
    router.visit(route('posts.index'))
}

const createPost = () => {
    router.visit(route('posts.create'))
}

const parseStatus = (status) => {
    switch (status) {
        case 'draft':
            return 'Rascunho';
        case 'published':
            return 'Publicado';
        default:
            return 'Rascunho';
    }
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Posts
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="mb-6">
                    <Button variant="outline" @click="createPost">
                        Create Post
                    </Button>
                </div>

                <div class="overflow-x-auto">
                    <Button variant="outline" @click="clearParams">
                        Clear Search
                    </Button>

                    <InputLabel for="search" value="Search" />
                    <TextInput v-model="search" id="search" type="text" class="mt-1 block w-full" required autofocus
                        autocomplete="search" />
                </div>

                <Table>
                    <TableCaption>A list of your recent invoices.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[100px]">
                                Actions
                            </TableHead>
                            <TableHead>
                                Title
                            </TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead>Content</TableHead>
                            <TableHead class="text-right">
                                Slug
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="post in props.posts.data" :key="post?.id">
                            <TableCell class="w-[100px]">
                                <Button variant="outline" @click="router.visit(route('posts.show', post?.id))">
                                    Edit
                                </Button>
                            </TableCell>
                            <TableCell class="font-medium">
                                {{ post?.title }}
                            </TableCell>
                            <TableCell>{{ parseStatus(post?.status) }}</TableCell>
                            <TableCell>{{ post?.content }}</TableCell>
                            <TableCell class="text-right">
                                {{ post?.slug }}
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <div class="w-full items-center justify-center flex mt-6">
                    <ol class="flex flex-row">
                        <div v-for="(item, index) in posts.links">
                            <li v-if="index == 0" class="rounded-l-lg bg-slate-150 dark:bg-navy-500">
                                <button @click=" router.visit(item.url)"
                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                            </li>
                            <li v-else-if="index == posts.links.length - 1"
                                class="rounded-r-lg bg-slate-150 dark:bg-navy-500">
                                <button @click="router.visit(item.url)"
                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                </button>
                            </li>
                            <li v-else class="bg-slate-150 mx-1 dark:bg-navy-500">
                                <button @click="router.visit(item.url)" :class="item.active && 'bg-cyan-600 text-white'"
                                    class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">{{
                                    item.label }}</button>
                            </li>
                        </div>
                    </ol>
                </div>
            </div>
        </div>
    </AppLayout>
</template>