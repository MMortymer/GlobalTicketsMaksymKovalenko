<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    urls: {
        type: Object,
    },
    auth: {
        type: Object,
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <h1 class="text-2xl font-bold">
                        👋🏻 Hi, {{ auth.user.name }}! Here are your URLs
                    </h1>

                    <div class="relative overflow-x-auto mt-6">
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 rounded overflow-clip"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Shortened URL
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Original URL
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="url in urls"
                                    :key="url.id"
                                    class="bg-white border-b"
                                >
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        <a
                                            :href="'/' + url.shortened_url"
                                            target="_blank"
                                            >{{ url.shortened_url }}</a
                                        >
                                    </th>
                                    <td class="px-6 py-4">
                                        <a
                                            :href="url.original_url"
                                            target="_blank"
                                            >{{ url.original_url }}</a
                                        >
                                    </td>
                                    <td class="px-6 py-4 flex gap-4">
                                        <button
                                            class="bg-blue-500 text-white px-2 py-1 rounded"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            class="bg-red-500 text-white px-2 py-1 rounded"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
