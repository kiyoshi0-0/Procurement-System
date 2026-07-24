<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition()
    {
        // Real PC parts manufacturers mapped to your exact model categories
        $pcSuppliers = [
            // Graphics
            ['name' => 'NVIDIA Corporation', 'category' => 'Graphics', 'sub_categories' => 'GPUs & AI Accelerators'],
            ['name' => 'Advanced Micro Devices (AMD)', 'category' => 'Graphics', 'sub_categories' => 'Radeon Graphics Processors'],
            ['name' => 'Intel Corporation', 'category' => 'Graphics', 'sub_categories' => 'Arc Graphics & Processors'],
            ['name' => 'Sapphire Technology', 'category' => 'Graphics', 'sub_categories' => 'AMD Custom Partner GPUs'],
            ['name' => 'PowerColor (TUL Corporation)', 'category' => 'Graphics', 'sub_categories' => 'High-Performance Graphics Cards'],
            ['name' => 'XFX', 'category' => 'Graphics', 'sub_categories' => 'AMD Radeon Graphics'],
            ['name' => 'Zotac Technology', 'category' => 'Graphics', 'sub_categories' => 'Mini PCs & NVIDIA GPUs'],
            ['name' => 'PNY Technologies', 'category' => 'Graphics', 'sub_categories' => 'NVIDIA Quadro & GeForce GPUs'],
            ['name' => 'Colorful Technology', 'category' => 'Graphics', 'sub_categories' => 'Motherboards & Custom GPUs'],
            ['name' => 'Inno3D', 'category' => 'Graphics', 'sub_categories' => 'Gaming Graphics Cards'],
            ['name' => 'Maxsun', 'category' => 'Graphics', 'sub_categories' => 'Motherboards & Desktop GPUs'],
            ['name' => 'Yeston', 'category' => 'Graphics', 'sub_categories' => 'Stylized Custom Graphics Cards'],
            ['name' => 'Gainward', 'category' => 'Graphics', 'sub_categories' => 'GeForce Graphics Solutions'],
            ['name' => 'Palit Microsystems', 'category' => 'Graphics', 'sub_categories' => 'Consumer Graphics Cards'],
            ['name' => 'Galax', 'category' => 'Graphics', 'sub_categories' => 'Overclocking Series GPUs'],
            ['name' => 'Kuroutoshikou', 'category' => 'Graphics', 'sub_categories' => 'PC Components & Graphics'],
            ['name' => 'Gunnir', 'category' => 'Graphics', 'sub_categories' => 'Intel Arc Custom Partner Cards'],
            ['name' => 'Vastarmor', 'category' => 'Graphics', 'sub_categories' => 'Radeon Custom Graphics'],
            ['name' => 'Aetina Corporation', 'category' => 'Graphics', 'sub_categories' => 'Industrial Graphics Solutions'],
            ['name' => 'Leadtek Research', 'category' => 'Graphics', 'sub_categories' => 'NVIDIA Professional Graphics'],

            // --- Power Supply (21-40) ---
            ['name' => 'Seasonic Electronics', 'category' => 'Power Supply', 'sub_categories' => 'ATX & SFX Power Supplies'],
            ['name' => 'Super Flower Computer', 'category' => 'Power Supply', 'sub_categories' => 'High-Efficiency PSUs'],
            ['name' => 'FSP Group', 'category' => 'Power Supply', 'sub_categories' => 'OEM & Retail Power Units'],
            ['name' => 'Be Quiet!', 'category' => 'Power Supply', 'sub_categories' => 'Low-Noise Power Supplies'],
            ['name' => 'Enermax Technology', 'category' => 'Power Supply', 'sub_categories' => 'Modular Power Units'],
            ['name' => 'Silverstone Technology', 'category' => 'Power Supply', 'sub_categories' => 'Compact SFX & ATX PSUs'],
            ['name' => 'Delta Electronics', 'category' => 'Power Supply', 'sub_categories' => 'Enterprise & Server Power'],
            ['name' => 'Channel Well Technology (CWT)', 'category' => 'Power Supply', 'sub_categories' => 'OEM Power Infrastructure'],
            ['name' => 'Sirfa Electronics', 'category' => 'Power Supply', 'sub_categories' => 'Power Conversion Units'],
            ['name' => 'High Power (Sirtec)', 'category' => 'Power Supply', 'sub_categories' => 'Desktop Power Systems'],
            ['name' => 'Great Wall Corporation', 'category' => 'Power Supply', 'sub_categories' => 'Standard & Modular PSUs'],
            ['name' => 'HuntKey Power', 'category' => 'Power Supply', 'sub_categories' => 'Power Delivery Systems'],
            ['name' => 'Apevia', 'category' => 'Power Supply', 'sub_categories' => 'Budget Gaming PSUs'],
            ['name' => 'Rosewill', 'category' => 'Power Supply', 'sub_categories' => 'PC Power Components'],
            ['name' => 'Azza', 'category' => 'Power Supply', 'sub_categories' => 'Digital Power Units'],
            ['name' => 'Raidmax', 'category' => 'Power Supply', 'sub_categories' => 'Modular Power Supplies'],
            ['name' => 'Xilence', 'category' => 'Power Supply', 'sub_categories' => 'Quiet PC Power Supplies'],
            ['name' => 'Lepa Technology', 'category' => 'Power Supply', 'sub_categories' => 'Gaming Power Supplies'],
            ['name' => 'Antec', 'category' => 'Power Supply', 'sub_categories' => 'High-Current Power Units'],
            ['name' => 'Cougar Gaming', 'category' => 'Power Supply', 'sub_categories' => '80+ Certified Power Supplies'],

            // --- Storage (41-65) ---
            ['name' => 'Western Digital', 'category' => 'Storage', 'sub_categories' => 'NVMe M.2 SSDs & HDDs'],
            ['name' => 'Seagate Technology', 'category' => 'Storage', 'sub_categories' => 'High-Capacity Enterprise Storage'],
            ['name' => 'Samsung Electronics', 'category' => 'Storage', 'sub_categories' => 'Enterprise & Consumer SSDs'],
            ['name' => 'Kingston Technology', 'category' => 'Storage', 'sub_categories' => 'SATA & NVMe Solid State Drives'],
            ['name' => 'Crucial (Micron)', 'category' => 'Storage', 'sub_categories' => 'DRAM & Consumer SSDs'],
            ['name' => 'SanDisk', 'category' => 'Storage', 'sub_categories' => 'Flash Storage Solutions'],
            ['name' => 'Lexar', 'category' => 'Storage', 'sub_categories' => 'Performance SSDs & Memory'],
            ['name' => 'SK Hynix', 'category' => 'Storage', 'sub_categories' => 'NAND Flash & NVMe SSDs'],
            ['name' => 'Kioxia Corporation', 'category' => 'Storage', 'sub_categories' => 'BiCS FLASH Memory SSDs'],
            ['name' => 'Sabrent', 'category' => 'Storage', 'sub_categories' => 'High-Speed PCIe NVMe SSDs'],
            ['name' => 'ADATA Technology', 'category' => 'Storage', 'sub_categories' => 'Solid State Storage'],
            ['name' => 'TeamGroup', 'category' => 'Storage', 'sub_categories' => 'T-Force Gaming Storage'],
            ['name' => 'Patriot Memory', 'category' => 'Storage', 'sub_categories' => 'Viper Gaming SSDs'],
            ['name' => 'Silicon Power', 'category' => 'Storage', 'sub_categories' => 'Internal Storage Solutions'],
            ['name' => 'Verbatim', 'category' => 'Storage', 'sub_categories' => 'External & Internal Storage'],
            ['name' => 'Apacer Technology', 'category' => 'Storage', 'sub_categories' => 'Industrial & Consumer SSDs'],
            ['name' => 'Other World Computing (OWC)', 'category' => 'Storage', 'sub_categories' => 'Mac & PC Storage Solutions'],
            ['name' => 'Transcend Information', 'category' => 'Storage', 'sub_categories' => 'Flash Modules & SSDs'],
            ['name' => 'InnoDisk', 'category' => 'Storage', 'sub_categories' => 'Industrial Flash Storage'],
            ['name' => 'QNAP Systems', 'category' => 'Storage', 'sub_categories' => 'Network Attached Storage (NAS)'],
            ['name' => 'Synology', 'category' => 'Storage', 'sub_categories' => 'Data Storage & NAS Hardware'],
            ['name' => 'Netac Technology', 'category' => 'Storage', 'sub_categories' => 'Portable & Internal SSDs'],
            ['name' => 'Ramsta', 'category' => 'Storage', 'sub_categories' => 'Solid State Drives'],
            ['name' => 'Biwin Storage', 'category' => 'Storage', 'sub_categories' => 'Embedded Storage Components'],
            ['name' => 'YMTC', 'category' => 'Storage', 'sub_categories' => '3D NAND Flash Components'],

            // --- Cooling (66-93) ---
            ['name' => 'Noctua', 'category' => 'Cooling', 'sub_categories' => 'CPU Air Coolers & Premium Fans'],
            ['name' => 'Arctic', 'category' => 'Cooling', 'sub_categories' => 'Thermal Paste & Liquid Coolers'],
            ['name' => 'Thermalright', 'category' => 'Cooling', 'sub_categories' => 'High-Performance Heatsinks'],
            ['name' => 'DeepCool', 'category' => 'Cooling', 'sub_categories' => 'AIO Liquid Coolers & Chassis'],
            ['name' => 'Cooler Master', 'category' => 'Cooling', 'sub_categories' => 'Liquid AIO Coolers & Fans'],
            ['name' => 'NZXT', 'category' => 'Cooling', 'sub_categories' => 'Kraken Liquid Coolers'],
            ['name' => 'Corsair Gaming', 'category' => 'Cooling', 'sub_categories' => 'iCUE Liquid CPU Coolers'],
            ['name' => 'EK Water Blocks (EKWB)', 'category' => 'Cooling', 'sub_categories' => 'Custom Loop Liquid Cooling'],
            ['name' => 'Lian Li', 'category' => 'Cooling', 'sub_categories' => 'Unifans & Cooling Accessories'],
            ['name' => 'ID-Cooling', 'category' => 'Cooling', 'sub_categories' => 'Affordable CPU Coolers'],
            ['name' => 'Scythe', 'category' => 'Cooling', 'sub_categories' => 'Compact CPU Air Coolers'],
            ['name' => 'Alpenföhn', 'category' => 'Cooling', 'sub_categories' => 'Specialized Thermal Solutions'],
            ['name' => 'Raijintek', 'category' => 'Cooling', 'sub_categories' => 'Custom Water Blocks & Coolers'],
            ['name' => 'Phanteks', 'category' => 'Cooling', 'sub_categories' => 'Glacier Water Blocks & Fans'],
            ['name' => 'Thermaltake', 'category' => 'Cooling', 'sub_categories' => 'Pacific Liquid Cooling Gear'],
            ['name' => 'Jonsbo', 'category' => 'Cooling', 'sub_categories' => 'Aesthetic CPU Coolers'],
            ['name' => 'Vetroo', 'category' => 'Cooling', 'sub_categories' => 'RGB Air & Liquid Coolers'],
            ['name' => 'Gelid Solutions', 'category' => 'Cooling', 'sub_categories' => 'Thermal Compounds & Fans'],
            ['name' => 'Watercool', 'category' => 'Cooling', 'sub_categories' => 'HEATKILLER Custom Loops'],
            ['name' => 'Alphacool', 'category' => 'Cooling', 'sub_categories' => 'Radiators & Water Cooling'],
            ['name' => 'Barrow', 'category' => 'Cooling', 'sub_categories' => 'Water Cooling Fittings & Pumps'],
            ['name' => 'Bykski', 'category' => 'Cooling', 'sub_categories' => 'GPU Water Blocks & Pumps'],
            ['name' => 'Swiftech', 'category' => 'Cooling', 'sub_categories' => 'Liquid Cooling Systems'],
            ['name' => 'Thermal Grizzly', 'category' => 'Cooling', 'sub_categories' => 'Extreme Thermal Compounds'],
            ['name' => 'Prolimatech', 'category' => 'Cooling', 'sub_categories' => 'High-End Heatsinks'],
            ['name' => 'Endorfy (SilentiumPC)', 'category' => 'Cooling', 'sub_categories' => 'Silent CPU Coolers'],
            ['name' => 'Zalman Tech', 'category' => 'Cooling', 'sub_categories' => 'Copper Coolers & Cases'],
            ['name' => 'Aerocool', 'category' => 'Cooling', 'sub_categories' => 'Case Fans & Cooling Kits'],

            // --- Components (94-100) ---
            ['name' => 'ASUSTeK Computer (ASUS)', 'category' => 'Components', 'sub_categories' => 'ROG Motherboards & Hardware'],
            ['name' => 'Micro-Star International (MSI)', 'category' => 'Components', 'sub_categories' => 'Motherboards & PC Hardware'],
            ['name' => 'Gigabyte Technology', 'category' => 'Components', 'sub_categories' => 'Motherboards & Expansion Cards'],
            ['name' => 'ASRock Inc.', 'category' => 'Components', 'sub_categories' => 'Taichi & Phantom Motherboards'],
            ['name' => 'Biostar Microtech', 'category' => 'Components', 'sub_categories' => 'Motherboards & Industrial PCs'],
            ['name' => 'G.Skill International', 'category' => 'Components', 'sub_categories' => 'High-Performance DDR5 RAM'],
            ['name' => 'Fractal Design', 'category' => 'Components', 'sub_categories' => 'Chassis & PC Components'],
        ];

        // Randomly select one of the real tech manufacturers
        $supplier = $this->faker->randomElement($pcSuppliers);

        return [
            'name' => $supplier['name'],
            'category' => $supplier['category'],
            'sub_categories' => $supplier['sub_categories'],
            'contact_person' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->address,
            'payment_terms' => $this->faker->randomElement(['Net 30', 'Net 60', 'COD']),
            'delivery_schedule' => $this->faker->randomElement(['Weekly', 'Bi-Weekly', 'Monthly']),
            'rating' => $this->faker->randomFloat(1, 4.0, 5.0),
        ];
    }
}