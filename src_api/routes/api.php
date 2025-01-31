<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Filament\Admin\Resources\BranchCompanyResource\Api\Handlers\CreateHandler as BranchCreateHandler;
use App\Filament\Admin\Resources\BranchCompanyResource\Api\Handlers\PaginationHandler as BranchPaginationHandler;
use App\Filament\Admin\Resources\BranchCompanyResource\Api\Handlers\DeleteHandler as BranchDeleteHandler;
use App\Filament\Admin\Resources\BranchCompanyResource\Api\Handlers\DetailHandler as BranchDetailHandler;
use App\Filament\Admin\Resources\BranchCompanyResource\Api\Handlers\UpdateHandler as BranchUpdateHandler;
// client
use App\Filament\Admin\Resources\ClientResource\Api\Handlers\CreateHandler as ClientCreateHandler;
use App\Filament\Admin\Resources\ClientResource\Api\Handlers\PaginationHandler as ClientPaginationHandler;
use App\Filament\Admin\Resources\ClientResource\Api\Handlers\DetailHandler as ClientDetailHandler;
use App\Filament\Admin\Resources\ClientResource\Api\Handlers\UpdateHandler as ClientUpdateHandler;
use App\Filament\Admin\Resources\ClientResource\Api\Handlers\DeleteHandler as ClientDeleteHandler;
// company
use App\Filament\Admin\Resources\CompanyResource\Api\Handlers\CreateHandler as CompanyCreateHandler;
use App\Filament\Admin\Resources\CompanyResource\Api\Handlers\PaginationHandler as CompanyPaginationHandler;
use App\Filament\Admin\Resources\CompanyResource\Api\Handlers\DetailHandler as CompanyDetailHandler;
use App\Filament\Admin\Resources\CompanyResource\Api\Handlers\UpdateHandler as CompanyUpdateHandler;
use App\Filament\Admin\Resources\CompanyResource\Api\Handlers\DeleteHandler as CompanyDeleteHandler;
// department
use App\Filament\Admin\Resources\DepartmentResource\Api\Handlers\CreateHandler as DepartmentCreateHandler;
use App\Filament\Admin\Resources\DepartmentResource\Api\Handlers\PaginationHandler as DepartmentPaginationHandler;
use App\Filament\Admin\Resources\DepartmentResource\Api\Handlers\DetailHandler as DepartmentDetailHandler;
use App\Filament\Admin\Resources\DepartmentResource\Api\Handlers\UpdateHandler as DepartmentUpdateHandler;
use App\Filament\Admin\Resources\DepartmentResource\Api\Handlers\DeleteHandler as DepartmentDeleteHandler;
// Description
use App\Filament\Admin\Resources\DescriptionProductResource\Api\Handlers\CreateHandler as DescriptionCreateHandler;
use App\Filament\Admin\Resources\DescriptionProductResource\Api\Handlers\PaginationHandler as DescriptionPaginationHandler;
use App\Filament\Admin\Resources\DescriptionProductResource\Api\Handlers\DetailHandler as DescriptionDetailHandler;
use App\Filament\Admin\Resources\DescriptionProductResource\Api\Handlers\UpdateHandler as DescriptionUpdateHandler;
use App\Filament\Admin\Resources\DescriptionProductResource\Api\Handlers\DeleteHandler as DescriptionDeleteHandler;
// Discount
use App\Filament\Admin\Resources\DiscountResource\Api\Handlers\CreateHandler as DiscountCreateHandler;
use App\Filament\Admin\Resources\DiscountResource\Api\Handlers\PaginationHandler as DiscountPaginationHandler;
use App\Filament\Admin\Resources\DiscountResource\Api\Handlers\DetailHandler as DiscountDetailHandler;
use App\Filament\Admin\Resources\DiscountResource\Api\Handlers\UpdateHandler as DiscountUpdateHandler;
use App\Filament\Admin\Resources\DiscountResource\Api\Handlers\DeleteHandler as DiscountDeleteHandler;
// Employee
use App\Filament\Admin\Resources\EmployeeResource\Api\Handlers\CreateHandler as EmployeeCreateHandler;
use App\Filament\Admin\Resources\EmployeeResource\Api\Handlers\PaginationHandler as EmployeePaginationHandler;
use App\Filament\Admin\Resources\EmployeeResource\Api\Handlers\DetailHandler as EmployeeDetailHandler;
use App\Filament\Admin\Resources\EmployeeResource\Api\Handlers\UpdateHandler as EmployeeUpdateHandler;
use App\Filament\Admin\Resources\EmployeeResource\Api\Handlers\DeleteHandler as EmployeeDeleteHandler;
// Invoice
use App\Filament\Admin\Resources\InvoiceResource\Api\Handlers\CreateHandler as InvoiceCreateHandler;
use App\Filament\Admin\Resources\InvoiceResource\Api\Handlers\PaginationHandler as InvoicePaginationHandler;
use App\Filament\Admin\Resources\InvoiceResource\Api\Handlers\DetailHandler as InvoiceDetailHandler;
use App\Filament\Admin\Resources\InvoiceResource\Api\Handlers\UpdateHandler as InvoiceUpdateHandler;
use App\Filament\Admin\Resources\InvoiceResource\Api\Handlers\DeleteHandler as InvoiceDeleteHandler;
// Methode
use App\Filament\Admin\Resources\MethodeResource\Api\Handlers\CreateHandler as MethodeCreateHandler;
use App\Filament\Admin\Resources\MethodeResource\Api\Handlers\PaginationHandler as MethodePaginationHandler;
use App\Filament\Admin\Resources\MethodeResource\Api\Handlers\DetailHandler as MethodeDetailHandler;
use App\Filament\Admin\Resources\MethodeResource\Api\Handlers\UpdateHandler as MethodeUpdateHandler;
use App\Filament\Admin\Resources\MethodeResource\Api\Handlers\DeleteHandler as MethodeDeleteHandler;
// Order
use App\Filament\Admin\Resources\OrderResource\Api\Handlers\CreateHandler as OrderCreateHandler;
use App\Filament\Admin\Resources\OrderResource\Api\Handlers\PaginationHandler as OrderPaginationHandler;
use App\Filament\Admin\Resources\OrderResource\Api\Handlers\DetailHandler as OrderDetailHandler;
use App\Filament\Admin\Resources\OrderResource\Api\Handlers\UpdateHandler as OrderUpdateHandler;
use App\Filament\Admin\Resources\OrderResource\Api\Handlers\DeleteHandler as OrderDeleteHandler;
// Parameter
use App\Filament\Admin\Resources\ParameterResource\Api\Handlers\CreateHandler as ParameterCreateHandler;
use App\Filament\Admin\Resources\ParameterResource\Api\Handlers\PaginationHandler as ParameterPaginationHandler;
use App\Filament\Admin\Resources\ParameterResource\Api\Handlers\DetailHandler as ParameterDetailHandler;
use App\Filament\Admin\Resources\ParameterResource\Api\Handlers\UpdateHandler as ParameterUpdateHandler;
use App\Filament\Admin\Resources\ParameterResource\Api\Handlers\DeleteHandler as ParameterDeleteHandler;
// price product
use App\Filament\Admin\Resources\PriceProductResource\Api\Handlers\CreateHandler as PriceProductCreateHandler;
use App\Filament\Admin\Resources\PriceProductResource\Api\Handlers\PaginationHandler as PriceProductPaginationHandler;
use App\Filament\Admin\Resources\PriceProductResource\Api\Handlers\DetailHandler as PriceProductDetailHandler;
use App\Filament\Admin\Resources\PriceProductResource\Api\Handlers\UpdateHandler as PriceProductUpdateHandler;
use App\Filament\Admin\Resources\PriceProductResource\Api\Handlers\DeleteHandler as PriceProductDeleteHandler;
// product
use App\Filament\Admin\Resources\ProductResource\Api\Handlers\CreateHandler as ProductCreateHandler;
use App\Filament\Admin\Resources\ProductResource\Api\Handlers\PaginationHandler as ProductPaginationHandler;
use App\Filament\Admin\Resources\ProductResource\Api\Handlers\DetailHandler as ProductDetailHandler;
use App\Filament\Admin\Resources\ProductResource\Api\Handlers\UpdateHandler as ProductUpdateHandler;
use App\Filament\Admin\Resources\ProductResource\Api\Handlers\DeleteHandler as ProductDeleteHandler;
// Regulation
use App\Filament\Admin\Resources\RegulationResource\Api\Handlers\CreateHandler as RegulationCreateHandler;
use App\Filament\Admin\Resources\RegulationResource\Api\Handlers\PaginationHandler as RegulationPaginationHandler;
use App\Filament\Admin\Resources\RegulationResource\Api\Handlers\DetailHandler as RegulationDetailHandler;
use App\Filament\Admin\Resources\RegulationResource\Api\Handlers\UpdateHandler as RegulationUpdateHandler;
use App\Filament\Admin\Resources\RegulationResource\Api\Handlers\DeleteHandler as RegulationDeleteHandler;
// Task
use App\Filament\Admin\Resources\TaskResource\Api\Handlers\CreateHandler as TaskCreateHandler;
use App\Filament\Admin\Resources\TaskResource\Api\Handlers\PaginationHandler as TaskPaginationHandler;
use App\Filament\Admin\Resources\TaskResource\Api\Handlers\DetailHandler as TaskDetailHandler;
use App\Filament\Admin\Resources\TaskResource\Api\Handlers\UpdateHandler as TaskUpdateHandler;
use App\Filament\Admin\Resources\TaskResource\Api\Handlers\DeleteHandler as TaskDeleteHandler;
// Type Product
use App\Filament\Admin\Resources\TypeProductResource\Api\Handlers\CreateHandler as TypeProductCreateHandler;
use App\Filament\Admin\Resources\TypeProductResource\Api\Handlers\PaginationHandler as TypeProductPaginationHandler;
use App\Filament\Admin\Resources\TypeProductResource\Api\Handlers\DetailHandler as TypeProductDetailHandler;
use App\Filament\Admin\Resources\TypeProductResource\Api\Handlers\UpdateHandler as TypeProductUpdateHandler;
use App\Filament\Admin\Resources\TypeProductResource\Api\Handlers\DeleteHandler as TypeProductDeleteHandler;

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    // Protected route
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('branch_companys')->group(function () {
        Route::post('/', [BranchCreateHandler::class, 'handler'])->name('api.branch_companys.create');
        Route::get('/', [BranchPaginationHandler::class, 'handler'])->name('api.branch_companys.pagination');
        Route::get('/{id}', [BranchDetailHandler::class, 'handler'])->name('api.branch_companys.detail');
        Route::put('/{id}', [BranchUpdateHandler::class, 'handler'])->name('api.branch_companys.update');
        Route::delete('/{id}', [BranchDeleteHandler::class, 'handler'])->name('api.branch_companys.delete');
    });

    Route::prefix('clients')->group(function () {
        Route::post('/', [ClientCreateHandler::class, 'handler'])->name('api.clients.create');
        Route::get('/', [ClientPaginationHandler::class, 'handler'])->name('api.clients.pagination');
        Route::get('/{id}', [ClientDetailHandler::class, 'handler'])->name('api.clients.detail');
        Route::put('/{id}', [ClientUpdateHandler::class, 'handler'])->name('api.clients.update');
        Route::delete('/{id}', [ClientDeleteHandler::class, 'handler'])->name('api.clients.delete');
    });

    Route::prefix('companys')->group(function () {
        Route::post('/', [CompanyCreateHandler::class, 'handler'])->name('api.companys.create');
        Route::get('/', [CompanyPaginationHandler::class, 'handler'])->name('api.companys.pagination');
        Route::get('/{id}', [CompanyDetailHandler::class, 'handler'])->name('api.companys.detail');
        Route::put('/{id}', [CompanyUpdateHandler::class, 'handler'])->name('api.companys.update');
        Route::delete('/{id}', [CompanyDeleteHandler::class, 'handler'])->name('api.companys.delete');
    });

    Route::prefix('departments')->group(function () {
        Route::post('/', [DepartmentCreateHandler::class, 'handler'])->name('api.departments.create');
        Route::get('/', [DepartmentPaginationHandler::class, 'handler'])->name('api.departments.pagination');
        Route::get('/{id}', [DepartmentDetailHandler::class, 'handler'])->name('api.departments.detail');
        Route::put('/{id}', [DepartmentUpdateHandler::class, 'handler'])->name('api.departments.update');
        Route::delete('/{id}', [DepartmentDeleteHandler::class, 'handler'])->name('api.departments.delete');
    });

    Route::prefix('descriptionproducts')->group(function () {
        Route::post('/', [DescriptionCreateHandler::class, 'handler'])->name('api.descriptionproducts.create');
        Route::get('/', [DescriptionPaginationHandler::class, 'handler'])->name('api.descriptionproducts.pagination');
        Route::get('/{id}', [DescriptionDetailHandler::class, 'handler'])->name('api.descriptionproducts.detail');
        Route::put('/{id}', [DescriptionUpdateHandler::class, 'handler'])->name('api.descriptionproducts.update');
        Route::delete('/{id}', [DescriptionDeleteHandler::class, 'handler'])->name('api.descriptionproducts.delete');
    });

    Route::prefix('discounts')->group(function () {
        Route::post('/', [DiscountCreateHandler::class, 'handler'])->name('api.discounts.create');
        Route::get('/', [DiscountPaginationHandler::class, 'handler'])->name('api.discounts.pagination');
        Route::get('/{id}', [DiscountDetailHandler::class, 'handler'])->name('api.discounts.detail');
        Route::put('/{id}', [DiscountUpdateHandler::class, 'handler'])->name('api.discounts.update');
        Route::delete('/{id}', [DiscountDeleteHandler::class, 'handler'])->name('api.discounts.delete');
    });

    Route::prefix('employees')->group(function () {
        Route::post('/', [EmployeeCreateHandler::class, 'handler'])->name('api.employees.create');
        Route::get('/', [EmployeePaginationHandler::class, 'handler'])->name('api.employees.pagination');
        Route::get('/details', [EmployeeDetailHandler::class, 'handler'])->name('api.employees.detail');
        Route::put('/{id}', [EmployeeUpdateHandler::class, 'handler'])->name('api.employees.update');
        Route::delete('/{id}', [EmployeeDeleteHandler::class, 'handler'])->name('api.employees.delete');
    });

    Route::prefix('invoices')->group(function () {
        Route::post('/', [InvoiceCreateHandler::class, 'handler'])->name('api.invoices.create');
        Route::get('/', [InvoicePaginationHandler::class, 'handler'])->name('api.invoices.pagination');
        Route::get('/{id}', [InvoiceDetailHandler::class, 'handler'])->name('api.invoices.detail');
        Route::put('/{id}', [InvoiceUpdateHandler::class, 'handler'])->name('api.invoices.update');
        Route::delete('/{id}', [InvoiceDeleteHandler::class, 'handler'])->name('api.invoices.delete');
    });

    Route::prefix('methodes')->group(function () {
        Route::post('/', [MethodeCreateHandler::class, 'handler'])->name('api.methodes.create');
        Route::get('/', [MethodePaginationHandler::class, 'handler'])->name('api.methodes.pagination');
        Route::get('/{id}', [MethodeDetailHandler::class, 'handler'])->name('api.methodes.detail');
        Route::put('/{id}', [MethodeUpdateHandler::class, 'handler'])->name('api.methodes.update');
        Route::delete('/{id}', [MethodeDeleteHandler::class, 'handler'])->name('api.methodes.delete');
    });

    Route::prefix('orders')->group(function () {
        Route::post('/', [OrderCreateHandler::class, 'handler'])->name('api.orders.create');
        Route::get('/', [OrderPaginationHandler::class, 'handler'])->name('api.orders.pagination');
        Route::get('/{id}', [OrderDetailHandler::class, 'handler'])->name('api.orders.detail');
        Route::put('/{id}', [OrderUpdateHandler::class, 'handler'])->name('api.orders.update');
        Route::delete('/{id}', [OrderDeleteHandler::class, 'handler'])->name('api.orders.delete');
    });

    Route::prefix('parameters')->group(function () {
        Route::post('/', [ParameterCreateHandler::class, 'handler'])->name('api.parameters.create');
        Route::get('/', [ParameterPaginationHandler::class, 'handler'])->name('api.parameters.pagination');
        Route::get('/{id}', [ParameterDetailHandler::class, 'handler'])->name('api.parameters.detail');
        Route::put('/{id}', [ParameterUpdateHandler::class, 'handler'])->name('api.parameters.update');
        Route::delete('/{id}', [ParameterDeleteHandler::class, 'handler'])->name('api.parameters.delete');
    });

    Route::prefix('priceproducts')->group(function () {
        Route::post('/', [PriceProductCreateHandler::class, 'handler'])->name('api.priceproducts.create');
        Route::get('/', [PriceProductPaginationHandler::class, 'handler'])->name('api.priceproducts.pagination');
        Route::get('/{id}', [PriceProductDetailHandler::class, 'handler'])->name('api.priceproducts.detail');
        Route::put('/{id}', [PriceProductUpdateHandler::class, 'handler'])->name('api.priceproducts.update');
        Route::delete('/{id}', [PriceProductDeleteHandler::class, 'handler'])->name('api.priceproducts.delete');
    });

    Route::prefix('products')->group(function () {
        Route::post('/', [ProductCreateHandler::class, 'handler'])->name('api.products.create');
        Route::get('/', [ProductPaginationHandler::class, 'handler'])->name('api.products.pagination');
        Route::get('/{id}', [ProductDetailHandler::class, 'handler'])->name('api.products.detail');
        Route::put('/{id}', [ProductUpdateHandler::class, 'handler'])->name('api.products.update');
        Route::delete('/{id}', [ProductDeleteHandler::class, 'handler'])->name('api.products.delete');
    });

    Route::prefix('regulations')->group(function () {
        Route::post('/', [RegulationCreateHandler::class, 'handler'])->name('api.regulations.create');
        Route::get('/', [RegulationPaginationHandler::class, 'handler'])->name('api.regulations.pagination');
        Route::get('/{id}', [RegulationDetailHandler::class, 'handler'])->name('api.regulations.detail');
        Route::put('/{id}', [RegulationUpdateHandler::class, 'handler'])->name('api.regulations.update');
        Route::delete('/{id}', [RegulationDeleteHandler::class, 'handler'])->name('api.regulations.delete');
    });

    Route::prefix('tasks')->group(function () {
        Route::post('/', [TaskCreateHandler::class, 'handler'])->name('api.tasks.create');
        Route::get('/', [TaskPaginationHandler::class, 'handler'])->name('api.tasks.pagination');
        Route::get('/{id}', [TaskDetailHandler::class, 'handler'])->name('api.tasks.detail');
        Route::put('/{id}', [TaskUpdateHandler::class, 'handler'])->name('api.tasks.update');
        Route::delete('/{id}', [TaskDeleteHandler::class, 'handler'])->name('api.tasks.delete');
    });

    Route::prefix('typeproducts')->group(function () {
        Route::post('/', [TypeProductCreateHandler::class, 'handler'])->name('api.typeproducts.create');
        Route::get('/', [TypeProductPaginationHandler::class, 'handler'])->name('api.typeproducts.pagination');
        Route::get('/{id}', [TypeProductDetailHandler::class, 'handler'])->name('api.typeproducts.detail');
        Route::put('/{id}', [TypeProductUpdateHandler::class, 'handler'])->name('api.typeproducts.update');
        Route::delete('/{id}', [TypeProductDeleteHandler::class, 'handler'])->name('api.typeproducts.delete');
    });
});
