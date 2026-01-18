@php
    $isEn = app()->getLocale() === 'en';
@endphp

<main class="public-offer container mx-auto px-4 md:px-12 py-12 text-zinc-800">
    <div class="max-w-4xl mx-auto space-y-10">
        @if ($isEn)
            <header class="offer-hero">
                <h1 class="text-3xl md:text-4xl font-bold leading-tight">PUBLIC OFFER AGREEMENT</h1>
                <p class="text-base md:text-lg leading-7 text-zinc-700">
                    for ordering, purchase, and delivery of goods
                </p>
            </header>

            <section class="space-y-4">
                <h2 class="text-xl md:text-2xl font-bold">Payment and delivery</h2>
                <p class="text-base leading-7">
                    The LEND GROU online store sells and delivers peat briquettes throughout Ukraine.
                    Goods are sold by the sole proprietor (FOP) Kravchuk Olena Anatoliivna.
                </p>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Payment</h3>
                <p class="text-base leading-7">You can pay for your order using one of the following methods:</p>
                <ul class="list-disc pl-5 space-y-2 text-base leading-7">
                    <li>Online payment by Visa / MasterCard via LiqPay.</li>
                    <li>Prepayment to bank account (IBAN) by agreement.</li>
                </ul>
                <div class="rounded-2xl bg-zinc-100 p-4 text-sm md:text-base leading-6">
                    <p class="font-semibold">Payment details:</p>
                    <p>Recipient: FOP Kravchuk Olena Anatoliivna</p>
                    <p>EDRPOU: 3371810641</p>
                    <p>IBAN: UA553052990000026004010713795</p>
                    <p>Bank: JSC CB PRIVATBANK</p>
                </div>
                <p class="text-base leading-7">
                    By making a payment you automatically agree to the terms of the LEND GROU online store.
                </p>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Product range</h3>
                <p class="text-base leading-7">Available products:</p>
                <ul class="list-disc pl-5 space-y-2 text-base leading-7">
                    <li>Peat briquettes — 10 kg box</li>
                    <li>Peat briquettes — 20 kg box</li>
                </ul>
                <p class="text-base leading-7">All in-stock items are available for ordering.</p>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Delivery</h3>
                <p class="text-base leading-7">
                    Delivery across Ukraine is provided by Nova Poshta and Ukrposhta.
                </p>
                <p class="text-base leading-7">
                    Delivery time: 1–5 business days from confirmation and payment
                    (Monday–Friday, excluding holidays).
                </p>
                <p class="text-base leading-7">Shipments are sent Monday to Friday.</p>
                <p class="text-base leading-7">
                    After dispatch you will receive a tracking number from the carrier.
                </p>
                <p class="text-base leading-7">
                    Attention: free storage at Nova Poshta is 5 days, after which the parcel is returned to the sender.
                    Delivery cost is paid by the buyer according to carrier tariffs.
                </p>
                <p class="text-base leading-7">
                    Please carefully check your contact details when placing an order.
                </p>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Exchange and returns</h3>
                <p class="text-base leading-7">
                    Before placing an order, please read the exchange and return terms.
                    By paying for an order you confirm your agreement with these terms.
                </p>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Product inspection</h3>
                <p class="text-base leading-7">Please check the product upon receipt for:</p>
                <ul class="list-disc pl-5 space-y-2 text-base leading-7">
                    <li>package integrity</li>
                    <li>absence of mechanical damage</li>
                </ul>
                <p class="text-base leading-7">
                    Claims for damage found after leaving the post office are not accepted.
                </p>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Returns</h3>
                <p class="text-base leading-7">
                    Returns are possible within 14 calendar days of receipt provided that:
                </p>
                <ul class="list-disc pl-5 space-y-2 text-base leading-7">
                    <li>the product has not been used</li>
                    <li>the product appearance and packaging are preserved</li>
                    <li>return shipping costs are paid by the buyer</li>
                </ul>
                <p class="text-base leading-7">
                    Refunds are issued within 7 business days after receiving and inspecting the product,
                    to the account used for payment.
                </p>
                <p class="text-base leading-7">Returns and exchanges are only within Ukraine.</p>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Contact information</h3>
                <p class="text-base leading-7">
                    For all questions about orders, delivery, or returns, please contact us using the
                    channels listed on the LEND GROU website.
                </p>
            </section>

            <section class="space-y-6">
                <h2 class="text-xl md:text-2xl font-bold">Public offer agreement</h2>
                <p class="text-base leading-7">
                    This agreement is the official public offer by the Seller to conclude a sales agreement
                    for goods presented on the LEND GROU online store. Under Article 633 of the Civil Code of Ukraine,
                    this Agreement is public and applies equally to all Buyers regardless of status
                    (individual, legal entity, or sole proprietor).
                </p>
                <p class="text-base leading-7">
                    Placing an order on the website means the Buyer fully and unconditionally accepts these terms,
                    including order placement, payment, delivery, returns, and liability of the parties.
                </p>
                <p class="text-base leading-7">
                    The Agreement is considered concluded at the moment the Buyer clicks “Confirm Order” on the checkout
                    page and receives electronic confirmation.
                </p>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">1. Definitions</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>Public offer — a public proposal by the Seller to conclude a remote sales agreement.</li>
                    <li>Goods — peat briquettes (10 kg box, 20 kg box) presented on the LEND GROU website.</li>
                    <li>Online store — the Seller's website LEND GROU for remote commerce.</li>
                    <li>Buyer — a capable individual aged 18+, or a legal entity / FOP placing an order.</li>
                    <li>Seller — FOP Kravchuk Olena Anatoliivna, EDRPOU: 3371810641.</li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">2. Subject of the agreement</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>The Seller undertakes to transfer the Goods into the Buyer's ownership, and the Buyer undertakes to pay for and accept them under this Agreement.</li>
                    <li>The acceptance date of the offer is the date of ordering and receiving confirmation.</li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">3. Order placement</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>The Buyer places the order independently on the LEND GROU website.</li>
                    <li>The Seller may refuse to fulfill an order if the Buyer provided inaccurate or incomplete data.</li>
                    <li>Required information:
                        <ul class="list-disc pl-5 mt-2 space-y-2">
                            <li>Buyer full name</li>
                            <li>contact phone number</li>
                            <li>delivery address</li>
                        </ul>
                    </li>
                    <li>The Buyer is responsible for the accuracy of the provided data.</li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">4. Price and delivery</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>Prices are listed on the website in UAH.</li>
                    <li>Delivery cost is not included in the price and is paid separately according to carrier tariffs.</li>
                    <li>Delivery within Ukraine is provided by Nova Poshta.</li>
                    <li>Buyer payment obligations are considered fulfilled upon receipt of funds to the Seller's account.</li>
                    <li>The Buyer must check the integrity and quantity of the goods upon receipt.</li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">5. Rights and obligations</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>The Seller must:
                        <ul class="list-disc pl-5 mt-2 space-y-2">
                    <li>deliver goods of proper quality</li>
                            <li>not disclose the Buyer's personal data</li>
                        </ul>
                    </li>
                    <li>The Seller has the right to:
                        <ul class="list-disc pl-5 mt-2 space-y-2">
                            <li>change agreement terms and prices by publishing on the site</li>
                        </ul>
                    </li>
                    <li>The Buyer must:
                        <ul class="list-disc pl-5 mt-2 space-y-2">
                            <li>review the terms before placing an order</li>
                            <li>provide correct contact information</li>
                        </ul>
                    </li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">6. Returns</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>The Buyer may return goods of proper quality within 14 calendar days of receipt.</li>
                    <li>Returns are possible if:
                        <ul class="list-disc pl-5 mt-2 space-y-2">
                            <li>the goods were not used</li>
                            <li>product appearance and packaging are preserved</li>
                        </ul>
                    </li>
                    <li>Return shipping costs are paid by the Buyer.</li>
                    <li>Refunds are issued within 7 business days from receipt by the Seller.</li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">7. Liability</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>Parties are liable under the applicable laws of Ukraine.</li>
                    <li>The Seller is not liable for delivery delays caused by carriers or force majeure.</li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">8. Privacy and personal data</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>By placing an order, the Buyer agrees to personal data processing under Ukrainian law.</li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">9. Other terms</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>This Agreement is governed by the laws of Ukraine.</li>
                    <li>Disputes are resolved by negotiation or in court if needed.</li>
                </ol>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Seller address and details</h3>
                <div class="rounded-2xl bg-zinc-100 p-4 text-sm md:text-base leading-6">
                    <p>FOP Kravchuk Olena Anatoliivna</p>
                    <p>EDRPOU: 3371810641</p>
                    <p>IBAN: UA553052990000026004010713795</p>
                    <p>Bank: JSC CB PRIVATBANK</p>
                </div>
            </section>
        @else
            <header class="offer-hero">
                <h1 class="text-3xl md:text-4xl font-bold leading-tight">
                    ПУБЛІЧНИЙ ДОГОВІР (ОФЕРТА)
                </h1>
                <p class="text-base md:text-lg leading-7 text-zinc-700">
                    на замовлення, купівлю-продаж і доставку товарів
                </p>
            </header>

            <section class="space-y-4">
                <h2 class="text-xl md:text-2xl font-bold">Оплата і доставка</h2>
                <p class="text-base leading-7">
                    Інтернет-магазин «ЛЕНД ГРОУ» здійснює продаж та доставку торфобрикетів по всій
                    території України. Продаж товару здійснюється фізичною особою — підприємцем
                    ФОП Кравчук Олена Анатоліївна.
                </p>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Оплата</h3>
                <p class="text-base leading-7">Оплатити замовлення ви можете одним із наступних способів:</p>
                <ul class="list-disc pl-5 space-y-2 text-base leading-7">
                    <li>Онлайн-оплата банківською карткою Visa / MasterCard через LiqPay.</li>
                    <li>Передоплата на розрахунковий рахунок (IBAN) — за домовленістю.</li>
                </ul>
                <div class="rounded-2xl bg-zinc-100 p-4 text-sm md:text-base leading-6">
                    <p class="font-semibold">Реквізити для оплати:</p>
                    <p>Отримувач: ФОП Кравчук Олена Анатоліївна</p>
                    <p>ЄДРПОУ: 3371810641</p>
                    <p>Рахунок IBAN: UA553052990000026004010713795</p>
                    <p>Банк: АТ КБ «ПРИВАТБАНК»</p>
                </div>
                <p class="text-base leading-7">
                    Під час здійснення оплати ви автоматично погоджуєтесь з умовами роботи
                    інтернет-магазину «ЛЕНД ГРОУ».
                </p>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Асортимент</h3>
                <p class="text-base leading-7">У продажу представлені:</p>
                <ul class="list-disc pl-5 space-y-2 text-base leading-7">
                    <li>Торфобрикет — коробка 10 кг</li>
                    <li>Торфобрикет — коробка 20 кг</li>
                </ul>
                <p class="text-base leading-7">
                    Усі товари зі статусом «В наявності» доступні для замовлення.
                </p>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Доставка</h3>
                <p class="text-base leading-7">
                    Доставка здійснюється по Україні службою «Нова Пошта», «Укрпошта».
                </p>
                <p class="text-base leading-7">
                    Термін доставки: 1–5 робочих днів з моменту підтвердження та оплати замовлення
                    (понеділок – п’ятниця, без урахування святкових днів).
                </p>
                <p class="text-base leading-7">Відправлення здійснюються з понеділка по п’ятницю.</p>
                <p class="text-base leading-7">
                    Після відправлення ви отримаєте номер товарно-транспортної накладної від перевізника.
                </p>
                <p class="text-base leading-7">
                    Увага! Термін безкоштовного зберігання посилки у відділенні «Нової Пошти» — 5 днів,
                    після чого посилка повертається відправнику. Вартість доставки оплачується покупцем
                    згідно з тарифами перевізника.
                </p>
                <p class="text-base leading-7">
                    Просимо уважно перевіряти коректність контактних даних під час оформлення замовлення.
                </p>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Обмін та повернення</h3>
                <p class="text-base leading-7">
                    Перед оформленням замовлення просимо ознайомитись з умовами обміну та повернення.
                    Оплачуючи замовлення, ви підтверджуєте згоду з цими умовами.
                </p>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Перевірка товару</h3>
                <p class="text-base leading-7">
                    Просимо обов’язково перевіряти товар при отриманні у відділенні пошти на:
                </p>
                <ul class="list-disc pl-5 space-y-2 text-base leading-7">
                    <li>цілісність упаковки</li>
                    <li>відсутність механічних пошкоджень</li>
                </ul>
                <p class="text-base leading-7">
                    Претензії щодо пошкоджень, виявлених після отримання товару за межами відділення пошти,
                    не приймаються.
                </p>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Повернення товару</h3>
                <p class="text-base leading-7">
                    Повернення можливе протягом 14 календарних днів з моменту отримання товару за умови:
                </p>
                <ul class="list-disc pl-5 space-y-2 text-base leading-7">
                    <li>товар не був у використанні</li>
                    <li>збережено товарний вигляд та упаковку</li>
                    <li>витрати на доставку повернення здійснюються за рахунок покупця</li>
                </ul>
                <p class="text-base leading-7">
                    Повернення коштів здійснюється протягом 7 робочих днів після отримання та перевірки
                    товару, на рахунок, з якого було здійснено оплату.
                </p>
                <p class="text-base leading-7">Повернення та обмін здійснюються лише на території України.</p>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Контакти для зв’язку</h3>
                <p class="text-base leading-7">
                    З усіх питань щодо замовлень, доставки чи повернення просимо звертатися через доступні
                    канали зв’язку, вказані на сайті магазину «ЛЕНД ГРОУ».
                </p>
            </section>

            <section class="space-y-6">
                <h2 class="text-xl md:text-2xl font-bold">Публічний договір (оферта)</h2>
                <p class="text-base leading-7">
                    Цей договір є офіційною та публічною пропозицією Продавця укласти договір
                    купівлі-продажу товарів, представлених на сайті інтернет-магазину «ЛЕНД ГРОУ».
                    Відповідно до статті 633 Цивільного кодексу України, цей Договір є публічним, а його
                    умови є однаковими для всіх Покупців незалежно від їх статусу (фізична особа,
                    юридична особа, фізична особа-підприємець).
                </p>
                <p class="text-base leading-7">
                    Оформлення замовлення на сайті означає повне та беззастережне прийняття Покупцем умов
                    цього Договору, включаючи порядок оформлення замовлення, оплати, доставки, повернення
                    товару та відповідальності сторін.
                </p>
                <p class="text-base leading-7">
                    Договір вважається укладеним з моменту натискання кнопки «Підтвердити замовлення» на
                    сторінці оформлення замовлення та отримання Покупцем підтвердження замовлення в
                    електронному вигляді.
                </p>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">1. Визначення термінів</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>Публічна оферта — публічна пропозиція Продавця укласти договір купівлі-продажу товару дистанційним способом.</li>
                    <li>Товар — торфобрикети (коробка 10 кг, коробка 20 кг), представлені на сайті інтернет-магазину «ЛЕНД ГРОУ».</li>
                    <li>Інтернет-магазин — вебсайт продавця «ЛЕНД ГРОУ», створений для здійснення дистанційної торгівлі.</li>
                    <li>Покупець — дієздатна фізична особа, яка досягла 18 років, або юридична особа / ФОП, що оформлює замовлення.</li>
                    <li>Продавець — ФОП Кравчук Олена Анатоліївна, ЄДРПОУ: 3371810641.</li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">2. Предмет Договору</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>Продавець зобов’язується передати у власність Покупцю Товар, а Покупець зобов’язується оплатити та прийняти його на умовах цього Договору.</li>
                    <li>Датою акцепту Оферти вважається дата оформлення замовлення на сайті та отримання підтвердження замовлення.</li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">3. Оформлення замовлення</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>Покупець самостійно оформлює замовлення через сайт інтернет-магазину «ЛЕНД ГРОУ».</li>
                    <li>Продавець має право відмовити у виконанні замовлення у разі надання Покупцем недостовірних або неповних даних.</li>
                    <li>Обов’язкова інформація для оформлення замовлення:
                        <ul class="list-disc pl-5 mt-2 space-y-2">
                            <li>ім’я та прізвище Покупця</li>
                            <li>контактний телефон</li>
                            <li>адреса доставки</li>
                        </ul>
                    </li>
                    <li>Покупець несе відповідальність за достовірність наданих даних.</li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">4. Ціна та доставка товару</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>Ціни на товар вказані на сайті у гривнях.</li>
                    <li>Вартість доставки не включена у вартість товару та оплачується Покупцем окремо згідно з тарифами перевізника.</li>
                    <li>Доставка здійснюється по Україні службою «Нова Пошта».</li>
                    <li>Зобов’язання Покупця з оплати вважаються виконаними з моменту надходження коштів на рахунок Продавця.</li>
                    <li>Під час отримання товару Покупець зобов’язаний перевірити його цілісність та кількість у відділенні перевізника.</li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">5. Права та обов’язки сторін</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>Продавець зобов’язаний:
                        <ul class="list-disc pl-5 mt-2 space-y-2">
                            <li>передати товар належної якості</li>
                            <li>не розголошувати персональні дані Покупця</li>
                        </ul>
                    </li>
                    <li>Продавець має право:
                        <ul class="list-disc pl-5 mt-2 space-y-2">
                            <li>змінювати умови Договору та ціни шляхом публікації на сайті</li>
                        </ul>
                    </li>
                    <li>Покупець зобов’язаний:
                        <ul class="list-disc pl-5 mt-2 space-y-2">
                            <li>ознайомитися з умовами Договору перед оформленням замовлення</li>
                            <li>надати коректні контактні дані</li>
                        </ul>
                    </li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">6. Повернення товару</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>Покупець має право на повернення товару належної якості протягом 14 календарних днів з моменту отримання.</li>
                    <li>Повернення можливе за умови:
                        <ul class="list-disc pl-5 mt-2 space-y-2">
                            <li>товар не був у використанні</li>
                            <li>збережено товарний вигляд та упаковку</li>
                        </ul>
                    </li>
                    <li>Витрати на повернення товару здійснюються за рахунок Покупця.</li>
                    <li>Повернення коштів здійснюється протягом 7 робочих днів з моменту отримання товару Продавцем.</li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">7. Відповідальність</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>Сторони несуть відповідальність відповідно до чинного законодавства України.</li>
                    <li>Продавець не несе відповідальності за затримки доставки з вини перевізника або форс-мажорних обставин.</li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">8. Конфіденційність та персональні дані</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>Оформлюючи замовлення, Покупець надає згоду на обробку своїх персональних даних відповідно до Закону України «Про захист персональних даних».</li>
                </ol>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg md:text-xl font-bold">9. Інші умови</h3>
                <ol class="list-decimal pl-5 space-y-2 text-base leading-7">
                    <li>Договір укладено та діє відповідно до законодавства України.</li>
                    <li>Усі спори вирішуються шляхом переговорів, а у разі недосягнення згоди — у судовому порядку.</li>
                </ol>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg md:text-xl font-bold">Адреса та реквізити продавця</h3>
                <div class="rounded-2xl bg-zinc-100 p-4 text-sm md:text-base leading-6">
                    <p>ФОП Кравчук Олена Анатоліївна</p>
                    <p>ЄДРПОУ: 3371810641</p>
                    <p>Рахунок IBAN: UA553052990000026004010713795</p>
                    <p>Банк: АТ КБ «ПРИВАТБАНК»</p>
                </div>
            </section>
        @endif
    </div>
    <style>
    .public-offer .offer-hero {
        border-radius: 28px;
        padding: 32px;
        color: #ffffff;
        background: linear-gradient(135deg, #18181b 0%, #27272a 45%, #3f3f46 100%);
        box-shadow: 0 20px 60px -40px rgba(0, 0, 0, 0.9);
    }

    .public-offer .offer-hero h1 {
        margin-top: 12px;
    }

    .public-offer .offer-hero p {
        margin-top: 12px;
        color: rgba(228, 228, 231, 0.95);
    }

    .public-offer section {
        margin-top: 32px;
        border-radius: 24px;
        padding: 24px;
        border: 1px solid #e4e4e7;
        background: #ffffff;
        box-shadow: 0 12px 40px -30px rgba(0, 0, 0, 0.35);
    }

    .public-offer section > p,
    .public-offer section > ul,
    .public-offer section > ol,
    .public-offer section > div {
        margin-top: 12px;
        color: #3f3f46;
    }

    .public-offer ul,
    .public-offer ol {
        padding-left: 20px;
    }

    .public-offer ul ul,
    .public-offer ol ul,
    .public-offer ol ol {
        margin-top: 8px;
    }

    @media (max-width: 768px) {
        .public-offer .offer-hero {
            padding: 24px;
        }

        .public-offer section {
            padding: 20px;
        }
    }
    </style>
</main>
