<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Machine;
use App\Models\SparePart;
use App\Models\InventoryTransaction;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key constraints to allow safe truncate
        Schema::disableForeignKeyConstraints();
        InventoryTransaction::truncate();
        SparePart::truncate();
        Category::truncate();
        Machine::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Create/Retrieve User
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Suvranshu Mohankuda',
                'email' => 'suvranshumohankuda@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        $manager = User::where('role', 'manager')->first();
        if (!$manager) {
            User::create([
                'name' => 'John Manager',
                'email' => 'manager@invcontrol.com',
                'password' => bcrypt('password'),
                'role' => 'manager',
            ]);
        }

        // 2. Create Rich Industrial Categories
        $mech = Category::create([
            'name' => 'Power Transmission & Bearings',
            'description' => 'Industrial bearings, V-belts, shaft couplings, gears, and drive chains.'
        ]);
        $elec = Category::create([
            'name' => 'Electrical & Control Systems',
            'description' => 'PLCs, microcontrollers, proximity sensors, relays, limit switches, and fuses.'
        ]);
        $pneum = Category::create([
            'name' => 'Pneumatics & Cylinders',
            'description' => 'Solenoid valves, pneumatic pistons, actuators, pressure regulators, and fittings.'
        ]);
        $hydr = Category::create([
            'name' => 'Hydraulics & Heavy Fluid',
            'description' => 'Gear pumps, high-pressure hoses, hydraulic seals, gauges, and valves.'
        ]);
        $tools = Category::create([
            'name' => 'Cutting Tools & Tooling',
            'description' => 'Carbide inserts, high-speed end mills, twist drills, and collet chucks.'
        ]);
        $fast = Category::create([
            'name' => 'Fasteners, Gaskets & Seals',
            'description' => 'Hex bolts, socket head screws, neoprene O-rings, copper seals, and thread lockers.'
        ]);

        // 3. Create High-End Workshop Machines
        $cnc = Machine::create([
            'name' => 'CNC Milling Center - Line A',
            'code' => 'CNC-MAX-01',
            'description' => 'High-precision 5-axis milling machine located in the primary assembly division.'
        ]);
        $lathe = Machine::create([
            'name' => 'Precision Lathe - Shop B',
            'code' => 'PL-500X',
            'description' => 'Heavy-duty manual maintenance lathe located in Maintenance Workshop Block 2.'
        ]);
        $compressor = Machine::create([
            'name' => 'Rotary Screw Air Compressor',
            'code' => 'AC-ROT-350',
            'description' => 'Central pneumatic energy supplier located in the East Utility Station.'
        ]);
        $press = Machine::create([
            'name' => 'Hydraulic Stamping Press',
            'code' => 'HP-PRESS-04',
            'description' => '80-ton heavy stamping press used for metal forming in Production Bay C.'
        ]);
        $robot = Machine::create([
            'name' => 'Pick & Place Robotics System',
            'code' => 'ROB-PnP-02',
            'description' => 'Multi-axis automated sorting manipulator located in the Packaging Yard.'
        ]);
        $oven = Machine::create([
            'name' => 'Industrial Thermal Curing Oven',
            'code' => 'OV-THERM-80',
            'description' => 'High-temperature thermal curing kiln situated in the Finishing and Coating department.'
        ]);

        // 4. Create Spare Parts with Realistic Stock Levels and Low-Stock Triggers
        // Low Stock Parts: Stock quantity is <= Min Stock Level. These will highlight low stocks perfectly!
        
        $parts = [];

        // 1
        $parts[] = SparePart::create([
            'name' => 'Deep Groove Ball Bearing 6206-2RS',
            'part_number' => 'BB-6206-2RS',
            'category_id' => $mech->id,
            'machine_id' => $lathe->id,
            'stock_quantity' => 22,
            'min_stock_level' => 5,
            'max_stock_level' => 50,
            'reorder_point' => 12,
            'unit_price' => 380.00
        ]);

        // 2 (Low Stock ⚠️)
        $parts[] = SparePart::create([
            'name' => 'M12 Inductive Proximity Sensor',
            'part_number' => 'SEN-PX-M12',
            'category_id' => $elec->id,
            'machine_id' => $robot->id,
            'stock_quantity' => 2,
            'min_stock_level' => 5,
            'max_stock_level' => 20,
            'reorder_point' => 8,
            'unit_price' => 1450.00
        ]);

        // 3 (Low Stock ⚠️)
        $parts[] = SparePart::create([
            'name' => '5/2-Way Double Solenoid Valve',
            'part_number' => 'VAL-PN-52D',
            'category_id' => $pneum->id,
            'machine_id' => $cnc->id,
            'stock_quantity' => 1,
            'min_stock_level' => 3,
            'max_stock_level' => 10,
            'reorder_point' => 5,
            'unit_price' => 2890.00
        ]);

        // 4 (Out of stock! Low Stock ⚠️)
        $parts[] = SparePart::create([
            'name' => 'Hydraulic Gear Pump 14GPM',
            'part_number' => 'HYD-GP-14',
            'category_id' => $hydr->id,
            'machine_id' => $press->id,
            'stock_quantity' => 0,
            'min_stock_level' => 1,
            'max_stock_level' => 5,
            'reorder_point' => 2,
            'unit_price' => 12400.00
        ]);

        // 5
        $parts[] = SparePart::create([
            'name' => 'Industrial V-Belt A-48',
            'part_number' => 'BEL-V-A48',
            'category_id' => $mech->id,
            'machine_id' => $lathe->id,
            'stock_quantity' => 15,
            'min_stock_level' => 4,
            'max_stock_level' => 30,
            'reorder_point' => 8,
            'unit_price' => 420.00
        ]);

        // 6 (Low Stock ⚠️)
        $parts[] = SparePart::create([
            'name' => 'Solid Carbide End Mill 12mm',
            'part_number' => 'TL-EM-12C',
            'category_id' => $tools->id,
            'machine_id' => $cnc->id,
            'stock_quantity' => 3,
            'min_stock_level' => 8,
            'max_stock_level' => 25,
            'reorder_point' => 12,
            'unit_price' => 1850.00
        ]);

        // 7
        $parts[] = SparePart::create([
            'name' => 'Neoprene O-Ring Assortment Kit',
            'part_number' => 'GSK-OR-NEO',
            'category_id' => $fast->id,
            'machine_id' => $compressor->id,
            'stock_quantity' => 25,
            'min_stock_level' => 5,
            'max_stock_level' => 40,
            'reorder_point' => 10,
            'unit_price' => 950.00
        ]);

        // 8 (Low Stock ⚠️)
        $parts[] = SparePart::create([
            'name' => 'AC Contactor 3-Pole 24V Coils',
            'part_number' => 'EL-CON-3P24',
            'category_id' => $elec->id,
            'machine_id' => $oven->id,
            'stock_quantity' => 2,
            'min_stock_level' => 4,
            'max_stock_level' => 15,
            'reorder_point' => 8,
            'unit_price' => 1650.00
        ]);

        // 9
        $parts[] = SparePart::create([
            'name' => 'Digital Pressure Gauge 400 Bar',
            'part_number' => 'HYD-PG-400',
            'category_id' => $hydr->id,
            'machine_id' => $press->id,
            'stock_quantity' => 7,
            'min_stock_level' => 2,
            'max_stock_level' => 10,
            'reorder_point' => 4,
            'unit_price' => 4800.00
        ]);

        // 10 (Low Stock ⚠️)
        $parts[] = SparePart::create([
            'name' => 'Pneumatic Cylinder 50mm Bore',
            'part_number' => 'CYL-PN-50X100',
            'category_id' => $pneum->id,
            'machine_id' => $robot->id,
            'stock_quantity' => 1,
            'min_stock_level' => 2,
            'max_stock_level' => 6,
            'reorder_point' => 4,
            'unit_price' => 3750.00
        ]);

        // 11
        $parts[] = SparePart::create([
            'name' => 'Flexible Shaft Coupling 20mm-25mm',
            'part_number' => 'MCH-CPL-2025',
            'category_id' => $mech->id,
            'machine_id' => $lathe->id,
            'stock_quantity' => 12,
            'min_stock_level' => 3,
            'max_stock_level' => 20,
            'reorder_point' => 6,
            'unit_price' => 1100.00
        ]);

        // 12
        $parts[] = SparePart::create([
            'name' => 'Cartridge Fuse 10A Fast-Acting',
            'part_number' => 'EL-FUSE-10A',
            'category_id' => $elec->id,
            'machine_id' => $compressor->id,
            'stock_quantity' => 80,
            'min_stock_level' => 20,
            'max_stock_level' => 150,
            'reorder_point' => 50,
            'unit_price' => 85.00
        ]);

        // 13
        $parts[] = SparePart::create([
            'name' => 'Heavy-Duty Limit Switch Omron',
            'part_number' => 'SEN-LIM-OMR',
            'category_id' => $elec->id,
            'machine_id' => $lathe->id,
            'stock_quantity' => 14,
            'min_stock_level' => 4,
            'max_stock_level' => 30,
            'reorder_point' => 8,
            'unit_price' => 1200.00
        ]);

        // 14 (Low Stock ⚠️)
        $parts[] = SparePart::create([
            'name' => 'High-Pressure Hydraulic Hose 2m',
            'part_number' => 'HYD-HSE-12',
            'category_id' => $hydr->id,
            'machine_id' => $press->id,
            'stock_quantity' => 1,
            'min_stock_level' => 3,
            'max_stock_level' => 8,
            'reorder_point' => 5,
            'unit_price' => 1800.00
        ]);

        // 15
        $parts[] = SparePart::create([
            'name' => 'Nachi Tapered Roller Bearing 30206',
            'part_number' => 'BB-TRB-30206',
            'category_id' => $mech->id,
            'machine_id' => $lathe->id,
            'stock_quantity' => 6,
            'min_stock_level' => 2,
            'max_stock_level' => 15,
            'reorder_point' => 4,
            'unit_price' => 720.00
        ]);

        // 5. Create Rich and Realistic Past Transactions (Dated across the last 15 days)
        $remarks = [
            'IN' => [
                'Routine procurement order fulfilled.',
                'Bulk restocking from premium supplier.',
                'Yearly maintenance kit purchase received.',
                'Discrepancy count adjustment - stock added.',
                'Returned spare part from assembly floor (unused).'
            ],
            'OUT' => [
                'Scheduled weekly preventative maintenance.',
                'Emergency replacement due to unexpected wear.',
                'Assembly line breakdown maintenance.',
                'Calibration failure - old part scrapped.',
                'Production run tooling setup replacement.'
            ]
        ];

        // Let's create 24 realistic transactions
        for ($i = 0; $i < 24; $i++) {
            $part = $parts[array_rand($parts)];
            $type = rand(0, 100) > 40 ? 'OUT' : 'IN'; // 60% checkouts, 40% checkins
            $qty = rand(1, 5);

            if ($type === 'OUT') {
                // Keep quantity small for checkouts to avoid negative stocks
                $qty = rand(1, 3);
            } else {
                $qty = rand(5, 15);
            }

            $remarkList = $remarks[$type];
            $remark = $remarkList[array_rand($remarkList)];

            // Create timestamp distributed over the last 14 days
            $daysAgo = rand(0, 14);
            $hourAgo = rand(1, 23);
            $minAgo = rand(1, 59);
            $timestamp = Carbon::now()->subDays($daysAgo)->subHours($hourAgo)->subMinutes($minAgo);

            InventoryTransaction::create([
                'spare_part_id' => $part->id,
                'transaction_type' => $type,
                'quantity' => $qty,
                'user_id' => $user->id,
                'remarks' => $remark,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }
    }
}
