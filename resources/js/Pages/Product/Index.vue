<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { currency, snakeCaseToTitleCase } from '@/util';
import { ref } from 'vue';
import Swal from 'sweetalert2';

const page = usePage();
const selected = ref([]);

const selectAll = () => {
    if (selected.value.length === page.props.products.data?.length) {
        selected.value = [];
    } else {
        selected.value = [];
        selected.value = page.props.products.data.map(product => product.id);
    }
}

const destroy = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#E02424",
        confirmButtonText: "Yes, delete it!",
        cancelButtonColor: "#6875F5",
        cancelButtonText: "No, cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('products.destroy', id), {
                preserveState: true,
                preserveScroll: true,
            });
        }
    });
};

const destroyBulk = () => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#E02424",
        confirmButtonText: "Yes, delete selected product!",
        cancelButtonColor: "#6875F5",
        cancelButtonText: "No, cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            const queryParam = new URLSearchParams({ids: selected.value});
            router.delete(route('products.destroy-bulk') + '?' + queryParam, {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => selected.value = [],
            });
        }
    });
}

const filterStatus = (status) => {
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.append('status', status);
    currentUrl.searchParams.set('page', 1);
    router.get(currentUrl.href, {}, {
        preserveScroll: true,
    });
}

const changeStatus = (id, status) => {
    Swal.fire({
        title: "Are you sure?",
        text: `The product's status will change to ${snakeCaseToTitleCase(status)}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#E02424",
        confirmButtonText: `Yes, I'm sure!`,
        cancelButtonColor: "#6875F5",
        cancelButtonText: "No, cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            const queryParam = new URLSearchParams({ids: id, status: status});
            router.post(route('products.set-status-bulk') + '?' + queryParam, {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => selected.value = [],
            });
        }
    });
}

const changeStatusBulk = (status) => {
    Swal.fire({
        title: "Are you sure?",
        text: `The selected product's status will change to ${snakeCaseToTitleCase(status)}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#E02424",
        confirmButtonText: `Yes, I'm sure!`,
        cancelButtonColor: "#6875F5",
        cancelButtonText: "No, cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            const queryParam = new URLSearchParams({ids: selected.value, status: status});
            router.post(route('products.set-status-bulk') + '?' + queryParam, {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => selected.value = [],
            });
        }
    });
}

const showStatusLabel = ['inactive', 'archived', 'discontinued', 'out_of_stock', 'draft'];

</script>

