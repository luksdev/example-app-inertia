<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Button } from '@/Components/ui/button'
import { router } from '@inertiajs/vue3'
import { reactive, defineProps, ref } from 'vue'

const props = defineProps({
    post: Object,
})

const form = reactive({
    title: props?.post?.title ?? '',
    slug: props?.post?.slug ?? '',
    status: props?.post?.status ?? 'draft',
    content: props?.post?.content ?? '',
})

const handleCreatePost = () => {
    router.post(route('posts.store'), form);
}

const handleUpdatePost = () => {
    router.put(route('posts.update', { post: props.post.id }), form);
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Post
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="mb-6">
                    <Button v-if="!post?.id" variant="outline" @click="handleCreatePost">
                        Create Post
                    </Button>

                    <Button v-else variant="outline" @click="handleUpdatePost">
                        Update Post
                    </Button>
                </div>

                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-4">
                        <InputLabel for="title" value="Title" />
                        <TextInput v-model="form.title" id="title" type="text" class="mt-1 block w-full" required
                            autofocus autocomplete="title" />
                    </div>

                    <div class="col-span-4">
                        <InputLabel for="slug" value="Slug" />
                        <TextInput v-model="form.slug" id="slug" type="text" class="mt-1 block w-full" required
                            autocomplete="slug" />
                    </div>

                    <div class="col-span-4">
                        <InputLabel for="status" value="Status" />
                        <select v-model="form.status" id="status" name="status"
                            class="mt-1 block w-full py-2.5 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>

                    <div class="col-span-12">
                        <InputLabel for="content" value="Content" />
                        <textarea v-model="form.content" id="content" name="content" rows="3"
                            class="mt-1 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border border-gray-300 rounded-md"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>