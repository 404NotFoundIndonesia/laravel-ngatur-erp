<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
import { Link, useForm } from '@inertiajs/vue3';
import {currencySymbol, validateNumber} from '@/util';

const form = useForm({
    name: '',
    description: '',
    sku: '',
    weight: '0',
    weight_unit: 'g',
    height: '0',
    width: '0',
    length: '0',
    dimension_unit: 'cm',
    currency: 'IDR',
    original_price: '0',
    sale_price: '0',
    production_cost: '0',
    pre_order: false,
    allow_cod: false,
    contains_hazardous_material: false,
    status: 'active',
});

const submit = () => {
    form.transform(data => ({
        ...data,
        weight: data.weight.replace(/\./g, ''),
        height: data.height.replace(/\./g, ''),
        width: data.width.replace(/\./g, ''),
        length: data.length.replace(/\./g, ''),
        original_price: data.original_price.replace(/\./g, ''),
        sale_price: data.sale_price.replace(/\./g, ''),
        production_cost: data.production_cost.replace(/\./g, ''),
        status: 'active',
    })).post(route('products.store'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => form.reset(),
    });
};

const submitDraft = () => {
    form.transform(data => ({
        ...data,
        weight: data.weight.replace(/\./g, ''),
        height: data.height.replace(/\./g, ''),
        width: data.width.replace(/\./g, ''),
        length: data.length.replace(/\./g, ''),
        original_price: data.original_price.replace(/\./g, ''),
        sale_price: data.sale_price.replace(/\./g, ''),
        production_cost: data.production_cost.replace(/\./g, ''),
        status: 'draft',
    })).post(route('products.store'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Product">
        <template #header>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 rtl:space-x-reverse">
                    <li>
                        <Link :href="route('products.index')">
                            <h2 class="font-semibold text-xl text-gray-400 hover:text-gray-600 leading-tight">
                                Product
                            </h2>
                        </Link>
                    </li>
                    <li class="mx-2">
                        <div>
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                        </div>
                    </li>
                    <li aria-current="page">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Add New Product
                        </h2>
                    </li>
                </ol>
            </nav>
        </template>

        <div class="py-12">
            <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <form @submit.prevent="submit">
                        <div class="py-6 mx-auto px-6 2xl:py-16 2xl:px-16">
                            <h2 class="mb-4 text-xl font-bold text-gray-900">Product Information</h2>
                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <InputLabel for="name" value="Product Name" :required="true" />
                                    <TextInput
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        placeholder="Brand + Type + Feature (Color, Size, etc.)"
                                        autocomplete="off"
                                    />
                                    <InputError :message="form.errors.name" class="mt-2" />
                                </div>
                                <div class="sm:col-span-2">
                                    <InputLabel for="description" value="Description" />
                                    <textarea id="description" v-model="form.description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                                    <InputError :message="form.errors.description" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="py-6 mx-auto px-6 2xl:py-16 2xl:px-16">
                            <h2 class="mb-4 text-xl font-bold text-gray-900">Sales Information</h2>
                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <InputLabel for="sku" value="Product SKU" />
                                    <TextInput
                                        id="sku"
                                        v-model="form.sku"
                                        type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="off"
                                    />
                                    <InputError :message="form.errors.sku" class="mt-2" />
                                </div>
                                <div class="grid gap-4 sm:grid-cols-4 sm:col-span-2">
                                    <div>
                                        <InputLabel for="currency" value="Currency" :required="true" />
                                        <select
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            id="currency"
                                            v-model="form.currency">
                                            <option :value="c" v-for="(c, i) in $page.props.currencies" :key="i">
                                                {{ c }}
                                            </option>
                                        </select>
                                        <InputError :message="form.errors.currency" class="mt-2" />
                                    </div>
                                    <div>
                                        <InputLabel for="production_cost" value="Production Cost" />
                                        <div class="relative mt-1">
                                            <div class="absolute text-gray-400 inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                {{ currencySymbol(form.currency) }}
                                            </div>
                                            <input
                                                type="text"
                                                id="production_cost"
                                                @input="validateNumber( form,'production_cost')"
                                                v-model="form.production_cost"
                                                class="block w-full ps-14 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        </div>
                                        <InputError :message="form.errors.production_cost" class="mt-2" />
                                    </div>
                                    <div>
                                        <InputLabel for="original_price" value="Original Price" />
                                        <div class="relative mt-1">
                                            <div class="absolute text-gray-400 inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                {{ currencySymbol(form.currency) }}
                                            </div>
                                            <input
                                                type="text"
                                                id="original_price"
                                                @input="validateNumber( form,'original_price')"
                                                v-model="form.original_price"
                                                class="block w-full ps-14 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        </div>
                                        <InputError :message="form.errors.original_price" class="mt-2" />
                                    </div>
                                    <div>
                                        <InputLabel for="sale_price" value="Sale Price" :required="true" />
                                        <div class="relative mt-1">
                                            <div class="absolute text-gray-400 inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                {{ currencySymbol(form.currency) }}
                                            </div>
                                            <input
                                                type="text"
                                                id="sale_price"
                                                @input="validateNumber( form,'sale_price')"
                                                v-model="form.sale_price"
                                                class="block w-full ps-14 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        </div>
                                        <InputError :message="form.errors.sale_price" class="mt-2" />
                                    </div>
                                </div>
                                <div>
                                    <InputLabel for="pre-order-no" value="Pre-Order" />
                                    <div class="flex mt-2">
                                        <div class="flex items-center me-12">
                                            <input v-model="form.pre_order" id="pre-order-yes" type="radio" :value="true" name="pre-order-group" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="pre-order-yes" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</label>
                                        </div>
                                        <div class="flex items-center me-12">
                                            <input v-model="form.pre_order" id="pre-order-no" type="radio" :value="false" name="pre-order-group" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="pre-order-no" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="py-6 mx-auto px-6 2xl:py-16 2xl:px-16">
                            <h2 class="mb-4 text-xl font-bold text-gray-900">Shipping Information</h2>
                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <InputLabel for="weight" value="Weight" />
                                        <div class="relative mt-1">
                                            <input
                                                type="text"
                                                id="weight"
                                                @input="validateNumber(form, 'weight')"
                                                v-model="form.weight"
                                                class="block w-full text-right pe-14 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <div class="absolute text-gray-400 inset-y-0 end-0 flex items-center pe-3.5 pointer-events-none">
                                                {{ form.weight_unit }}
                                            </div>
                                        </div>
                                        <InputError :message="form.errors.weight" class="mt-2" />
                                    </div>
                                    <div>
                                        <InputLabel for="weight_unit" value="Weight Unit" />
                                        <select
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            id="weight_unit"
                                            v-model="form.weight_unit">
                                            <option :value="u" v-for="(u, i) in $page.props.weightUnit" :key="i">
                                                {{ u }}
                                            </option>
                                        </select>
                                        <InputError :message="form.errors.weight_unit" class="mt-2" />
                                    </div>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-4 sm:col-span-2">
                                    <div>
                                        <InputLabel for="width" value="Width" />
                                        <div class="relative mt-1">
                                            <input
                                                type="text"
                                                id="width"
                                                @input="validateNumber(form, 'width')"
                                                v-model="form.width"
                                                class="block w-full text-right pe-14 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <div class="absolute text-gray-400 inset-y-0 end-0 flex items-center pe-3.5 pointer-events-none">
                                                {{ form.dimension_unit }}
                                            </div>
                                        </div>
                                        <InputError :message="form.errors.width" class="mt-2" />
                                    </div>
                                    <div>
                                        <InputLabel for="height" value="Height" />
                                        <div class="relative mt-1">
                                            <input
                                                type="text"
                                                id="height"
                                                @input="validateNumber(form, 'height')"
                                                v-model="form.height"
                                                class="block w-full text-right pe-14 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <div class="absolute text-gray-400 inset-y-0 end-0 flex items-center pe-3.5 pointer-events-none">
                                                {{ form.dimension_unit }}
                                            </div>
                                        </div>
                                        <InputError :message="form.errors.height" class="mt-2" />
                                    </div>
                                    <div>
                                        <InputLabel for="length" value="Length" />
                                        <div class="relative mt-1">
                                            <input
                                                type="text"
                                                id="length"
                                                @input="validateNumber(form, 'length')"
                                                v-model="form.length"
                                                class="block w-full text-right pe-14 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <div class="absolute text-gray-400 inset-y-0 end-0 flex items-center pe-3.5 pointer-events-none">
                                                {{ form.dimension_unit }}
                                            </div>
                                        </div>
                                        <InputError :message="form.errors.length" class="mt-2" />
                                    </div>
                                    <div>
                                        <InputLabel for="dimension_unit" value="Dimension Unit" />
                                        <select
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            id="dimension_unit"
                                            v-model="form.dimension_unit">
                                            <option :value="u" v-for="(u, i) in $page.props.dimensionUnit" :key="i">
                                                {{ u }}
                                            </option>
                                        </select>
                                        <InputError :message="form.errors.dimension_unit" class="mt-2" />
                                    </div>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <InputLabel for="allow-cod-no" value="Cash on Delivery" />
                                        <div class="flex mt-2">
                                            <div class="flex items-center me-12">
                                                <input v-model="form.allow_cod" id="allow-cod-yes" type="radio" :value="true" name="allow-cod-group" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="allow-cod-yes" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</label>
                                            </div>
                                            <div class="flex items-center me-12">
                                                <input v-model="form.allow_cod" id="allow-cod-no" type="radio" :value="false" name="allow-cod-group" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="allow-cod-no" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <InputLabel for="hazardous-no" value="Contains Hazardous Material" />
                                        <div class="flex mt-2">
                                            <div class="flex items-center me-12">
                                                <input v-model="form.contains_hazardous_material" id="hazardous-yes" type="radio" :value="true" name="hazardous-group" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="hazardous-yes" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</label>
                                            </div>
                                            <div class="flex items-center me-12">
                                                <input v-model="form.contains_hazardous_material" id="hazardous-no" type="radio" :value="false" name="hazardous-group" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="hazardous-no" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                                Saved.
                            </ActionMessage>
                            <SecondaryButton @click="submitDraft" type="button" :class="{ 'opacity-25': form.processing }" class="me-2" :disabled="form.processing">
                                Save as Draft
                            </SecondaryButton>
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing || (form.original_price == 0 && form.sale_price == 0)">
                                Save
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
