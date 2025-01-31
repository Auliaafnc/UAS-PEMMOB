<?php

namespace App\Filament\Admin\Resources\WidgetsResource\Widgets;

use App\Enums\OrderStatus;
use App\Filament\Admin\Resources\InvoiceResource;
use App\Filament\Admin\Resources\OrderResource;
// use App\Models\Invoice;
use App\Filament\Admin\Resources\TaskResource;
use App\Models\Invoice;
use App\Models\Order;
// use Illuminate\Support\Facades\DB;
use App\Models\Task;
// use Filament\Widgets\LineChartWidget;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget as BaseStatsWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\TableWidget as BaseTableWidget;
use Illuminate\Support\Facades\Auth;

// Define the LatestOrder widget
class LatestSalesOrder extends BaseTableWidget
{
    protected static string $name = 'Latest Sales Order';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Auth::user()->hasAnyRole(['Sales', 'super_admin']);
    }

    public function table(Table $table): Table
    {
        $user = Auth::user();
        $baseQuery = Order::query();

        // Filter orders by employee if the user is not a super_admin
        if (! $user->hasRole('super_admin')) {
            $baseQuery->where('employee_id', $user->employee->id); // Assuming user has an 'employee' relationship
        }

        return $table
            ->query(
                // Use the filtered query and order by created_at for the latest orders
                $baseQuery->orderBy('created_at', 'desc')->limit(10) // Get 10 latest orders
            )
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Order Number')
                    ->wrap()
                    ->sortable()
                    ->searchable()
                    ->columnSpan(['xl' => 5]), // Set column span

                Tables\Columns\TextColumn::make('products.name')
                    ->label('Product Name')
                    ->wrap()
                    ->sortable()
                    ->searchable()
                    ->columnSpan(['xl' => 5]), // Set column span

                Tables\Columns\TextColumn::make('products.typeProduct.name')
                    ->label('Type of Product')
                    ->wrap()
                    ->sortable()
                    ->searchable()
                    ->columnSpan(['xl' => 5]), // Set column span

                Tables\Columns\TextColumn::make('products.regulations.name')
                    ->label('Regulation')
                    ->wrap()
                    ->sortable()
                    ->searchable()
                    ->columnSpan(['xl' => 5]), // Set column span

                Tables\Columns\TextColumn::make('products.parameter.name')
                    ->label('Parameter')
                    ->wrap()
                    ->sortable()
                    ->searchable()
                    ->columnSpan(['xl' => 5]), // Set column span

                Tables\Columns\TextColumn::make('products.methode.name')
                    ->label('Methode')
                    ->wrap()
                    ->sortable()
                    ->searchable()
                    ->columnSpan(['xl' => 5]), // Set column span

                BadgeColumn::make('status')
                    ->label('Status'),

                Tables\Columns\TextColumn::make('products.priceProduct.price')
                    ->label('Price')
                    ->wrap()
                    ->sortable()
                    ->searchable()
                    ->columnSpan(['xl' => 5]), // Set column span

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date Created')
                    ->dateTime('d-m-Y H:i:s') // Date and time format
                    ->sortable()
                    ->columnSpan(['xl' => 5]), // Set column span
            ])
            ->filters([ // Menambahkan filter status menggunakan enum OrderStatus
                Tables\Filters\SelectFilter::make('status')
                    ->label('Order Status')
                    ->options(OrderStatus::options()), // Mengambil pilihan status dari enum OrderStatus
            ])
            ->defaultSort('created_at', 'desc');
    }
}

// Define the TotalOrder widget
class TotalSalesOrder extends BaseStatsWidget
{
    protected static string $widgetName = 'Total Sales Order';

    public static function canView(): bool
    {
        return Auth::user()->hasAnyRole(['Sales', 'super_admin']);
    }

