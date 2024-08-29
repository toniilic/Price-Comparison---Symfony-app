<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Vendor;
use App\Entity\Price;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create categories
        $electronics = new Category();
        $electronics->setName('Electronics');
        $electronics->setSlug('electronics');
        $manager->persist($electronics);

        $homeAppliances = new Category();
        $homeAppliances->setName('Home Appliances');
        $homeAppliances->setSlug('home-appliances');
        $manager->persist($homeAppliances);

        // Create vendors
        $amazonVendor = new Vendor();
        $amazonVendor->setName('Amazon');
        $amazonVendor->setWebsite('https://www.amazon.com');
        $manager->persist($amazonVendor);

        $bestBuyVendor = new Vendor();
        $bestBuyVendor->setName('Best Buy');
        $bestBuyVendor->setWebsite('https://www.bestbuy.com');
        $manager->persist($bestBuyVendor);

        // Create products with prices
        $products = [
            [
                'name' => 'iPhone 13 Pro',
                'description' => 'The latest iPhone with advanced features',
                'imageUrl' => 'https://placehold.co/600x400?text=iPhone+13+Pro',
                'category' => $electronics,
                'prices' => [
                    [$amazonVendor, 999.99],
                    [$bestBuyVendor, 1009.99],
                ],
            ],
            [
                'name' => 'Samsung 55" QLED TV',
                'description' => '4K Ultra HD Smart TV with amazing picture quality',
                'imageUrl' => 'https://placehold.co/600x400?text=Samsung+TV',
                'category' => $electronics,
                'prices' => [
                    [$amazonVendor, 799.99],
                    [$bestBuyVendor, 789.99],
                ],
            ],
            [
                'name' => 'Dyson V11 Vacuum',
                'description' => 'Cordless stick vacuum with powerful suction',
                'imageUrl' => 'https://placehold.co/600x400?text=Dyson+Vacuum',
                'category' => $homeAppliances,
                'prices' => [
                    [$amazonVendor, 499.99],
                    [$bestBuyVendor, 489.99],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setDescription($productData['description']);
            $product->setImageUrl($productData['imageUrl']);
            $product->setCategory($productData['category']);
            $manager->persist($product);

            foreach ($productData['prices'] as $priceData) {
                $price = new Price();
                $price->setProduct($product);
                $price->setVendor($priceData[0]);
                $price->setPrice($priceData[1]);
                $manager->persist($price);
            }
        }

        $manager->flush();
    }
}
