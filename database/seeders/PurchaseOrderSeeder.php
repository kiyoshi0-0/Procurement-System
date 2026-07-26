<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;

class PurchaseOrderSeeder extends Seeder
{
    public function run(): void
    {
        $supplierIds = Supplier::orderBy('id')->pluck('id')->toArray();

        if (empty($supplierIds)) {
            $supplierIds = [Supplier::factory()->create()->id];
        }

        $orders = [
            ['po_number' => 'PO-2026-097', 'status' => 'Delivered', 'supplier' => $supplierIds[0] ?? 1, 'date' => '2026-07-01', 'items' => [
                ['name' => 'Printer Toner Cartridge', 'qty' => 3, 'price' => 1250],
                ['name' => 'Office Paper Ream', 'qty' => 2, 'price' => 900],
            ]],
            ['po_number' => 'PO-2026-098', 'status' => 'Delivered', 'supplier' => $supplierIds[1 % count($supplierIds)], 'date' => '2026-07-02', 'items' => [
                ['name' => 'Power Drill Set', 'qty' => 4, 'price' => 680],
                ['name' => 'Safety Glasses', 'qty' => 1, 'price' => 420],
            ]],
            ['po_number' => 'PO-2026-099', 'status' => 'Delivered', 'supplier' => $supplierIds[2 % count($supplierIds)], 'date' => '2026-07-03', 'items' => [
                ['name' => 'Industrial Hammer', 'qty' => 2, 'price' => 1500],
                ['name' => 'Toolbox Kit', 'qty' => 3, 'price' => 550],
            ]],
            ['po_number' => 'PO-2026-100', 'status' => 'Delivered', 'supplier' => $supplierIds[3 % count($supplierIds)], 'date' => '2026-07-04', 'items' => [
                ['name' => 'Executive Desk Chair', 'qty' => 6, 'price' => 320],
                ['name' => 'Desk Organizer Set', 'qty' => 5, 'price' => 180],
            ]],
            ['po_number' => 'PO-2026-101', 'status' => 'Delivered', 'supplier' => $supplierIds[4 % count($supplierIds)], 'date' => '2026-07-05', 'items' => [
                ['name' => 'Medical Supply Kit', 'qty' => 2, 'price' => 2500],
                ['name' => 'First Aid Cabinet', 'qty' => 1, 'price' => 1100],
            ]],
            ['po_number' => 'PO-2026-102', 'status' => 'Delivered', 'supplier' => $supplierIds[5 % count($supplierIds)], 'date' => '2026-07-06', 'items' => [
                ['name' => 'Network Switch', 'qty' => 5, 'price' => 980],
                ['name' => 'Fiber Patch Cable', 'qty' => 2, 'price' => 780],
            ]],
            ['po_number' => 'PO-2026-103', 'status' => 'Delivered', 'supplier' => $supplierIds[6 % count($supplierIds)], 'date' => '2026-07-07', 'items' => [
                ['name' => 'Stationery Bundle', 'qty' => 10, 'price' => 120],
                ['name' => 'Notebook Pack', 'qty' => 4, 'price' => 90],
            ]],
            ['po_number' => 'PO-2026-104', 'status' => 'Delivered', 'supplier' => $supplierIds[7 % count($supplierIds)], 'date' => '2026-07-08', 'items' => [
                ['name' => 'Catering Set', 'qty' => 8, 'price' => 240],
                ['name' => 'Snack Pack', 'qty' => 6, 'price' => 160],
            ]],
            ['po_number' => 'PO-2026-105', 'status' => 'Sent', 'supplier' => $supplierIds[8 % count($supplierIds)], 'date' => '2026-07-09', 'items' => [
                ['name' => 'Industrial Valve', 'qty' => 3, 'price' => 1600],
                ['name' => 'Pipe Sealant', 'qty' => 2, 'price' => 950],
            ]],
            ['po_number' => 'PO-2026-106', 'status' => 'Sent', 'supplier' => $supplierIds[9 % count($supplierIds)], 'date' => '2026-07-10', 'items' => [
                ['name' => 'Hydraulic Pump', 'qty' => 2, 'price' => 2200],
                ['name' => 'Pressure Gauge', 'qty' => 1, 'price' => 1400],
            ]],
            ['po_number' => 'PO-2026-107', 'status' => 'Sent', 'supplier' => $supplierIds[10 % count($supplierIds)], 'date' => '2026-07-11', 'items' => [
                ['name' => 'Mechanical Gear Set', 'qty' => 7, 'price' => 400],
                ['name' => 'Bearing Assembly', 'qty' => 3, 'price' => 300],
            ]],
            ['po_number' => 'PO-2026-108', 'status' => 'Sent', 'supplier' => $supplierIds[11 % count($supplierIds)], 'date' => '2026-07-12', 'items' => [
                ['name' => 'Marine Rope', 'qty' => 4, 'price' => 750],
                ['name' => 'Docking Hook', 'qty' => 2, 'price' => 600],
            ]],
            ['po_number' => 'PO-2026-109', 'status' => 'Sent', 'supplier' => $supplierIds[12 % count($supplierIds)], 'date' => '2026-07-13', 'items' => [
                ['name' => 'Logistics Tracker', 'qty' => 5, 'price' => 900],
                ['name' => 'Routing Board', 'qty' => 3, 'price' => 450],
            ]],
            ['po_number' => 'PO-2026-110', 'status' => 'Sent', 'supplier' => $supplierIds[13 % count($supplierIds)], 'date' => '2026-07-14', 'items' => [
                ['name' => 'Laptop Workstation', 'qty' => 2, 'price' => 1800],
                ['name' => 'USB Docking Station', 'qty' => 4, 'price' => 500],
            ]],
            ['po_number' => 'PO-2026-111', 'status' => 'Sent', 'supplier' => $supplierIds[14 % count($supplierIds)], 'date' => '2026-07-15', 'items' => [
                ['name' => 'Server Rack', 'qty' => 3, 'price' => 1200],
                ['name' => 'Backup Power Unit', 'qty' => 1, 'price' => 880],
            ]],
        ];

        foreach ($orders as $orderData) {
            $po = PurchaseOrder::firstOrCreate([
                'po_number' => $orderData['po_number'],
            ], [
                'date' => $orderData['date'],
                'supplier_id' => $orderData['supplier'],
                'status' => $orderData['status'],
                'delivery_address' => 'Dasmariñas, Cavite',
            ]);

            if ($po->wasRecentlyCreated) {
                foreach ($orderData['items'] as $item) {
                    PurchaseOrderItem::create([
                        'purchase_order_id' => $po->id,
                        'name' => $item['name'],
                        'qty' => $item['qty'],
                        'price' => $item['price'],
                    ]);
                }
            }
        }
    }
}