    protected function getStats(): array
    {
        $user = Auth::user();
        $baseQuery = Order::query();

        // Filter orders by employee if the user is not a super_admin
        if (! $user->hasRole('super_admin')) {
            $baseQuery->where('employee_id', $user->employee->id); // Assuming user has an 'employee' relationship
        }

        // Hitung jumlah order berdasarkan status dengan memperhatikan filter di atas
        $soCount = (clone $baseQuery)->where('status', OrderStatus::SO->value)->count();
        $poCount = (clone $baseQuery)->where('status', OrderStatus::PO->value)->count();
        $cancelCount = (clone $baseQuery)->where('status', OrderStatus::CANCEL->value)->count();

        return [
            Stat::make('Sales Orders (SO)', $soCount)
                ->description('Number of orders with Sales Order status')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('success')
                ->url(OrderResource::getUrl('index', ['status' => OrderStatus::SO->value])), // Tambahkan URL untuk SO

            Stat::make('Purchase Orders (PO)', $poCount)
                ->description('Number of orders with Purchase Order status')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('primary')
                ->url(OrderResource::getUrl('index', ['status' => OrderStatus::PO->value])), // Tambahkan URL untuk PO

            Stat::make('Cancelled Orders', $cancelCount)
                ->description('Number of orders with Cancel Order status')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger')
                ->url(OrderResource::getUrl('index', ['status' => OrderStatus::CANCEL->value])), // Tambahkan URL untuk Cancel
        ];
    }
}

class StatusInvoice extends BaseStatsWidget
{
    protected static string $widgetName = 'Status Invoice';

    public static function canView(): bool
    {
        $user = Auth::user();

        // Cek apakah pengguna memiliki salah satu peran yang diizinkan
        if (! $user->hasAnyRole(['Finance', 'super_admin'])) {
            return false;
        }

        // Jika pengguna adalah 'super_admin', mereka dapat melihat semua data
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Cek apakah pengguna berada di branch yang sama dengan invoice yang mereka coba lihat
        $userBranchId = $user->employee->branch_company_id;

        // Ambil semua branch ID yang terkait dengan invoice
        $invoiceBranchIds = Invoice::query()
            ->join('tasks', 'invoices.task_id', '=', 'tasks.id')
            ->join('orders', 'tasks.order_id', '=', 'orders.id')
            ->join('employees', 'orders.employee_id', '=', 'employees.id')
            ->where('employees.branch_company_id', $userBranchId)
            ->pluck('employees.branch_company_id')
            ->unique()
            ->toArray();

        // Cek apakah ada invoice yang tersedia di branch user
        return in_array($userBranchId, $invoiceBranchIds);
    }

    protected function getStats(): array
    {
        $user = Auth::user();
        $baseQuery = Invoice::query()
            ->select('invoices.*') // Memilih kolom dari tabel invoices
            ->join('tasks', 'invoices.task_id', '=', 'tasks.id')
            ->join('orders', 'tasks.order_id', '=', 'orders.id')
            ->join('employees', 'orders.employee_id', '=', 'employees.id');

        // Filter invoices by user role if the user is not a super_admin
        if (! $user->hasRole('super_admin')) {
            $baseQuery->where('employees.branch_company_id', $user->employee->branch_company_id); // Filter invoices by user's branch
        }

        // Menghitung jumlah invoice berdasarkan status
        $waitingPaymentCount = (clone $baseQuery)->where('invoices.status', 'waiting_payment')->count();
        $paidCount = (clone $baseQuery)->where('invoices.status', 'paid')->count();

        return [
            Stat::make('Menunggu Pembayaran', $waitingPaymentCount)
                ->description('Jumlah invoice dengan status Menunggu Pembayaran')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning')
                ->url(InvoiceResource::getUrl('index', ['status' => 'waiting_payment'])),

            Stat::make('Sudah Dibayar', $paidCount)
                ->description('Jumlah invoice dengan status Sudah Dibayar')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success')
                ->url(InvoiceResource::getUrl('index', ['status' => 'paid'])),
        ];
    }
}

class LatestTasks extends BaseTableWidget
{
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        $user = Auth::user();

        // Cek apakah pengguna memiliki salah satu peran yang diizinkan
        if (! $user->hasAnyRole(['Labolatory', 'super_admin'])) {
            return false;
        }

        // Jika pengguna adalah 'super_admin', mereka dapat melihat semua
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Cek apakah pengguna berada di branch yang sama dengan task yang mereka coba lihat
        $userBranchId = $user->employee->branch_company_id;

        // Ambil semua branch ID yang terkait dengan tugas-tugas di Laboratorium
        $taskBranchIds = Task::query()
            ->join('orders', 'tasks.order_id', '=', 'orders.id')
            ->join('employees', 'orders.employee_id', '=', 'employees.id')
            ->where('employees.branch_company_id', $userBranchId)
            ->pluck('employees.branch_company_id')
            ->unique()
            ->toArray();