<template>
    <AppLayout title="Product">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Product
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">

                        <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                            <ul class="flex flex-wrap -mb-px">
                                <li class="me-2" v-for="(status, i) in $page.props.statuses" :key="i">
                                    <a
                                        @click="() => filterStatus(status)"
                                        href="#"
                                        :class="{
                                            'inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500': ($page.props.request?.status ?? 'all') === status,
                                            'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300': ($page.props.request?.status ?? 'all') !== status,
                                        }">
                                        {{ snakeCaseToTitleCase(status) }}
                                    </a>
                                </li>
                            </ul>
                        </div>


                        <div class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
                            <div class="flex items-center flex-1 space-x-4">
                                <h5>
                                    <span class="text-gray-500 me-2">Total Products:</span>
                                    <span class="dark:text-white">{{ $page.props.products.total }}</span>
                                </h5>
                            </div>
                            <div class="flex flex-col flex-shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3">
                                <Link :href="route('products.create')" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Add new product
                                </Link>
                                <button type="button" class="flex items-center justify-center flex-shrink-0 px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-indigo-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                    </svg>
                                    Update stocks 1/250
                                </button>
                                <button type="button" class="flex items-center justify-center flex-shrink-0 px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-indigo-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                        <path d="M7 9l5 -5l5 5" />
                                        <path d="M12 4l0 12" />
                                    </svg>
                                    Export
                                </button>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-all" :checked="selected.length === $page.props.products.data?.length" @change="selectAll" type="checkbox" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-all" class="sr-only">checkbox</label>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-4 py-3">Product</th>
                                        <th scope="col" class="px-4 py-3">Category</th>
                                        <th scope="col" class="px-4 py-3">Price</th>
                                        <th scope="col" class="px-4 py-3">Stock</th>
                                        <th scope="col" class="px-4 py-3">Last Update</th>
                                        <th scope="col" class="px-4 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="$page.props.products?.data?.length">
                                        <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700" v-for="product in $page.props.products.data" :key="product.id">
                                            <td class="w-4 px-4 py-3">
                                                <div class="flex items-center">
                                                    <input :id="`checkbox-table-search-${product.id}`" v-model="selected" :value="product.id" type="checkbox" onclick="event.stopPropagation()" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label :for="`checkbox-table-search-${product.id}`" class="sr-only">checkbox</label>
                                                </div>
                                            </td>
                                            <th scope="row" class="px-4 py-2 text-gray-900 dark:text-white">
                                                <div class="flex flex-col">
                                                    <div class="mb-1" v-if="showStatusLabel.includes(product.status)">
                                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-1 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                                                            {{ snakeCaseToTitleCase(product.status) }}
                                                        </span>
                                                    </div>
                                                    <div class="font-semibold">{{ product.name }}</div>
                                                    <div class="font-light text-gray-500 text-xs">SKU: {{ product.sku ?? '-' }}</div>
                                                </div>
                                            </th>
                                            <td class="px-4 py-2">
                                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2 py-0.5 whitespace-nowrap rounded dark:bg-indigo-900 dark:text-indigo-300">No Category</span>
                                            </td>
                                            <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ currency(product.sale_price, product.currency) }}</td>
                                            <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="flex items-center">
                                                    <div class="inline-block w-4 h-4 mr-2 bg-red-700 rounded-full"></div>
                                                    0
                                                </div>
                                            </td>
                                            <td class="px-4 py-2 font-regular text-gray-900 whitespace-nowrap dark:text-white">{{ product.last_updated_at }}</td>
                                            <td class="px-4 py-3 flex items-center justify-end">
                                                <button :id="`product-id-${product.id}`" :data-dropdown-toggle="`product-id-${product.id}-dropdown`" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                                <div :id="`product-id-${product.id}-dropdown`" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" :aria-labelledby="`product-id-${product.id}`">
                                                        <li>
                                                            <Link :href="route('products.edit', product.id)" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</Link>
                                                        </li>
                                                        <li v-if="product.status === 'active'">
                                                            <a href="#" @click="() => changeStatus(product.id, 'archived')" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Archive</a>
                                                        </li>
                                                        <li v-if="product.status === 'archived'">
                                                            <a href="#" @click="() => changeStatus(product.id, 'active')" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Activate</a>
                                                        </li>
                                                    </ul>
                                                    <div class="py-1">
                                                        <a href="#" @click="() => destroy(product.id)" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr v-else class="border-b dark:border-gray-700">
                                        <th scope="row" colspan="7" class="px-4 py-3 font-medium text-gray-500 whitespace-nowrap dark:text-white text-center">No product. Please create a new product.</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 space-y-3 md:space-y-0 overflow-x-auto">
                            <Pagination :links="$page.props.products.links" :from="$page.props.products.from" :to="$page.props.products.to" :total="$page.props.products.total" />
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <nav v-show="selected.length > 0" class="fixed bottom-0 w-full bg-white shadow-xl z-50 dark:bg-gray-800">
            <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
                <div class="flex">
                    <button @click="() => changeStatusBulk('archived')" v-if="$page.props.request?.status === 'active'" type="button" class="me-2 px-4 py-2 text-sm font-medium text-white rounded-lg bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                        Archive Selected
                    </button>
                    <button @click="() => changeStatusBulk('active')" v-if="$page.props.request?.status === 'archived'" type="button" class="me-2 px-4 py-2 text-sm font-medium text-white rounded-lg bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                        Activate Selected
                    </button>
                    <button @click="destroyBulk" type="button" class="flex items-center justify-center flex-shrink-0 px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-indigo-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Delete Selected
                    </button>
                </div>
                <h5>{{ selected.length }} {{ selected.length > 1 ? 'products' : 'product' }} selected.</h5>
            </div>
        </nav>
    </AppLayout>
</template>
