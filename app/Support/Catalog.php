<?php

namespace App\Support;

use Illuminate\Support\Collection;

class Catalog
{
    public static function products(): Collection
    {
        return collect([
            [
                'slug' => 'kensho-lounge-chair',
                'name' => 'Kensho Lounge Chair',
                'category' => 'Living Room',
                'sub_category' => 'Furniture',
                'price' => 128000,
                'stock' => 24,
                'badge' => 'New In',
                'material' => 'Oak, linen',
                'color_options' => [['name' => 'Warm Oak', 'hex' => '#8d6e63'], ['name' => 'Black Ash', 'hex' => '#303221'], ['name' => 'Natural Linen', 'hex' => '#e4e4cc']],
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAWM1M57ISHZKoarcuTfSZB1xL_EE56PCwHL6gMbZr5fQaqagqERD0m21WDk8o46SN4zbXmq_E8e9F6hYhb86_6zbekM6_mLesCq0ihrSaTbenQPqcwOprDMB6THMrAOR0UAdYynHzF-Zu4rh-lWFZF99fdCyR_kPr4f8Cuiu8AeUtuGIp313bHs3StB_AUiSV6nKQSHvZISpOLoY5uAx3kHozzyIgY_EAs_9wYM8I41jemWEzK2GQCvuVddKXdZtlktnO2O1Nas0Q',
                'description' => 'A low-slung lounge chair shaped for quiet rooms, natural light, and long pauses.',
                'details' => ['Hand-finished solid oak frame', 'Removable natural linen cushions', 'Made to order in 3 finishes'],
            ],
            [
                'slug' => 'aura-dining-chair',
                'name' => 'Aura Dining Chair',
                'category' => 'Dining',
                'sub_category' => 'Furniture',
                'price' => 64000,
                'stock' => 42,
                'badge' => 'Limited',
                'material' => 'Black ash, woven cord',
                'color_options' => [['name' => 'Black Ash', 'hex' => '#303221'], ['name' => 'Walnut', 'hex' => '#72564c'], ['name' => 'Cord Natural', 'hex' => '#c8b99f']],
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCnGI2jQk6chXNFwhHbyMQ8mpuJ6idLG7zTiejhYu3MHKdcYuIacD2O7WkeNzyiSdXbxUgAVS06_m1yplQH79GikA-SvtiGRUf8yJfZtc_sWWhUhg91S4lLNRZQw4I1mYUgjkjPKW4KyeO0Ojl32lE0ANH1b-chI7fRCOFFSI-dsZ5i-sIna5dsATlZZxRDsPZ-D4y7TmMT96q_-VIu5eq9l5dPhET84BkZ6IYxGDglDSkHGtCj7Oqr1YwNp7blxxc28ZFZFfnN-sw',
                'description' => 'A refined dining chair with a structured silhouette and quietly tactile woven seat.',
                'details' => ['Stackable for project installs', 'Matte water-based finish', 'Contract-grade joinery'],
            ],
            [
                'slug' => 'solstice-stone-stool',
                'name' => 'Solstice Stone Stool',
                'category' => 'Living Room',
                'sub_category' => 'Decor',
                'price' => 92000,
                'stock' => 12,
                'badge' => 'Artisan',
                'material' => 'Travertine',
                'color_options' => [['name' => 'Ivory Travertine', 'hex' => '#e4e4cc'], ['name' => 'Sand Stone', 'hex' => '#c8b99f']],
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAJgZ6HQmDpLR3nemlcmgPg9DMhpeemov0DHXEIb0930YDRRTwmb6UfR-DhLnhU3GKA8D6UOSXLXMIj_fxRxb-gSd12eUVsIYde_AZirgz7kluUJZpFQoHjpMk5RjSf59JREhkdDUsMM1eynreq0Tw3SssgD3Xc3-TaZj8qR9N6ClFaJhwyVHrvtrf0pdnXTQMIOTg39VqsCiP4vgsueeX0BmayAtjE2breNbrUSa_EKFcKtLbvRhag6xlJihCmrUI1fY3VyrmKuvQ',
                'description' => 'A sculptural block stool cut from natural stone, each piece carrying its own veining.',
                'details' => ['Honed travertine surface', 'Felt-protected underside', 'Indoor use recommended'],
            ],
            [
                'slug' => 'monolith-coffee-table',
                'name' => 'Monolith Coffee Table',
                'category' => 'Living Room',
                'sub_category' => 'Furniture',
                'price' => 184000,
                'stock' => 8,
                'badge' => 'Signature',
                'material' => 'Travertine marble',
                'color_options' => [['name' => 'Classic Travertine', 'hex' => '#d4c3be'], ['name' => 'Deep Stone', 'hex' => '#504441']],
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCoWfYDhHcLIQnbVuR5efuZRX_If7gN89JacFBHuY0RiYbUQb6nzn-X8uAfjhfwJdCWOOxvGuw6A779RbFqDbZYo1BUtiDJiAGbzI0aGAXFagR35Z7w8Z5hJ-ENeqdmiTDb0jT5zEo5Ie-yYfvpbkHPSfak6BpwC3ElnJyuDsKHROYFUbkccDBh0H9ZSVJZLihlk9FFG8yUhsqIvgvw7K1AH9tcz8nCLquQ8NLuXAGPCAxK9VIllKsNr8KTp95qHm--KhoYP-8gBCg',
                'description' => 'A grounded center table with softened edges and book-matched stone movement.',
                'details' => ['Sealed natural stone', 'Two-piece delivery', 'White-glove installation available'],
            ],
            [
                'slug' => 'linea-floor-lamp',
                'name' => 'Linea Floor Lamp',
                'category' => 'Bedroom',
                'sub_category' => 'Lighting',
                'price' => 41000,
                'stock' => 31,
                'badge' => 'Ready',
                'material' => 'Powder-coated steel, linen',
                'color_options' => [['name' => 'Matte Black', 'hex' => '#303221'], ['name' => 'Soft White', 'hex' => '#fbfbe2'], ['name' => 'Brushed Brass', 'hex' => '#705937']],
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBjn7ReYc_HeuRitRigAjfjVBk_AJHxQ0RXmfVU9XYIS03dG-kxWRaTRY7tlFcrAptIRcYGj8LhqG_DKuPh0bT6YBg4w-RnuFcO95D86Ti_eXzYSsnicMbQDIstCf3WP-Y5fBuHYmviifmsQuJAczxN4ZS9foBocE_d0SQZiQKnWCMiY1ann7XjB23El3N1kPaoH4uhnaZDE6Q6tbgd-6JINJ4Ou35T6gAUqVh_DjOkzZS1xVNMB1moK4DpnEbFp3j0utYaZG7oUak',
                'description' => 'A slim floor lamp for layered ambient light beside lounge chairs and beds.',
                'details' => ['Dimmable warm LED', 'Weighted steel base', 'Natural linen shade'],
            ],
            [
                'slug' => 'tessera-wool-rug',
                'name' => 'Tessera Wool Rug',
                'category' => 'Bedroom',
                'sub_category' => 'Textiles',
                'price' => 76000,
                'stock' => 19,
                'badge' => 'Handwoven',
                'material' => 'New Zealand wool',
                'color_options' => [['name' => 'Ivory', 'hex' => '#fbfbe2'], ['name' => 'Oat', 'hex' => '#dbdcc3'], ['name' => 'Warm Grey', 'hex' => '#827470']],
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB3EpRzhv6XrUiGUSPzRFmsOx5i-se9Jgb755hvyZx9jNBLHPOWXmEFiZZofUSpLuMo60iDYbAihd8KXh2i7yAI9H4XlJf7mj5eoaVztfRCPALJW_wNWRTl3djwZBTjjiDQAwfp2Ncx68K8qSVvz1bDvmTpIyUbHT9Z62AGZYClbY93Kn_RX7LX8K-9RVwK9RzrWaE1SrKgGqdlHhNmqG4ip1dZii9x9I0i4dw7jVIhO74-ZkwMzJL_LowSYXqv02OK_fOtz4V2Kdc',
                'description' => 'A deeply textured wool rug that brings warmth to concrete, oak, and stone floors.',
                'details' => ['Available in 4 sizes', 'Handwoven texture', 'Natural ivory palette'],
            ],
            [
                'slug' => 'serene-platform-bed',
                'name' => 'Serene Platform Bed',
                'category' => 'Bedroom',
                'sub_category' => 'Furniture',
                'price' => 146000,
                'stock' => 14,
                'badge' => 'Bestseller',
                'material' => 'Ash wood, upholstered linen',
                'color_options' => [['name' => 'Oat Linen', 'hex' => '#dbdcc3'], ['name' => 'Walnut Rail', 'hex' => '#72564c'], ['name' => 'Charcoal Linen', 'hex' => '#504441']],
                'image' => 'https://images.unsplash.com/photo-1617325247661-675ab4b64ae2?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A low platform bed with a soft upholstered headboard and calm wood proportions.',
                'details' => ['Queen and king sizes', 'Slatted mattress support', 'Optional under-bed storage'],
            ],
            [
                'slug' => 'harbor-nightstand',
                'name' => 'Harbor Nightstand',
                'category' => 'Bedroom',
                'sub_category' => 'Storage',
                'price' => 52000,
                'stock' => 22,
                'badge' => 'Ready',
                'material' => 'Oak veneer, brass pull',
                'color_options' => [['name' => 'Natural Oak', 'hex' => '#c8a978'], ['name' => 'Smoked Oak', 'hex' => '#5f5145'], ['name' => 'Ivory Lacquer', 'hex' => '#f1ead8']],
                'image' => 'https://images.unsplash.com/photo-1615873968403-89e068629265?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A compact bedside cabinet with a drawer, open shelf, and quiet rounded corners.',
                'details' => ['Soft-close drawer', 'Cable pass-through', 'Pair pricing available'],
            ],
            [
                'slug' => 'arc-dining-table',
                'name' => 'Arc Dining Table',
                'category' => 'Dining',
                'sub_category' => 'Furniture',
                'price' => 158000,
                'stock' => 10,
                'badge' => 'Signature',
                'material' => 'Solid ash, veneer top',
                'color_options' => [['name' => 'Honey Ash', 'hex' => '#b98f5c'], ['name' => 'Dark Walnut', 'hex' => '#4b3328'], ['name' => 'Black Ash', 'hex' => '#303221']],
                'image' => 'https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=1200&q=80',
                'description' => 'An oval dining table with softened legs for everyday meals and hosted evenings.',
                'details' => ['Seats 6 comfortably', 'Rounded family-friendly edge', 'Matte protective finish'],
            ],
            [
                'slug' => 'linen-dining-pendant',
                'name' => 'Linen Dining Pendant',
                'category' => 'Dining',
                'sub_category' => 'Lighting',
                'price' => 38000,
                'stock' => 28,
                'badge' => 'Ready',
                'material' => 'Linen shade, brushed metal',
                'color_options' => [['name' => 'Warm White', 'hex' => '#fbfbe2'], ['name' => 'Brass', 'hex' => '#b08a4a'], ['name' => 'Graphite', 'hex' => '#303221']],
                'image' => 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A softly diffused pendant scaled for dining tables and kitchen breakfast corners.',
                'details' => ['Adjustable drop length', 'Warm LED compatible', 'Single or cluster install'],
            ],
            [
                'slug' => 'atelier-work-desk',
                'name' => 'Atelier Work Desk',
                'category' => 'Office',
                'sub_category' => 'Furniture',
                'price' => 118000,
                'stock' => 16,
                'badge' => 'New In',
                'material' => 'Oak, powder-coated steel',
                'color_options' => [['name' => 'Natural Oak', 'hex' => '#c8a978'], ['name' => 'Black Frame', 'hex' => '#303221'], ['name' => 'Clay Top', 'hex' => '#b9a392']],
                'image' => 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A focused work desk with cable control, shallow storage, and a generous writing surface.',
                'details' => ['Hidden cable tray', 'Soft-close pencil drawer', 'Pairs with task lights'],
            ],
            [
                'slug' => 'halo-task-chair',
                'name' => 'Halo Task Chair',
                'category' => 'Office',
                'sub_category' => 'Furniture',
                'price' => 68000,
                'stock' => 26,
                'badge' => 'Ergonomic',
                'material' => 'Molded shell, woven fabric',
                'color_options' => [['name' => 'Sage Fabric', 'hex' => '#8d967b'], ['name' => 'Stone Grey', 'hex' => '#827470'], ['name' => 'Black Base', 'hex' => '#303221']],
                'image' => 'https://images.unsplash.com/photo-1580480055273-228ff5388ef8?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A refined office chair with adjustable comfort and a residential silhouette.',
                'details' => ['Height and tilt adjustment', 'Quiet caster wheels', 'Breathable upholstered seat'],
            ],
            [
                'slug' => 'modular-play-storage',
                'name' => 'Modular Play Storage',
                'category' => 'Kids Play',
                'sub_category' => 'Storage',
                'price' => 46000,
                'stock' => 18,
                'badge' => 'Washable',
                'material' => 'Birch ply, low-VOC paint',
                'color_options' => [['name' => 'Cloud', 'hex' => '#f4efe1'], ['name' => 'Sage', 'hex' => '#9daa8f'], ['name' => 'Terracotta', 'hex' => '#bd765c']],
                'image' => 'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Open cubbies and soft bins for toys, books, and quick end-of-day resets.',
                'details' => ['Rounded child-safe edges', 'Stackable modules', 'Includes two fabric bins'],
            ],
            [
                'slug' => 'terra-balcony-set',
                'name' => 'Terra Balcony Set',
                'category' => 'Balcony',
                'sub_category' => 'Furniture',
                'price' => 72000,
                'stock' => 12,
                'badge' => 'Outdoor',
                'material' => 'Powder-coated aluminum, rope',
                'color_options' => [['name' => 'Olive', 'hex' => '#6f7652'], ['name' => 'Sand', 'hex' => '#c8b99f'], ['name' => 'Charcoal', 'hex' => '#303221']],
                'image' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A slim two-chair balcony set with a small round table for compact outdoor corners.',
                'details' => ['Weather-ready frame', 'Stackable chairs', 'UV-resistant rope weave'],
            ],
            [
                'slug' => 'calm-vanity-unit',
                'name' => 'Calm Vanity Unit',
                'category' => 'Toilet / Restroom',
                'sub_category' => 'Bathroom Fittings',
                'price' => 97000,
                'stock' => 9,
                'badge' => 'Project',
                'material' => 'Water-resistant ply, ceramic basin',
                'color_options' => [['name' => 'Ivory', 'hex' => '#f1ead8'], ['name' => 'Warm Walnut', 'hex' => '#72564c'], ['name' => 'Graphite', 'hex' => '#3f4035']],
                'image' => 'https://images.unsplash.com/photo-1620626011761-996317b8d101?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A wall-mounted vanity with concealed storage and an integrated ceramic basin.',
                'details' => ['Moisture-resistant build', 'Soft-close storage', 'Wall-hung installation'],
            ],
            [
                'slug' => 'linear-kitchen-shelf',
                'name' => 'Linear Kitchen Shelf',
                'category' => 'Kitchen',
                'sub_category' => 'Storage',
                'price' => 34000,
                'stock' => 21,
                'badge' => 'Ready',
                'material' => 'Oak, blackened steel',
                'color_options' => [['name' => 'Oak', 'hex' => '#c8a978'], ['name' => 'Black Steel', 'hex' => '#303221'], ['name' => 'Cream Rail', 'hex' => '#fbfbe2']],
                'image' => 'https://images.unsplash.com/photo-1556912167-f556f1f39fdf?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A utility shelf for ceramics, jars, cookbooks, and quiet kitchen display.',
                'details' => ['Wall-mounted brackets', 'Two shelf lengths', 'Works above counters'],
            ],
        ]);
    }

