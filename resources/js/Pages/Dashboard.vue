<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    urls: {
        type: Array,
    },
    auth: {
        type: Object,
    },
});

const form = useForm({
    id: null,
    original_url: "",
});

const saveUrl = () => {
    form.post(route("url.create"), {
        preserveScroll: true,
        onFinish: () => form.reset(),
    });
};

const deleteUrl = (id) => {
    if (confirm("Are you sure you want to delete this URL?")) {
        router.delete(`/urls/${id}`);
    }
};
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
                        <form
                            @submit.prevent="saveUrl"
                            class="my-4 flex flex-col items-center"
                        >
                            <div class="flex items-center gap-4">
                                <TextInput
                                    id="original_url"
                                    type="text"
                                    class="mt-1 block w-96"
                                    v-model="form.original_url"
                                    required
                                    placeholder="Add new URL"
                                />

                                <PrimaryButton
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Save
                                </PrimaryButton>
                            </div>
                            <InputError
                                class="mt-2"
                                :message="form.errors.original_url"
                            />
                        </form>

                        <div
                            v-if="urls.length === 0"
                            class="py-3 flex items-center flex-col text-xl w-full"
                        >
                            <span
                                >Seems you don't have any URLs at the moment
                                :(</span
                            >
                            <span
                                >Try adding a new one with the form above
                                ☝🏻</span
                            >
                        </div>

                        <table
                            v-else
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
                                        <SecondaryButton>Edit</SecondaryButton>
                                        <DangerButton
                                            @click="deleteUrl(url.id)"
                                        >
                                            Delete
                                        </DangerButton>
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
