<?php

namespace App\Http\Controllers;

use App\Enum\Currency;
use App\Enum\ProductStatus;
use App\Enum\Unit\Dimension;
use App\Enum\Unit\Weight;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Product/Index', [
            'products' => Product::query()
                ->status($request->query('status'))
                ->search($request->query('q'))
                ->render($request->query('size')),
            'statuses' => [
                'all',
                ProductStatus::ACTIVE,
                ProductStatus::DRAFT,
                ProductStatus::ARCHIVED,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Product/Create', [
            'currencies' => Currency::cases(),
            'dimensionUnit' => Dimension::cases(),
            'weightUnit' => Weight::cases(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        try {
            $input = $request->validated();
            Product::create($input);

            return redirect()->route('products.index')->banner('Successfully created a new product');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to create a new product');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): Response
    {
        return Inertia::render('Product/Show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): Response
    {
        return Inertia::render('Product/Edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            $product->delete();

            return back()->banner('Successfully deleted the product');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to delete the product');
        }
    }

    public function destroyBulk(Request $request): RedirectResponse
    {
        try {
            $ids = explode(',', $request->input('ids'));
            if (count($ids) === 0) {
                return back()->dangerBanner('No product selected!');
            }

            Product::whereIn('id', $ids)->delete();

            return back()->banner('Successfully deleted the selected product(s)');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to delete the selected product(s)');
        }
    }

    public function setStatus(Request $request): RedirectResponse
    {
        try {
            $ids = explode(',', $request->input('ids'));
            if (count($ids) === 0) {
                return back()->dangerBanner('No product selected!');
            }

            $status = ProductStatus::tryFrom($request->input('status'));
            if (!$status) {
                return back()->dangerBanner('Invalid product status!');
            }

            Product::whereIn('id', $ids)->update(['status' => $status]);

            return back()->banner('Successfully change status of the selected product(s)');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to change status of the selected product(s)');
        }
    }
}
