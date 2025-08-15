<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info('Starting to seed blog posts...');

        $blogPosts = [
            [
                'title' => [
                    'en' => 'The Future of E-commerce: Trends to Watch in 2025',
                    'uk' => 'Майбутнє електронної комерції: тренди 2025 року',
                ],
                'slug' => 'future-of-ecommerce-trends-2025',
                'excerpt' => [
                    'en' => 'Discover the latest trends shaping the e-commerce industry and how they will impact online businesses in 2025.',
                    'uk' => 'Відкрийте для себе останні тренди, що формують індустрію електронної комерції та як вони вплинуть на онлайн-бізнес у 2025 році.',
                ],
                'content' => [
                    'en' => '<h2>Introduction</h2><p>The e-commerce landscape is constantly evolving, and 2025 promises to bring exciting new developments. From AI-powered personalization to sustainable shopping practices, businesses need to stay ahead of the curve.</p><h2>Key Trends</h2><p><strong>1. AI and Machine Learning Integration</strong></p><p>Artificial intelligence will continue to revolutionize how customers shop online, with smarter recommendations and personalized experiences.</p><p><strong>2. Sustainability Focus</strong></p><p>Consumers are increasingly conscious about environmental impact, driving demand for eco-friendly products and sustainable packaging.</p><p><strong>3. Mobile Commerce Growth</strong></p><p>Mobile shopping will dominate, with improved mobile experiences and faster checkout processes.</p>',
                    'uk' => '<h2>Вступ</h2><p>Ландшафт електронної комерції постійно розвивається, і 2025 рік обіцяє принести захоплюючі нові розробки. Від персоналізації на основі штучного інтелекту до сталих практик покупок, бізнес повинен випереджати тенденції.</p><h2>Ключові тренди</h2><p><strong>1. Інтеграція ШІ та машинного навчання</strong></p><p>Штучний інтелект продовжить революціонізувати спосіб, яким клієнти роблять покупки онлайн, пропонуючи розумніші рекомендації та персоналізований досвід.</p><p><strong>2. Фокус на сталість</strong></p><p>Споживачі все більше усвідомлюють вплив на навколишнє середовище, що стимулює попит на екологічно чисті продукти та стале пакування.</p><p><strong>3. Зростання мобільної комерції</strong></p><p>Мобільні покупки будуть домінувати з покращеним мобільним досвідом та швидшими процесами оформлення замовлень.</p>',
                ],
                'seo_title' => [
                    'en' => 'E-commerce Trends 2025 | Future of Online Shopping',
                    'uk' => 'Тренди електронної комерції 2025 | Майбутнє онлайн-покупок',
                ],
                'seo_description' => [
                    'en' => 'Explore the top e-commerce trends for 2025 including AI integration, sustainability, and mobile commerce growth.',
                    'uk' => 'Досліджуйте топ-тренди електронної комерції на 2025 рік, включаючи інтеграцію ШІ, сталість та зростання мобільної комерції.',
                ],
                'published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => [
                    'en' => 'How to Choose the Perfect Product for Your Needs',
                    'uk' => 'Як обрати ідеальний продукт для ваших потреб',
                ],
                'slug' => 'how-to-choose-perfect-product',
                'excerpt' => [
                    'en' => 'A comprehensive guide to help you make informed purchasing decisions and find products that truly meet your requirements.',
                    'uk' => 'Комплексний посібник, який допоможе вам приймати обґрунтовані рішення щодо покупок і знаходити продукти, які справді відповідають вашим вимогам.',
                ],
                'content' => [
                    'en' => '<h2>Research Before You Buy</h2><p>Before making any purchase, it\'s essential to research thoroughly. Read reviews, compare features, and understand your specific needs.</p><h2>Consider Your Budget</h2><p>Set a realistic budget and stick to it. Remember that the most expensive option isn\'t always the best for your specific situation.</p><h2>Check Return Policies</h2><p>Always review the return policy before purchasing. This gives you peace of mind and protection if the product doesn\'t meet your expectations.</p>',
                    'uk' => '<h2>Досліджуйте перед купівлею</h2><p>Перед будь-якою покупкою необхідно ретельно дослідити. Читайте відгуки, порівнюйте характеристики і зрозумійте свої специфічні потреби.</p><h2>Розгляньте свій бюджет</h2><p>Встановіть реалістичний бюджет і дотримуйтеся його. Памятайте, що найдорожчий варіант не завжди найкращий для вашої конкретної ситуації.</p><h2>Перевірте політику повернення</h2><p>Завжди переглядайте політику повернення перед покупкою. Це дає вам спокій і захист, якщо продукт не відповідає вашим очікуванням.</p>',
                ],
                'seo_title' => [
                    'en' => 'Product Selection Guide | How to Choose Wisely',
                    'uk' => 'Посібник вибору продукту | Як обирати розумно',
                ],
                'seo_description' => [
                    'en' => 'Learn how to choose the perfect product with our comprehensive buying guide covering research, budget, and return policies.',
                    'uk' => 'Дізнайтеся, як обрати ідеальний продукт за допомогою нашого комплексного посібника з покупок.',
                ],
                'published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => [
                    'en' => 'Customer Service Excellence: What We Do Differently',
                    'uk' => 'Досконалість обслуговування клієнтів: що ми робимо по-іншому',
                ],
                'slug' => 'customer-service-excellence',
                'excerpt' => [
                    'en' => 'Discover our commitment to exceptional customer service and what sets us apart from the competition.',
                    'uk' => 'Відкрийте нашу відданість винятковому обслуговуванню клієнтів і те, що відрізняє нас від конкурентів.',
                ],
                'content' => [
                    'en' => '<h2>Our Philosophy</h2><p>Customer satisfaction is at the heart of everything we do. We believe that excellent service creates lasting relationships and trust.</p><h2>24/7 Support</h2><p>Our customer support team is available around the clock to assist with any questions or concerns you may have.</p><h2>Quick Response Times</h2><p>We pride ourselves on responding to customer inquiries within 1 hour during business hours and within 4 hours outside of business hours.</p>',
                    'uk' => '<h2>Наша філософія</h2><p>Задоволення клієнтів — серце всього, що ми робимо. Ми віримо, що видатне обслуговування створює тривалі стосунки і довіру.</p><h2>Підтримка 24/7</h2><p>Наша команда підтримки клієнтів доступна цілодобово, щоб допомогти з будь-якими питаннями чи проблемами.</p><h2>Швидкий час відповіді</h2><p>Ми пишаємося тим, що відповідаємо на запити клієнтів протягом 1 години у робочий час і протягом 4 годин поза робочим часом.</p>',
                ],
                'seo_title' => [
                    'en' => 'Exceptional Customer Service | Our Commitment',
                    'uk' => 'Виняткове обслуговування клієнтів | Наші зобовязання',
                ],
                'seo_description' => [
                    'en' => 'Learn about our customer service philosophy and 24/7 support commitment that sets us apart.',
                    'uk' => 'Дізнайтеся про нашу філософію обслуговування клієнтів і наші зобовязання щодо підтримки 24/7.',
                ],
                'published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => [
                    'en' => 'Seasonal Shopping Guide: Best Deals Throughout the Year',
                    'uk' => 'Посібник сезонних покупок: найкращі пропозиції протягом року',
                ],
                'slug' => 'seasonal-shopping-guide-best-deals',
                'excerpt' => [
                    'en' => 'Maximize your savings with our comprehensive guide to the best shopping seasons and deals throughout the year.',
                    'uk' => 'Максимізуйте свої заощадження за допомогою нашого комплексного посібника по найкращих сезонах покупок протягом року.',
                ],
                'content' => [
                    'en' => '<h2>Spring Sales</h2><p>Spring is perfect for home renovation and gardening supplies. Many retailers offer clearance sales on winter items.</p><h2>Summer Deals</h2><p>Look for outdoor gear, vacation essentials, and back-to-school items. Electronics often go on sale during summer months.</p><h2>Fall Shopping</h2><p>Fall brings excellent deals on clothing, appliances, and holiday preparation items.</p><h2>Winter Bargains</h2><p>The holiday season and post-holiday clearances offer some of the year\'s best deals across all categories.</p>',
                    'uk' => '<h2>Весняні розпродажі</h2><p>Весна ідеальна для товарів для ремонту будинку і садівництва. Багато продавців пропонують розпродажі зимових товарів.</p><h2>Літні пропозиції</h2><p>Шукайте спорядження для відпочинку на природі, необхідні речі для відпустки і шкільні товари. Електроніка часто продається зі знижкою в літні місяці.</p><h2>Осінні покупки</h2><p>Осінь приносить чудові пропозиції на одяг, побутову техніку і товари для підготовки до свят.</p><h2>Зимові знижки</h2><p>Святковий сезон і післясвяткові розпродажі пропонують одні з найкращих пропозицій року у всіх категоріях.</p>',
                ],
                'seo_title' => [
                    'en' => 'Seasonal Shopping Guide | Year-Round Deals & Savings',
                    'uk' => 'Посібник сезонних покупок | Пропозиції і заощадження',
                ],
                'seo_description' => [
                    'en' => 'Discover the best times to shop for maximum savings with our seasonal shopping guide covering all year round.',
                    'uk' => 'Відкрийте найкращі часи для покупок з максимальними заощадженнями за допомогою нашого сезонного посібника.',
                ],
                'published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => [
                    'en' => 'Technology Integration in Modern Retail',
                    'uk' => 'Інтеграція технологій у сучасній роздрібній торгівлі',
                ],
                'slug' => 'technology-integration-modern-retail',
                'excerpt' => [
                    'en' => 'Explore how cutting-edge technology is transforming the retail experience and what it means for consumers.',
                    'uk' => 'Дослідіть, як передові технології трансформують роздрібний досвід і що це означає для споживачів.',
                ],
                'content' => [
                    'en' => '<h2>Virtual Reality Shopping</h2><p>VR technology allows customers to experience products virtually before purchasing, revolutionizing online shopping.</p><h2>Augmented Reality Try-Ons</h2><p>AR enables customers to try products virtually, from clothing to furniture, reducing returns and increasing satisfaction.</p><h2>AI-Powered Recommendations</h2><p>Machine learning algorithms analyze customer behavior to provide personalized product recommendations.</p>',
                    'uk' => '<h2>Покупки у віртуальній реальності</h2><p>Технологія VR дозволяє клієнтам відчути продукти віртуально перед покупкою, революціонізуючи онлайн-покупки.</p><h2>Примірки в доповненій реальності</h2><p>AR дозволяє клієнтам віртуально примірювати продукти, від одягу до меблів, зменшуючи повернення і підвищуючи задоволення.</p><h2>Рекомендації на основі ШІ</h2><p>Алгоритми машинного навчання аналізують поведінку клієнтів для надання персоналізованих рекомендацій продуктів.</p>',
                ],
                'seo_title' => [
                    'en' => 'Retail Technology Trends | VR, AR & AI Integration',
                    'uk' => 'Тренди роздрібних технологій | Інтеграція VR, AR та ШІ',
                ],
                'seo_description' => [
                    'en' => 'Discover how VR, AR, and AI technologies are transforming modern retail and enhancing customer experience.',
                    'uk' => 'Дізнайтеся, як технології VR, AR та ШІ трансформують сучасну роздрібну торгівлю та покращують клієнтський досвід.',
                ],
                'published' => false, // Unpublished for testing
                'published_at' => null,
            ],
        ];

        foreach ($blogPosts as $postData) {
            BlogPost::create($postData);
        }

        Log::info('Finished seeding blog posts. Created ' . count($blogPosts) . ' blog posts.');
    }
}