    public static function featured(): Collection
    {
        return self::products()->take(4);
    }

    public static function find(string $slug): array
    {
        return self::products()->firstWhere('slug', $slug) ?? self::products()->first();
    }

    public static function categories(): Collection
    {
        return collect([
            ['name' => 'Living Room', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBA1oHnwXMwcXwKfRWFf8KGuZW9xRgJwhcRWToa3Ibm9Lbb_AjnjwFkHSGTPOhmzyFwBMiQkCR0agD_og-JVNjTFPAgaFe26VBgwJ08o1q6aXfmx2Cfr4QqwaG79irGTJG0JMX415_3HY3oWC9adUtdr2GM_Wjxgigg7G_z-IuCnCOYqv5gf9L-EA2qJVQK_0l2YLjqbvRUujh-A0lcTaAsef8HIDHG6ufwPB1SU9T6_jZ5X1wcdaMfaPs2kqP4zduguxUqDu9sj3o'],
            ['name' => 'Bedroom', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCemuGodnLJ8y1sU7FkM84vX3D97u3r6WErGPpAqyV2keyuzfe_FH8P10-z7pzvTxO7krWijPJACmYbZiZqrInAEtYE6OpKkjo8YjeBrE1R59CT_tEeyXXtqXgHymQlz-KyfyaXxrQnaUSQKJ7QbUBS-xRVUAQyImu9IIWqzJaVIseEQEqQ-ioXezFF99gpKUec0mDq7lvBsDdYJR2O0pqiC8q2RteImgQIPe1-NyR7bmsLRclbCqVLW_jlO5n6PMsmgBo_DZqgedk'],
            ['name' => 'Dining', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDSKVJnTrsLcOlIBm1lLzwBF6FYpYYibebA7w50LlI9NNK5IuLW6ZdAiZ2MYU09kaM869bAne3sH_V0Az3GYlw9hBJ2qR9FiFiaPe5ckSdHJmcIaKQncoLV6EpnUh59H3xruGiGSqFIemFpUfwLyCErzUyGvtPblhi5b3S57Dxc7OXBUKiD-mfoeBt3i04UY_jWcNsOHfkC5vhOc2Ll6fBYV_sDI5a7CnPACXvWkMrQ20tHAYq4Aa6_EJtStJoMm4O2kEvuU2eqsb0'],
            ['name' => 'Office', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAK97lvzMH2kDYkLtKYncIVC8Wxxyb99kaib9fEQtOt7ZchnZKvYhBuNsPKziWQVHHmBuEref_oAgHE31w7312Jaw0LZKmBUOxWsuzfHdjFFf68Rko3HkxGtpPtY6OUPMboxftIOhQnXCkMDxNDDSEa5nzhwD63I7CueVPBZYk2nhAPIQPmrfL9MY2RlHvE8g6LiFVA904JpYix_qKouBFDg3-WIS5LfYd0XpuewOJAJPrehnB2DYoEiXI5bv_-jW8SJQfHWa2Rua4'],
        ])->map(fn (array $category) => $category + ['slug' => self::categorySlug($category['name'])]);
    }

    public static function categorySlug(string $category): string
    {
        return str($category)->slug()->toString();
    }

    public static function categoryFromSlug(string $slug): ?string
    {
        return collect(self::roomCategories())
            ->first(fn (string $category) => self::categorySlug($category) === $slug);
    }

    public static function roomCategories(): array
    {
        return ['Living Room', 'Dining', 'Bedroom', 'Office', 'Kids Play', 'Toilet / Restroom', 'Kitchen', 'Balcony'];
    }

    public static function productCategories(): Collection
    {
        return collect([
            ['name' => 'Storage & organisation', 'sub_category' => 'Storage', 'image' => 'https://images.unsplash.com/photo-1595428774223-ef52624120d2?auto=format&fit=crop&w=700&q=80'],
            ['name' => 'Sofas & armchairs', 'sub_category' => 'Furniture', 'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=700&q=80'],
            ['name' => 'Office furniture & gaming', 'sub_category' => 'Furniture', 'category' => 'Office', 'image' => 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?auto=format&fit=crop&w=700&q=80'],
            ['name' => 'Beds & mattresses', 'sub_category' => 'Furniture', 'category' => 'Bedroom', 'image' => 'https://images.unsplash.com/photo-1617325247661-675ab4b64ae2?auto=format&fit=crop&w=700&q=80'],
            ['name' => 'Tables & chairs', 'sub_category' => 'Furniture', 'category' => 'Dining', 'image' => 'https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=700&q=80'],
            ['name' => 'Kitchenware & tableware', 'category' => 'Kitchen', 'image' => 'https://images.unsplash.com/photo-1556911220-bff31c812dba?auto=format&fit=crop&w=700&q=80'],
            ['name' => 'Curtains & blinds', 'sub_category' => 'Curtains', 'image' => 'https://images.unsplash.com/photo-1616486029423-aaa4789e8c9a?auto=format&fit=crop&w=700&q=80'],
            ['name' => 'Home textiles', 'sub_category' => 'Textiles', 'image' => 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=700&q=80'],
            ['name' => 'Home decor', 'sub_category' => 'Decor', 'image' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=700&q=80'],
        ])->map(function (array $category) {
            $params = array_filter([
                'category' => $category['category'] ?? null,
                'sub_category' => $category['sub_category'] ?? null,
            ]);

            return $category + ['url' => route('shop', $params)];
        });
    }

    public static function subCategories(): array
    {
        return ['Furniture', 'Lighting', 'Decor', 'Textiles', 'Curtains', 'Storage', 'Wall Art', 'Bathroom Fittings'];
    }
}