        // Cek apakah ada task yang tersedia di branch user
        return in_array($userBranchId, $taskBranchIds);
    }

    public function table(Table $table): Table
    {
        $user = Auth::user();
        $baseQuery = Task::query()
            ->select('tasks.*')
            ->join('orders', 'tasks.order_id', '=', 'orders.id')
            ->join('employees', 'orders.employee_id', '=', 'employees.id')
            ->orderBy('tasks.created_at', 'desc')
            ->limit(10); // Display the 10 latest tasks

        // Filter tasks by user role if the user is not a super_admin
        if (! $user->hasRole('super_admin')) {
            $baseQuery->where('employees.branch_company_id', $user->employee->branch_company_id); // Filter tasks by user's branch
        }

        return $table
            ->query($baseQuery)
            ->columns([
                Tables\Columns\TextColumn::make('order.order_number')
                    ->label('Order Number')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('order.products.name')
                    ->wrap()
                    ->sortable()
                    ->label('Product Name'),

                Tables\Columns\TextColumn::make('order.products.typeProduct.name')
                    ->wrap()
                    ->sortable()
                    ->label('Type of Product'),

                Tables\Columns\TextColumn::make('order.products.regulations.name')
                    ->wrap()
                    ->sortable()
                    ->label('Regulation'),

                Tables\Columns\TextColumn::make('order.products.parameter.name')
                    ->wrap()
                    ->sortable()
                    ->label('Parameter'),

                Tables\Columns\TextColumn::make('order.products.methode.name')
                    ->wrap()
                    ->sortable()
                    ->label('Methode'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->colors([
                        'secondary' => 'waiting',
                        'primary' => 'processed',
                        'success' => 'completed',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->date(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'waiting' => 'Waiting',
                        'processed' => 'Processed',
                        'completed' => 'Completed',
                    ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}

class TaskStatusWidget extends BaseStatsWidget
{
    protected static string $widgetName = 'Task Status';

    public static function canView(): bool
    {
        $user = Auth::user();

        // Cek apakah pengguna memiliki salah satu peran yang diizinkan
        if (! $user->hasAnyRole(['Labolatory', 'super_admin'])) {
            return false;
        }

        // Jika pengguna adalah 'super_admin', mereka dapat melihat semua data
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Cek apakah pengguna berada di branch yang sama dengan tugas yang mereka coba lihat
        $userBranchId = $user->employee->branch_company_id;

        // Ambil semua branch ID yang terkait dengan tugas-tugas
        $taskBranchIds = Task::query()
            ->join('orders', 'tasks.order_id', '=', 'orders.id')
            ->join('employees', 'orders.employee_id', '=', 'employees.id')
            ->where('employees.branch_company_id', $userBranchId)
            ->pluck('employees.branch_company_id')
            ->unique()
            ->toArray();

        // Cek apakah ada task yang tersedia di branch user
        return in_array($userBranchId, $taskBranchIds);
    }

    protected function getStats(): array
    {
        $user = Auth::user();
        $baseQuery = Task::query()
            ->select('tasks.*') // Memilih kolom dari tabel tasks
            ->join('orders', 'tasks.order_id', '=', 'orders.id')
            ->join('employees', 'orders.employee_id', '=', 'employees.id');

        // Filter tasks by user role if the user is not a super_admin
        if (! $user->hasRole('super_admin')) {
            $baseQuery->where('employees.branch_company_id', $user->employee->branch_company_id); // Filter tasks by user's branch
        }

        $waitingCount = (clone $baseQuery)->where('tasks.status', 'waiting')->count();
        $processedCount = (clone $baseQuery)->where('tasks.status', 'processed')->count();
        $completedCount = (clone $baseQuery)->where('tasks.status', 'completed')->count();

        return [
            Stat::make('Menunggu', $waitingCount)
                ->description('Tugas yang menunggu tindakan')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning')
                ->url(TaskResource::getUrl('index', ['status' => 'waiting'])),

            Stat::make('Diproses', $processedCount)
                ->description('Tugas yang sedang diproses')
                ->descriptionIcon('heroicon-o-cog')
                ->color('primary')
                ->url(TaskResource::getUrl('index', ['status' => 'processed'])),

            Stat::make('Selesai', $completedCount)
                ->description('Tugas yang sudah selesai')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success')
                ->url(TaskResource::getUrl('index', ['status' => 'completed'])),
        ];
    }
}
