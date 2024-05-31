<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import Pagination from "@/Components/Pagination.vue";
import CopyLinkIcon from "@/Components/Icons/CopyLinkIcon.vue";
import { ref } from "vue";

const props = defineProps({
    urls: {
        type: Object,
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
        onSuccess: () => form.reset(),
    });
};

const deleteUrl = (id) => {
    if (confirm("Are you sure you want to delete this URL?")) {
        router.delete(`/urls/${id}`);
    }
};

const editingUrlId = ref(null);
const editingOriginalUrl = ref("");

const editUrl = (url) => {
    editingUrlId.value = url.id;
    editingOriginalUrl.value = url.original_url;
};

const cancelEdit = () => {
    editingUrlId.value = null;
    editingOriginalUrl.value = "";
};

const updateUrl = (id) => {
    router.put(
        `/urls/${id}`,
        { original_url: editingOriginalUrl.value },
        { preserveScroll: true }
    );
    editingUrlId.value = null;
    editingOriginalUrl.value = "";
};

const copyUrl = (id) => {
    const url = props.urls.data.find((url) => url.id === id);
    if (url) {
        const fullUrl = window.location.origin + "/" + url.shortened_url;
        navigator.clipboard
            .writeText(fullUrl)
            .then(() => {
                alert("URL copied to clipboard!");
            })
            .catch((err) => {
                console.error("Could not copy text: ", err);
            });
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

                    <div class="relative mt-6">
                        <form
                            @submit.prevent="saveUrl"
                            class="my-4 flex flex-col items-center"
                        >
                            <div
                                class="w-full flex flex-col md:flex-row justify-center items-center gap-4"
                            >
                                <TextInput
                                    id="original_url"
                                    type="text"
                                    class="py-1 block w-full md:w-1/2"
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

                        <div class="overflow-x-scroll">
                            <div
                                v-if="urls.data.length === 0"
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
                                class="table-auto lg:table-fixed w-full text-sm text-left rtl:text-right text-gray-500 rounded"
                            >
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50"
                                >
                                    <tr>
                                        <th scope="col" class="w-40 px-6 py-3">
                                            Shortened URL
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Original URL
                                        </th>
                                        <th
                                            scope="col"
                                            class="w-[22rem] px-6 py-3 text-right"
                                        >
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="url in urls.data"
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
                                        <td class="px-3 py-4 overflow-clip">
                                            <input
                                                v-if="editingUrlId === url.id"
                                                v-model="editingOriginalUrl"
                                                class="py-1 px-3 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm -translate-x-px"
                                            />
                                            <a
                                                v-else
                                                :href="url.original_url"
                                                target="_blank"
                                                class="px-3 text-base text-nowrap"
                                                >{{ url.original_url }}</a
                                            >
                                        </td>
                                        <td
                                            class="px-6 py-4 flex items-center justify-end gap-4"
                                        >
                                            <PrimaryButton
                                                v-if="editingUrlId === url.id"
                                                @click="updateUrl(url.id)"
                                            >
                                                Save
                                            </PrimaryButton>
                                            <SecondaryButton
                                                v-if="editingUrlId === url.id"
                                                @click="cancelEdit"
                                            >
                                                Cancel
                                            </SecondaryButton>
                                            <template v-else>
                                                <CopyLinkIcon
                                                    class="cursor-pointer"
                                                    @click="copyUrl(url.id)"
                                                />
                                                <SecondaryButton
                                                    @click="editUrl(url)"
                                                    >Edit</SecondaryButton
                                                >
                                            </template>
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

                        <Pagination
                            v-if="urls.data.length > 0"
                            :links="urls.links"
                            class="mt-6 flex justify-center"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
